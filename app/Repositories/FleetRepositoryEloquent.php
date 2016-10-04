<?php

namespace App\Repositories;

use App\Entities\Vehicle;
use Illuminate\Support\Facades\Auth;
use App\Entities\Gps;
use App\Entities\TireSensor;

class FleetRepositoryEloquent extends VehicleRepositoryEloquent
{

    private function getFleetTireAndSensorData($updateDatetime = null, $vehicleId = null)
    {
        $sensors = TireSensor::select('tire_sensor.*', 'parts.position', 'parts.vehicle_id')
            ->join('parts', 'tire_sensor.part_id', '=', 'parts.id')
            ->join('types', 'parts.part_type_id', '=', 'types.id')
            ->whereNotNull('parts.vehicle_id')
            ->where('parts.company_id', Auth::user()['company_id'])
            ->where('types.name', 'sensor');
        
        if (!empty($updateDatetime)) {
            $sensors = $sensors->where('tire_sensor.created_at', '>', $updateDatetime);
        }

        if (!empty($vehicleId)) {
            $sensors = $sensors->where('parts.vehicle_id', $vehicleId);
        }
            
        $sensors = $sensors->orderBy('tire_sensor.created_at', 'asc')
            ->get();

        $tireAndSensorData = [];
        if (!empty($sensors)) {
            $tiresData = $this->getTiresWarningAndDanger();
            foreach ($sensors as $sensor) {
                $objTire = new \stdClass();
                $objTire->temperature = HelperRepository::manageEmptyValue($sensor->temperature);
                $objTire->pressure = HelperRepository::manageEmptyValue($sensor->pressure);
                $objTire->part_id = HelperRepository::manageEmptyValue($sensor->part_id);
                $objTire->position = HelperRepository::manageEmptyValue($sensor->position);
                
                $objTire = $this->setTiresColor($tiresData, $sensor, $objTire);
                
                $tireAndSensorData[$sensor->vehicle_id][$sensor->position] = $objTire;
            }
        }

        $objTire = new \stdClass();
        $objTire->temperature = "";
        $objTire->pressure = "";
        $objTire->color = "";
        $tireAndSensorData[0] = $objTire;
        
    
        return $tireAndSensorData;
    }

    private function setTiresColor($tiresData, $sensor, $objTire)
    {
        if (!empty($tiresData['parts'][$sensor->part_id])
            && ($sensor->pressure > $tiresData['dangerMaxPressure']
                || $sensor->pressure < $tiresData['dangerMinPressure']
                || $sensor->temperature > (int)config('app.tires_danger_temperature'))
            ) {
                $objTire->color = "red";
        } elseif (!empty($tiresData['parts'][$sensor->part_id])
            && ($sensor->pressure > $tiresData['warningMaxPressure']
                || $sensor->pressure < $tiresData['warningMinPressure']
                || $sensor->temperature > (int)config('app.tires_warning_temperature'))
            ) {
                $objTire->color = "yellow";
        } else {
            $objTire->color = "green";
        }
        
        return $objTire;
    }
    
    private function getTiresWarningAndDanger()
    {
        

//         $sensors = \DB::select('part_id', \DB::raw('AVG(temperature) as avg_temperature'))
//             ->from(
                
//                 TireSensor::select('part_id', 'temperature')
                
//                 ) as 't'
//             ->groupBy('part_id')
//             ->get();

        $sensorsReturn = [];

        $warningPressure = ((int)config('app.tires_warning_pressure_percentage') *
            (int)config('app.tires_ideal_pressure')) / 100;
        
        $sensorsReturn['warningMinPressure'] = (int)config('app.tires_ideal_pressure') - $warningPressure;
        $sensorsReturn['warningMaxPressure'] = (int)config('app.tires_ideal_pressure') + $warningPressure;

        $dangerPressure = ((int)config('app.tires_danger_pressure_percentage') *
            (int)config('app.tires_ideal_pressure')) / 100;
        
        $sensorsReturn['dangerMinPressure'] = (int)config('app.tires_ideal_pressure') - $dangerPressure;
        $sensorsReturn['dangerMaxPressure'] = (int)config('app.tires_ideal_pressure') + $dangerPressure;
             
        $sensors = \DB::select(\DB::raw('
            select part_id, avg(temperature) as avg_temperature, avg(pressure) as avg_pressure
            from (
            
                select part_id, temperature, pressure
                from tire_sensor
                where (
                    select count(*) from tire_sensor as p
                    where p.part_id = tire_sensor.part_id and p.created_at >= tire_sensor.created_at
                    ) <= 3
            ) as t
            group by part_id'));
        
        if (!empty($sensors)) {
            foreach ($sensors as $sensor) {
                $sensorsReturn['parts'][$sensor->part_id] = $sensor;
            }
        }
        
        return $sensorsReturn;
    }
    
    private function getFleetGpsData($updateDatetime = null, $vehicleId = null)
    {
        $gpsQuery = Gps::where('company_id', Auth::user()['company_id']);
        
        if (!empty($updateDatetime)) {
            $gpsQuery = $gpsQuery->where('created_at', '>', $updateDatetime);
        }

        if (!empty($vehicleId)) {
            $gpsQuery = $gpsQuery->where('vehicle_id', $vehicleId);
        }
            
        $gpsQuery = $gpsQuery->orderBy('created_at', 'asc')
            ->get();

        $gpsData = [];
        if (!empty($gpsQuery)) {
            foreach ($gpsQuery as $gps) {
                $objGps = new \stdClass();
                $objGps->latitude = HelperRepository::manageEmptyValue($gps->latitude);
                $objGps->longitude = HelperRepository::manageEmptyValue($gps->longitude);
                
                $gpsData[$gps->vehicle_id] = $objGps;
            }
        }

        return $gpsData;
    }
    
    public function getFleetData($vehicle_id = null)
    {
        $vehicles = Vehicle::where('company_id', Auth::user()['company_id']);
        
        if (!empty($vehicle_id)) {
            $vehicles = $vehicles->where('id', $vehicle_id);
        }
        
        $vehicles = $vehicles->get();
        $tireData = [];
        $modelMaps = [];
        
        if (!empty($vehicles)) {
            $tires = PartRepositoryEloquent::getTiresVehicle();
            $fleetGpsData = $this->getFleetGpsData();
            $tireAndSensorData = $this->getFleetTireAndSensorData();
            foreach ($vehicles as $vehicle) {
                $modelMaps[$vehicle->model_vehicle_id] = $vehicle->model->map;

                $tireData[$vehicle->id] = [];
                $tiresPositions = PartRepositoryEloquent::getTiresPositions($tires, $vehicle->id);
        
                if (!empty($tiresPositions)) {
                    foreach ($tiresPositions as $position => $filled) {
                        if ($filled) {
                            if (!empty($tireAndSensorData[$vehicle->id][$position])) {
                                $tireData[$vehicle->id][$position] = $tireAndSensorData[$vehicle->id][$position];
                            } else {
                                $tireData[$vehicle->id][$position] = $tireAndSensorData[0];
                            }
                        }
                    }
                }

                $gpsData[$vehicle->id] = [];
                if (!empty($fleetGpsData[$vehicle->id])) {
                    $gpsData[$vehicle->id] = $fleetGpsData[$vehicle->id];
                }
            }
        }
        
        return ['vehicles' => $vehicles, 'tireData' => $tireData, 'gpsData' => $gpsData, 'modelMaps' => $modelMaps];
    }
    
    public function getFleetGpsAndSensorData($updateDatetime = null, $vehicleId = null)
    {
        return ['updateDatetime' => date("Y-m-d H:i:s"),
            'gps' => $this->getFleetGpsData($updateDatetime, $vehicleId),
            'tires' => $this->getFleetTireAndSensorData($updateDatetime, $vehicleId)
        ];
    }
    
    public function getTireSensorHistoricalData($partsIds, $dateIni, $dateEnd)
    {
        $tireSensor = TireSensor::select('tire_sensor.*', 'parts.position', 'parts.vehicle_id')
            ->join('parts', 'tire_sensor.part_id', '=', 'parts.id')
            ->whereIn('tire_sensor.part_id', $partsIds)
            ->orderBy('parts.created_at', 'asc');

        if (!empty($dateIni) && $dateIni != '-') {
            $tireSensor = $tireSensor->where('tire_sensor.created_at', '>=', $dateIni);
        }
        
        if (!empty($dateEnd) && $dateEnd != '-') {
            $tireSensor = $tireSensor->where('tire_sensor.created_at', '<=', $dateEnd);
        }
            
        $tireSensor = $tireSensor->get();

        $historicalDataByPositions = [];
        $maxDataCount = 0;
        if (!empty($tireSensor)) {
            foreach ($tireSensor as $data) {
                $historicalDataByPositions[$data->position][] = $data;
                if (count($historicalDataByPositions[$data->position]) > $maxDataCount) {
                    $maxDataCount = count($historicalDataByPositions[$data->position]);
                }
            }
        }
        
        $historicalData = [];
        for ($i = 0; $i < $maxDataCount; $i++) {
            $historicalData[$i + 1] = $i + 1;
            foreach ($historicalDataByPositions as $position => $data) {
                $historicalData[$i + 1] .= ", " . $data[$i]->temperature;
                $historicalData[$i + 1] .= ", " . $data[$i]->pressure;
            }
        }
        
        return $historicalData;
    }
    
    public function setColumnsChart($tireSensorData)
    {
        $chartElements[1] = "temperature";
        $chartElements[2] = "pressure";
        
        $tireSensorData['columns'] = [];
        if (!empty($tireSensorData['positions'])) {
            foreach ($tireSensorData['positions'] as $key => $value) {
                for ($index = 1; $index <= count($chartElements); $index++) {
                    $tireSensorData['columns'][$value][] = ($key * count($chartElements)) + $index;
                }
            }
        }
        
        if (!empty($tireSensorData['data'])) {
            for ($index = count($tireSensorData['positions']) * count($chartElements); $index > 0; $index--) {
                $elements = array_reverse($chartElements);
                foreach ($elements as $element) {
                    if ($index % array_search($element, $chartElements) == 0) {
                        $tireSensorData['columns'][$element][] = $index;
                        break;
                    }
                }
            }
        }
        
        return $tireSensorData;
    }
}

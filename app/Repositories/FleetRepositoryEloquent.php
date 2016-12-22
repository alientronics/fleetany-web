<?php

namespace App\Repositories;

use App\Entities\Vehicle;
use Illuminate\Support\Facades\Auth;
use App\Entities\Gps;
use App\Entities\Part;
use App\Entities\TireSensor;

class FleetRepositoryEloquent extends VehicleRepositoryEloquent
{

    private function getFleetTireAndSensorParts(&$partsData, $vehicleId = null, $partsIds = null)
    {
        $partsQuery = Part::select('parts.id', 'parts.position', 'parts.vehicle_id')
            ->join('types', 'parts.part_type_id', '=', 'types.id')
            ->whereNotNull('parts.vehicle_id')
            ->where('parts.company_id', Auth::user()['company_id'])
            ->where('types.name', 'sensor');
    
        if (!empty($vehicleId)) {
            $partsQuery = $partsQuery->where('parts.vehicle_id', $vehicleId);
        }
    
        if (!empty($partsIds)) {
            $partsQuery = $partsQuery->whereIn('parts.id', $partsIds);
        }
    
        $partsResult = $partsQuery->get();
        
        $parts = [];
        $partsData = [];
        if (count($partsResult) > 0) {
            foreach ($partsResult as $part) {
                $parts[] = $part->id;
                $partsData[$part->id]['position'] = $part->position;
                $partsData[$part->id]['vehicle_id'] = $part->vehicle_id;
            }
        }
        
        return $parts;
    }
    
    private function getFleetTireAndSensorData($updateDatetime = null, $vehicleId = null)
    {
        
        $parts = $this->getFleetTireAndSensorParts($partsData, $vehicleId);
         
        $sensorsIdsQuery = TireSensor::select(\DB::raw('max(id) as id'))
            ->whereIn('part_id', $parts);
            
        if (!empty($updateDatetime)) {
            $sensorsIdsQuery = $sensorsIdsQuery->where('tire_sensor.created_at', '>', $updateDatetime);
        }
        
        $sensorsIdsQuery = $sensorsIdsQuery->groupBy('tire_sensor.part_id')
            ->get();
       
        $sensorsIds = [];
        if (count($sensorsIdsQuery) > 0) {
            foreach ($sensorsIdsQuery as $sensorsIdQuery) {
                $sensorsIds[] = $sensorsIdQuery->id;
            }
        }

        $sensors = TireSensor::select('tire_sensor.*')
            ->whereIn('tire_sensor.id', $sensorsIds)
            ->get();

        $tireAndSensorData = [];
        if (count($sensors) > 0) {
            $tiresData = $this->getTiresWarningAndDanger($sensorsIds);
            foreach ($sensors as $sensor) {
                $objTire = new \stdClass();
                $objTire->temperature = HelperRepository::manageEmptyValue($sensor->temperature);
                $objTire->pressure = HelperRepository::manageEmptyValue($sensor->pressure);
                $objTire->part_id = HelperRepository::manageEmptyValue($sensor->part_id);
                $objTire->position = HelperRepository::manageEmptyValue($sensor->position);
                $objTire->created_at = HelperRepository::manageEmptyValue($sensor->created_at);
                
                $objTire = $this->setTiresColor($tiresData, $sensor, $objTire);
                
                $vehicle_id = $partsData[$sensor->part_id]['vehicle_id'];
                $tireAndSensorData[$vehicle_id][$partsData[$sensor->part_id]['position']] = $objTire;
            }
        }

        $objTire = new \stdClass();
        $objTire->temperature = "";
        $objTire->pressure = "";
        $objTire->color = "";
        $objTire->created_at = "";
        $tireAndSensorData[0] = $objTire;
        
    
        return $tireAndSensorData;
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
        $gpsData = [];
        
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
        
        $this->getFleetTireAndSensorParts($partsData, null, $partsIds);
        
        $tireSensor = TireSensor::select('part_id', 'temperature', 'pressure', 'created_at')
            ->whereIn('part_id', $partsIds);

        if (!empty($dateIni) && $dateIni != '-') {
            $tireSensor = $tireSensor->where('created_at', '>=', $dateIni);
        }
        
        if (!empty($dateEnd) && $dateEnd != '-') {
            $tireSensor = $tireSensor->where('created_at', '<=', $dateEnd);
        }
         
        $tireSensor = $tireSensor->get();

        $historicalDataPos = $this->setHistoricalDataPositions($partsData);
        if (!empty($tireSensor)) {
            foreach ($tireSensor as $data) {
                $historicalDataPos[$partsData[$data->part_id]['position']][] = $data;
            }
        }

        return $this->getHistoricalData($historicalDataPos);
    }
    
    private function getHistoricalData($historicalDataPos)
    {
        $historicalData = [];
        $historicalOrderData = [];
        $positionOrder = 0;
        $countPoints = 0;
        foreach ($historicalDataPos as $historicalDataP) {
            $positionOrder++;
            foreach ($historicalDataP as $dataPos) {
                $countPoints++;
                $historicalData[$countPoints]['time'] = substr($dataPos->created_at, 11);
                $historicalData[$countPoints][substr($dataPos->created_at, 11)] = "";
                
                for ($i = 1; $i < $positionOrder; $i++) {
                    $historicalData[$countPoints][substr($dataPos->created_at, 11)] .= ", null, null";
                }
                $historicalData[$countPoints][substr($dataPos->created_at, 11)] .= ", " . $dataPos->temperature;
                $historicalData[$countPoints][substr($dataPos->created_at, 11)] .= ", " . $dataPos->pressure;
                for ($i = $positionOrder; $i < count($historicalDataPos); $i++) {
                    $historicalData[$countPoints][substr($dataPos->created_at, 11)] .= ", null, null";
                }
                $historicalOrderData[substr($dataPos->created_at, 11)] = $historicalData[$countPoints];
            }
        }
        asort($historicalOrderData);
        return $historicalOrderData;
    }
    
    private function setHistoricalDataPositions($partsData)
    {
        $historicalData = [];
        $historicalDataTemp = [];
        if (!empty($partsData)) {
            foreach ($partsData as $part) {
                $historicalDataTemp[] = $part['position'];
            }
            sort($historicalDataTemp);
            foreach ($historicalDataTemp as $dataTemp) {
                $historicalData[$dataTemp] = [];
            }
        }
        return $historicalData;
    }
    
    public function setColumnsChart($tireSensorData)
    {
        $chartElements[1] = "temperature";
        $chartElements[2] = "pressure";
        
        $tireSensorData['columns'] = [];
        foreach ($tireSensorData['positions'] as $key => $value) {
            for ($index = 1; $index <= count($chartElements); $index++) {
                $tireSensorData['columns'][$value][] = ($key * count($chartElements)) + $index;
            }
        }
        
        for ($index = count($tireSensorData['positions']) * count($chartElements); $index > 0; $index--) {
            $elements = array_reverse($chartElements);
            foreach ($elements as $element) {
                if ($index % array_search($element, $chartElements) == 0) {
                    $tireSensorData['columns'][$element][] = $index;
                    break;
                }
            }
        }
        
        return $tireSensorData;
    }
}

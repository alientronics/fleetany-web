<?php

namespace App\Repositories;

use App\Entities\Vehicle;
use Illuminate\Support\Facades\Auth;
use App\Entities\Gps;
use App\Entities\TireSensor;

class FleetRepositoryEloquent extends VehicleRepositoryEloquent
{

    private function getFleetTireAndSensorData($updateDatetime = null)
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
            
        $sensors = $sensors->orderBy('tire_sensor.created_at', 'asc')
            ->get();

        $tireAndSensorData = [];
        if (!empty($sensors)) {
            foreach ($sensors as $sensor) {
                $objTire = new \stdClass();
                $objTire->temperature = HelperRepository::manageEmptyValue($sensor->temperature);
                $objTire->pressure = HelperRepository::manageEmptyValue($sensor->pressure);
                
                $tireAndSensorData[$sensor->vehicle_id][$sensor->position] = $objTire;
            }
        }
        $objTire = new \stdClass();
        $objTire->temperature = "";
        $objTire->pressure = "";
        $tireAndSensorData[0] = $objTire;
    
        return $tireAndSensorData;
    }

    private function getFleetGpsData($updateDatetime = null)
    {
        $gpsQuery = Gps::where('company_id', Auth::user()['company_id']);
        
        if (!empty($updateDatetime)) {
            $gpsQuery = $gpsQuery->where('created_at', '>', $updateDatetime);
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
    
    public function getFleetData()
    {
        $vehicles = Vehicle::where('company_id', Auth::user()['company_id'])->get();
        $tireData = [];
        $modelMaps = [];
        
        if (!empty($vehicles)) {
            $tires = PartRepositoryEloquent::getTiresVehicle();
            $fleetGpsData = $this->getFleetGpsData();
            $tireAndSensorData = $this->getFleetTireAndSensorData();
            foreach ($vehicles as $vehicle) {
                if (empty($modelMaps[$vehicle->model_vehicle_id])) {
                    $modelMaps[$vehicle->model_vehicle_id] = $vehicle->model->map;
                }

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

                if (!empty($fleetGpsData[$vehicle->id])) {
                    $gpsData[$vehicle->id] = $fleetGpsData[$vehicle->id];
                } else {
                    $gpsData[$vehicle->id] = [];
                }
            }
        }
        
        return ['vehicles' => $vehicles, 'tireData' => $tireData, 'gpsData' => $gpsData, 'modelMaps' => $modelMaps];
    }
    
    public function getFleetGpsAndSensorData($updateDatetime = null)
    {
        return ['updateDatetime' => date("Y-m-d H:i:s"),
            'gps' => $this->getFleetGpsData($updateDatetime),
            'tires' => $this->getFleetTireAndSensorData($updateDatetime)
        ];
    }
}

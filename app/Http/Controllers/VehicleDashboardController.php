<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Container\Container as Application;
use App\Repositories\FleetRepositoryEloquent;
use App\Repositories\VehicleRepositoryEloquent;
use App\Repositories\PartRepositoryEloquent;
use App\Repositories\TireSensorRepositoryEloquent;

class VehicleDashboardController extends VehicleController
{

    protected $fleetRepo;
    
    public function __construct(
        VehicleRepositoryEloquent $vehicleRepo,
        PartRepositoryEloquent $partRepo,
        TireSensorRepositoryEloquent $tireSensorRepo
    ) {
        parent::__construct($vehicleRepo, $partRepo, $tireSensorRepo);
        $this->fleetRepo = new FleetRepositoryEloquent(new Application);
    }
    
    public function tires(Request $request)
    {
        $tires = $this->vehicleRepo->getTireAndSensorData($request->all());
        return response()->json($tires);
    }

    public function localization(Request $request)
    {
        $data = $request->all();
        $localization = $this->vehicleRepo->getLocalizationData($data['vehicle_id']);
        return response()->json($localization);
    }

    public function fleet()
    {
        $fleetData = $this->fleetRepo->getFleetData();
        $vehicles = $fleetData['vehicles'];
        $tireData = $fleetData['tireData'];
        $gpsData = $fleetData['gpsData'];
        $modelMaps = $fleetData['modelMaps'];

        return view("fleet.index", compact('vehicles', 'tireData', 'gpsData', 'modelMaps'));
    }

    public function fleetGpsAndSensorData($updateDatetime = null)
    {
        return response()->json($this->fleetRepo->getFleetGpsAndSensorData($updateDatetime));
    }
}

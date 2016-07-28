<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;
use App\Repositories\VehicleRepositoryEloquent;
use App\Repositories\EntryRepositoryEloquent;
use App\Repositories\TripRepositoryEloquent;

class HomeController extends BaseController
{
    
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(
        VehicleRepositoryEloquent $vehicleRepo,
        EntryRepositoryEloquent $entryRepo,
        TripRepositoryEloquent $tripRepo
    ) {
    
        $vehiclesStatistics = $vehicleRepo->getVehiclesStatistics();
        $vehiclesLastPlace = $vehicleRepo->getVehiclesLastPlace();
        $lastsServiceCost = $entryRepo->getLastsServiceCostStatistics();
        $servicesStatistics = $entryRepo->getServicesStatistics();
        $tripsStatistics = $tripRepo->getTripsStatistics();
        $lastsFuelCost = $tripRepo->getLastsFuelCostStatistics();
        return View::make('welcome', [
            'vehiclesStatistics' => $vehiclesStatistics,
            'vehiclesLastPlace' => $vehiclesLastPlace,
            'lastsServiceCostStatistics' => $lastsServiceCost,
            'servicesStatistics' => $servicesStatistics,
            'tripsStatistics' => $tripsStatistics,
            'lastsFuelCostStatistics' => $lastsFuelCost
        ]);
    }

    public function contact()
    {
        return View::make('home.contact');
    }
}

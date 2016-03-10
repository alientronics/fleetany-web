<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\TripRepositoryEloquent;
use App\Entities\Trip;
use Log;
use Input;
use Lang;
use Session;
use Redirect;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Repositories\HelperRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{

    protected $tripRepo;
    
    protected $fields = [
        'id',
        'vehicle-id',
        'trip-type-id',
        'pickup-date',
        'fuel-cost'
    ];
    
    public function __construct(TripRepositoryEloquent $tripRepo)
    {
        $this->middleware('auth');
        $this->tripRepo = $tripRepo;
    }

    public function index(Request $request)
    {
        $objHelper = new HelperRepository();
        $filters = $objHelper->getFilters($request->all(), $this->fields, $request);
        
        $trips = $this->tripRepo->results($filters);
                
        return view("trip.index", compact('trips', 'filters'));
    }
    
    public function create()
    {
        $trip = new Trip();
        $objHelperRepository = new HelperRepository();
        $company_id = $objHelperRepository->getCompanies();
        $driver_id = $objHelperRepository->getDrivers();
        $vehicle_id = $objHelperRepository->getVehicles();
        $vendor_id = $objHelperRepository->getVendors();
        $trip_type_id = $objHelperRepository->getTripTypes();
        return view("trip.edit", compact('trip', 'driver_id', 'company_id', 'vehicle_id', 'vendor_id', 'trip_type_id'));
    }

    public function store()
    {
        try {
            $this->tripRepo->validator();
            $this->tripRepo->create(Input::all());
            Session::flash(
                'message',
                Lang::get(
                    'general.succefullcreate',
                    ['table'=> Lang::get('general.Trip')]
                )
            );
            return Redirect::to('trip');
        } catch (ValidatorException $e) {
            return Redirect::back()->withInput()
                   ->with('errors', $e->getMessageBag());
        }
    }
    
    public function show($idTrip)
    {
        $trip = $this->tripRepo->find($idTrip);
        return view("trip.show", compact('trip'));
    }
    
    public function edit($idTrip)
    {
        $trip = $this->tripRepo->find($idTrip);
        
        $objHelperRepository = new HelperRepository();
        $company_id = $objHelperRepository->getCompanies();
        $driver_id = $objHelperRepository->getDrivers();
        $vehicle_id = $objHelperRepository->getVehicles();
        $vendor_id = $objHelperRepository->getVendors();
        $trip_type_id = $objHelperRepository->getTripTypes();
        
        return view("trip.edit", compact('trip', 'driver_id', 'company_id', 'vehicle_id', 'vendor_id', 'trip_type_id'));
    }
    
    public function update($idTrip)
    {
        try {
            $this->tripRepo->validator();
            $this->tripRepo->update(Input::all(), $idTrip);
            Session::flash(
                'message',
                Lang::get(
                    'general.succefullupdate',
                    ['table'=> Lang::get('general.Trip')]
                )
            );
            return Redirect::to('trip');
        } catch (ValidatorException $e) {
            return Redirect::back()->withInput()
                    ->with('errors', $e->getMessageBag());
        }
    }
    
    public function destroy($idTrip)
    {
        Log::info('Delete field: '.$idTrip);

        if ($idTrip != 1 && $this->tripRepo->find($idTrip)) {
            $this->tripRepo->delete($idTrip);
            Session::flash('message', Lang::get("general.deletedregister"));
        }
        return Redirect::to('trip');
    }
}

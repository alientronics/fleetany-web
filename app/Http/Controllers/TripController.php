<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\TripRepositoryEloquent;
use App\Entities\Trip;
use Log;
use Lang;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CompanyRepositoryEloquent;
use App\Repositories\VehicleRepositoryEloquent;
use App\Repositories\ContactRepositoryEloquent;
use App\Repositories\TypeRepositoryEloquent;

class TripController extends Controller
{

    protected $tripRepo;
    
    protected $fields = [
        'id',
        'vehicle',
        'trip-type',
        'pickup-date',
        'fuel-cost'
    ];
    
    public function __construct(TripRepositoryEloquent $tripRepo)
    {
        parent::__construct();
        
        $this->middleware('auth');
        $this->tripRepo = $tripRepo;
    }

    public function index()
    {
        $filters = $this->helper->getFilters($this->request->all(), $this->fields, $this->request);
        $registers = $this->tripRepo->results($filters);
        $gridview = $this->tripRepo->gridview($filters);
        
        return view("trip.index", compact('registers', 'filters', 'gridview'));
    }
    
    public function create()
    {
        $trip = new Trip();
        $company_id = CompanyRepositoryEloquent::getCompanies();
        $vehicle_id = VehicleRepositoryEloquent::getVehicles();
        $driver_id = ContactRepositoryEloquent::getContacts('driver');
        $vendor_id = ContactRepositoryEloquent::getContacts('vendor', true);
        $trip_type_id = TypeRepositoryEloquent::getTypes();
        return view("trip.edit", compact('trip', 'driver_id', 'vendor_id', 'company_id', 'vehicle_id', 'trip_type_id'));
    }

    public function store()
    {
        try {
            $this->tripRepo->validator();
            $inputs = $this->tripRepo->getInputs($this->request->all());
            $this->tripRepo->create($inputs);
            return $this->redirect->to('trip')->with('message', Lang::get(
                'general.succefullcreate',
                ['table'=> Lang::get('general.Trip')]
            ));
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
                   ->with('errors', $e->getMessageBag());
        }
    }
    
    public function edit($idTrip)
    {
        $trip = $this->tripRepo->find($idTrip);
        $this->helper->validateRecord($trip);

        $company_id = CompanyRepositoryEloquent::getCompanies();
        $vehicle_id = VehicleRepositoryEloquent::getVehicles();
        $driver_id = ContactRepositoryEloquent::getContacts('driver');
        $vendor_id = ContactRepositoryEloquent::getContacts('vendor', true);
        $trip_type_id = TypeRepositoryEloquent::getTypes();
        return view("trip.edit", compact('trip', 'driver_id', 'vendor_id', 'contacts', 'company_id', 'vehicle_id', 'trip_type_id'));
    }
    
    public function update($idTrip)
    {
        try {
            $trip = $this->tripRepo->find($idTrip);
            $this->helper->validateRecord($trip);
            $this->tripRepo->validator();
            $inputs = $this->tripRepo->getInputs($this->request->all());
            $this->tripRepo->update($inputs, $idTrip);
            return $this->redirect->to('trip')->with('message', Lang::get(
                'general.succefullupdate',
                ['table'=> Lang::get('general.Trip')]
            ));
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
                    ->with('errors', $e->getMessageBag());
        }
    }
    
    public function destroy($idTrip)
    {
        Log::info('Delete field: '.$idTrip);

        $trip = $this->tripRepo->find($idTrip);
        if ($trip) {
            $this->helper->validateRecord($trip);
            $this->tripRepo->delete($idTrip);
        }
        return $this->redirect->to('trip')->with('message', Lang::get("general.deletedregister"));
    }
}

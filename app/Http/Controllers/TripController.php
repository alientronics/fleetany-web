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
        
        $trips = $this->tripRepo->results($filters);
                
        return view("trip.index", compact('trips', 'filters'));
    }
    
    public function create()
    {
        $trip = new Trip();
        $company_id = CompanyRepositoryEloquent::getCompanies();
        $vehicle_id = VehicleRepositoryEloquent::getVehicles();
        $contacts = ContactRepositoryEloquent::getContacts();
        $trip_type_id = TypeRepositoryEloquent::getTypes();
        return view("trip.edit", compact('trip', 'contacts', 'company_id', 'vehicle_id', 'trip_type_id'));
    }

    public function store()
    {
        try {
            $this->tripRepo->validator();
            $inputs = $this->request->all();
            $inputs['company_id'] = Auth::user()['company_id'];
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
        $contacts = ContactRepositoryEloquent::getContacts();
        $trip_type_id = TypeRepositoryEloquent::getTypes();
        return view("trip.edit", compact('trip', 'contacts', 'company_id', 'vehicle_id', 'trip_type_id'));
    }
    
    public function update($idTrip)
    {
        try {
            $trip = $this->tripRepo->find($idTrip);
            $this->helper->validateRecord($trip);
            $this->tripRepo->validator();
            $inputs = $this->request->all();
            $inputs['company_id'] = Auth::user()['company_id'];
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

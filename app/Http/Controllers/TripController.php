<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\TripRepositoryEloquent;
use App\Entities\Trip;
use Log;
use Lang;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Support\Facades\Auth;

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
        $company_id = $this->helper->getCompanies();
        $vehicle_id = $this->helper->getVehicles();
        $contacts = $this->helper->getContacts();
        $trip_type_id = $this->helper->getTypes();
        return view("trip.edit", compact('trip', 'contacts', 'company_id', 'vehicle_id', 'trip_type_id'));
    }

    public function store()
    {
        try {
            $this->tripRepo->validator();
            $this->tripRepo->create($this->request->all());
            $this->session->flash(
                'message',
                Lang::get(
                    'general.succefullcreate',
                    ['table'=> Lang::get('general.Trip')]
                )
            );
            return $this->redirect->to('trip');
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
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
        
        $company_id = $this->helper->getCompanies();
        $vehicle_id = $this->helper->getVehicles();
        $contacts = $this->helper->getContacts();
        $trip_type_id = $this->helper->getTypes();
        return view("trip.edit", compact('trip', 'contacts', 'company_id', 'vehicle_id', 'trip_type_id'));
    }
    
    public function update($idTrip)
    {
        try {
            $this->tripRepo->validator();
            $this->tripRepo->update($this->request->all(), $idTrip);
            $this->session->flash(
                'message',
                Lang::get(
                    'general.succefullupdate',
                    ['table'=> Lang::get('general.Trip')]
                )
            );
            return $this->redirect->to('trip');
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
                    ->with('errors', $e->getMessageBag());
        }
    }
    
    public function destroy($idTrip)
    {
        Log::info('Delete field: '.$idTrip);

        if ($idTrip != 1 && $this->tripRepo->find($idTrip)) {
            $this->tripRepo->delete($idTrip);
            $this->session->flash('message', Lang::get("general.deletedregister"));
        }
        return $this->redirect->to('trip');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\EntryRepositoryEloquent;
use App\Entities\Entry;
use Log;
use Lang;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CompanyRepositoryEloquent;
use App\Repositories\TypeRepositoryEloquent;
use App\Repositories\ContactRepositoryEloquent;
use App\Repositories\VehicleRepositoryEloquent;

class EntryController extends Controller
{

    protected $entryRepo;
    
    protected $fields = [
        'id',
        'vehicle',
        'entry-type',
        'datetime-ini',
        'cost'
    ];
    
    public function __construct(EntryRepositoryEloquent $entryRepo)
    {
        parent::__construct();
    
        $this->middleware('auth');
        $this->entryRepo = $entryRepo;
    }

    public function index()
    {
        $filters = $this->helper->getFilters($this->request->all(), $this->fields, $this->request);
        
        $entries = $this->entryRepo->results($filters);
                
        return view("entry.index", compact('entries', 'filters'));
    }
    
    public function create()
    {
        $entry = new Entry();
        $company_id = CompanyRepositoryEloquent::getCompanies();
        $entry_type_id = TypeRepositoryEloquent::getTypes();
        $vendor_id = ContactRepositoryEloquent::getContacts();
        $vehicle_id = VehicleRepositoryEloquent::getVehicles();
        return view("entry.edit", compact('entry', 'entry_type_id', 'company_id', 'vehicle_id', 'vendor_id'));
    }

    public function store()
    {
        try {
            $this->entryRepo->validator();
            $inputs = $this->request->all();
            $inputs['company_id'] = Auth::user()['company_id'];
            $this->entryRepo->create($inputs);
            return $this->redirect->to('entry')->with('message', Lang::get(
                'general.succefullcreate',
                ['table'=> Lang::get('general.Entry')]
            ));
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
                   ->with('errors', $e->getMessageBag());
        }
    }
    
    public function edit($idEntry)
    {
        $entry = $this->entryRepo->find($idEntry);
        $this->helper->validateRecord($entry);

        $company_id = CompanyRepositoryEloquent::getCompanies();
        $entry_type_id = TypeRepositoryEloquent::getTypes();
        $vendor_id = ContactRepositoryEloquent::getContacts();
        $vehicle_id = VehicleRepositoryEloquent::getVehicles();
        return view("entry.edit", compact('entry', 'entry_type_id', 'company_id', 'vehicle_id', 'vendor_id'));
    }
    
    public function update($idEntry)
    {
        try {
            $entry = $this->entryRepo->find($idEntry);
            $this->helper->validateRecord($entry);
            $this->entryRepo->validator();
            $inputs = $this->request->all();
            $inputs['company_id'] = Auth::user()['company_id'];
            $this->entryRepo->update($inputs, $idEntry);
            return $this->redirect->to('entry')->with('message', Lang::get(
                'general.succefullupdate',
                ['table'=> Lang::get('general.Entry')]
            ));
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
                    ->with('errors', $e->getMessageBag());
        }
    }
    
    public function destroy($idEntry)
    {
        Log::info('Delete field: '.$idEntry);

        $entry = $this->entryRepo->find($idEntry);
        if ($entry) {
            $this->helper->validateRecord($entry);
            $this->entryRepo->delete($idEntry);
        }
        return $this->redirect->to('entry')->with('message', Lang::get("general.deletedregister"));
    }
}

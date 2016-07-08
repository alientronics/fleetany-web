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
use App\Repositories\PartRepositoryEloquent;
use Alientronics\FleetanyWebAttributes\Repositories\AttributeRepositoryEloquent;

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
        $entry_type_id = TypeRepositoryEloquent::getTypes('entry');
        $vendor_id = ContactRepositoryEloquent::getContacts('vendor', true);
        $vehicle_id = VehicleRepositoryEloquent::getVehicles();
        $parts = PartRepositoryEloquent::getPartsByVehicle(array_keys($vehicle_id->toArray())[0]);
        $entry_parts = [];
        
        $attributes = [];
        if (config('app.attributes_api_url') != null) {
            $attributes = AttributeRepositoryEloquent::getAttributesWithValues('entry');
        }
        
        return view("entry.edit", compact(
            'entry',
            'entry_type_id',
            'company_id',
            'vehicle_id',
            'vendor_id',
            'parts',
            'entry_parts',
            'attributes'
        ));
    }

    public function store()
    {
        try {
            $this->entryRepo->validator();
            $inputs = $this->entryRepo->setInputs($this->request->all());
            $entry = $this->entryRepo->create($inputs);
            $inputs['entity_id'] = $entry->id;
            
            if (config('app.attributes_api_url') != null) {
                AttributeRepositoryEloquent::setValues($inputs);
            }
            
            if (!empty($inputs['parts'])) {
                $entry->updateEntryParts($entry->id, $inputs['parts']);
            }
            
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
        $entry = $this->entryRepo->getInputs($entry);
        $this->helper->validateRecord($entry);

        $company_id = CompanyRepositoryEloquent::getCompanies();
        $entry_type_id = TypeRepositoryEloquent::getTypes('entry');
        $vendor_id = ContactRepositoryEloquent::getContacts('vendor', true);
        $vehicle_id = VehicleRepositoryEloquent::getVehicles();
        $parts = PartRepositoryEloquent::getPartsByVehicle($entry->vehicle_id);
        $entry_parts = [];
        foreach ($entry->partsEntries->toArray() as $entryPart) {
            $entry_parts[] = $entryPart['part_id'];
        }
        
        $attributes = [];
        if (config('app.attributes_api_url') != null) {
            $attributes = AttributeRepositoryEloquent::getAttributesWithValues(
                'entry.'.$entry->type->name,
                $idEntry
            );
        }
        
        return view("entry.edit", compact(
            'entry',
            'entry_type_id',
            'company_id',
            'vehicle_id',
            'vendor_id',
            'parts',
            'entry_parts',
            'attributes'
        ));
    }
    
    public function update($idEntry)
    {
        try {
            $entry = $this->entryRepo->find($idEntry);
            $this->helper->validateRecord($entry);
            $this->entryRepo->validator();
            $inputs = $this->entryRepo->setInputs($this->request->all());
            $inputs['entity_id'] = $this->entryRepo->update($inputs, $idEntry)->id;
            if (config('app.attributes_api_url') != null) {
                AttributeRepositoryEloquent::setValues($inputs);
            }
            
            if (!empty($inputs['parts'])) {
                $entry->updateEntryParts($entry->id, $inputs['parts']);
            }
            
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
        $entry = $this->entryRepo->find($idEntry);
        if ($entry) {
            $this->helper->validateRecord($entry);
            Log::info('Delete field: '.$idEntry);
            $this->entryRepo->delete($idEntry);
            return $this->redirect->to('entry')->with('message', Lang::get("general.deletedregister"));
        } else {
            return $this->redirect->to('entry')->with('message', Lang::get("general.deletedregistererror"));
        }
    }
}

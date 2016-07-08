<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\ContactRepositoryEloquent;
use App\Entities\Contact;
use Log;
use Lang;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CompanyRepositoryEloquent;
use App\Repositories\TypeRepositoryEloquent;
use Alientronics\FleetanyWebAttributes\Repositories\AttributeRepositoryEloquent;

class ContactController extends Controller
{

    protected $contactRepo;
    
    protected $fields = [
        'id',
        'name',
        'contact-type',
        'city'
    ];
    
    public function __construct(ContactRepositoryEloquent $contactRepo)
    {
        parent::__construct();
        
        $this->middleware('auth');
        $this->contactRepo = $contactRepo;
    }

    public function index()
    {
        $filters = $this->helper->getFilters($this->request->all(), $this->fields, $this->request);
        
        $contacts = $this->contactRepo->results($filters);
                
        return view("contact.index", compact('contacts', 'filters'));
    }
    
    public function create()
    {
        $contact = new Contact();
        $company_id = CompanyRepositoryEloquent::getCompanies();
        $contact_type_id = TypeRepositoryEloquent::getTypes('contact');
        $typedialog = TypeRepositoryEloquent::getDialogStoreOptions('contact');
        $driver_profile = [];
        
        $attributes = [];
        if (config('app.attributes_api_url') != null) {
            $attributes = AttributeRepositoryEloquent::getAttributesWithValues('contact');
        }
        
        return view("contact.edit", compact(
            'contact',
            'contact_type_id',
            'typedialog',
            'company_id',
            'driver_profile',
            'attributes'
        ));
    }

    public function store()
    {
        try {
            $this->contactRepo->validator();
            $inputs = $this->request->all();
            $this->contactRepo->create($inputs);
            if (config('app.attributes_api_url') != null) {
                AttributeRepositoryEloquent::setValues($inputs);
            }
            return $this->redirect->to('contact')->with('message', Lang::get(
                'general.succefullcreate',
                ['table'=> Lang::get('general.Contact')]
            ));
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
                   ->with('errors', $e->getMessageBag());
        }
    }
    
    public function edit($idContact)
    {
        $contact = $this->contactRepo->find($idContact);
        $this->helper->validateRecord($contact);
        
        $company_id = CompanyRepositoryEloquent::getCompanies();
        $contact_type_id = TypeRepositoryEloquent::getTypes('contact');
        $typedialog = TypeRepositoryEloquent::getDialogStoreOptions('contact');
        
        $driver_profile = $this->contactRepo->getDriverProfile($idContact);
        
        $attributes = [];
        if (config('app.attributes_api_url') != null) {
            $attributes = AttributeRepositoryEloquent::getAttributesWithValues(
                'contact.'.$contact->type->name,
                $idContact
            );
        }
        
        return view("contact.edit", compact(
            'contact',
            'contact_type_id',
            'typedialog',
            'company_id',
            'driver_profile',
            'attributes'
        ));
    }
    
    public function update($idContact)
    {
        try {
            $contact = $this->contactRepo->find($idContact);
            $this->helper->validateRecord($contact);
            $this->contactRepo->validator();
            $inputs = $this->request->all();
            $this->contactRepo->update($inputs, $idContact);
            if (config('app.attributes_api_url') != null) {
                AttributeRepositoryEloquent::setValues($inputs);
            }
            return $this->redirect->to('contact')->with('message', Lang::get(
                'general.succefullupdate',
                ['table'=> Lang::get('general.Contact')]
            ));
            ;
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
                    ->with('errors', $e->getMessageBag());
        }
    }
    
    public function destroy($idContact)
    {
        $hasReferences = $this->contactRepo->hasReferences($idContact);
        $contact = $this->contactRepo->find($idContact);
        if ($contact && !$hasReferences) {
            $this->helper->validateRecord($contact);
            Log::info('Delete field: '.$idContact);
            $this->contactRepo->delete($idContact);
            return $this->redirect->to('contact')->with('message', Lang::get("general.deletedregister"));
        } elseif ($hasReferences) {
            return $this->redirect->to('contact')->with('message', Lang::get("general.deletedregisterhasreferences"));
        } else {
            return $this->redirect->to('contact')->with('message', Lang::get("general.deletedregistererror"));
        }
    }
}

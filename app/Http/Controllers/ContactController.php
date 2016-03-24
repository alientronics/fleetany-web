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
        $contact_type_id = TypeRepositoryEloquent::getTypes();
        return view("contact.edit", compact('contact', 'contact_type_id', 'company_id'));
    }

    public function store()
    {
        try {
            $this->contactRepo->validator();
            $this->contactRepo->create($this->request->all());
            return $this->redirect->to('contact')->with('message', Lang::get(
                'general.succefullcreate',
                ['table'=> Lang::get('general.Contact')]
            ));
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
                   ->with('errors', $e->getMessageBag());
        }
    }
    
    public function show($idContact)
    {
        $contact = $this->contactRepo->find($idContact);
        return view("contact.show", compact('contact'));
    }
    
    public function edit($idContact)
    {
        $contact = $this->contactRepo->find($idContact);

        $company_id = CompanyRepositoryEloquent::getCompanies();
        $contact_type_id = TypeRepositoryEloquent::getTypes();
        
        return view("contact.edit", compact('contact', 'contact_type_id', 'company_id'));
    }
    
    public function update($idContact)
    {
        try {
            $this->contactRepo->validator();
            $this->contactRepo->update($this->request->all(), $idContact);
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
        Log::info('Delete field: '.$idContact);

        if ($this->contactRepo->find($idContact)) {
            $this->contactRepo->delete($idContact);
            $this->session->flash('message', Lang::get("general.deletedregister"));
        }
        return $this->redirect->to('contact')->with('message', Lang::get("general.deletedregister"));
        ;
    }
}

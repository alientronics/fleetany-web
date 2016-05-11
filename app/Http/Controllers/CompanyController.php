<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\CompanyRepositoryEloquent;
use App\Entities\Company;
use Log;
use Lang;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ContactRepositoryEloquent;
use App\Entities\Contact;

class CompanyController extends Controller
{

    protected $companyRepo;
    protected $contactRepo;
    
    protected $fields = [
        'id',
        'name',
        'city',
        'country'
    ];
    
    public function __construct(CompanyRepositoryEloquent $companyRepo, ContactRepositoryEloquent $contactRepo)
    {
        parent::__construct();
        
        $this->middleware('auth');
        $this->companyRepo = $companyRepo;
        $this->contactRepo = $contactRepo;
    }

    public function index()
    {
        $filters = $this->helper->getFilters($this->request->all(), $this->fields, $this->request);
        
        $companies = $this->companyRepo->results($filters);
                
        return view("company.index", compact('companies', 'filters'));
    }
    
    public function create()
    {
        $company = new Company();
        $contact = new Contact();
        $contact_id = ContactRepositoryEloquent::getContacts();
        return view("company.edit", compact('company', 'contact', 'contact_id'));
    }

    public function store()
    {
        try {
            $this->companyRepo->validator();
            $inputs = $this->companyRepo->setInputs($this->request->all());
            $contact = $this->contactRepo->create($inputs);
            $inputs['contact_id'] = $contact->id;
            $this->companyRepo->create($inputs);
            return $this->redirect->to('company')->with('message', Lang::get(
                'general.succefullcreate',
                ['table'=> Lang::get('general.Company')]
            ));
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
                   ->with('errors', $e->getMessageBag());
        }
    }
    
    public function edit($idCompany)
    {
        $company = $this->companyRepo->find($idCompany);
        $company->company_id = $company->id;
        $this->helper->validateRecord($company);
        
        $contact = $this->contactRepo->find($company['contact_id']);
        $this->helper->validateRecord($contact);
        
        $contact_id = ContactRepositoryEloquent::getContacts();
        
        return view("company.edit", compact('company', 'contact', 'contact_id'));
    }
    
    public function update($idCompany)
    {
        try {
            $this->companyRepo->validator();
            $this->contactRepo->validator();
            
            $company = $this->companyRepo->find($idCompany);
            $inputs = $this->companyRepo->setInputs($this->request->all());
            $this->companyRepo->update($inputs, $idCompany);
            $this->contactRepo->update($inputs, $company->contact_id);
            return $this->redirect->to('/')->with('message', Lang::get(
                'general.succefullupdate',
                ['table'=> Lang::get('general.Company')]
            ));
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
                    ->with('errors', $e->getMessageBag());
        }
    }
}

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

class CompanyController extends Controller
{

    protected $companyRepo;
    
    protected $fields = [
        'id',
        'name',
        'city',
        'country'
    ];
    
    public function __construct(CompanyRepositoryEloquent $companyRepo)
    {
        parent::__construct();
        
        $this->middleware('auth');
        $this->companyRepo = $companyRepo;
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
        $contact_id = ContactRepositoryEloquent::getContacts();
        return view("company.edit", compact('company', 'contact_id'));
    }

    public function store()
    {
        try {
            $this->companyRepo->validator();
            $this->companyRepo->create($this->request->all());
            $this->session->flash(
                'message',
                Lang::get(
                    'general.succefullcreate',
                    ['table'=> Lang::get('general.Company')]
                )
            );
            return $this->redirect->to('company');
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
                   ->with('errors', $e->getMessageBag());
        }
    }
    
    public function show($idCompany)
    {
        $company = $this->companyRepo->find($idCompany);
        return view("company.show", compact('company'));
    }
    
    public function edit($idCompany)
    {
        $company = $this->companyRepo->find($idCompany);
        
        $contact_id = ContactRepositoryEloquent::getContacts();
        
        return view("company.edit", compact('company', 'contact_id'));
    }
    
    public function update($idCompany)
    {
        try {
            $this->companyRepo->validator();
            $this->companyRepo->update($this->request->all(), $idCompany);
            $this->session->flash(
                'message',
                Lang::get(
                    'general.succefullupdate',
                    ['table'=> Lang::get('general.Company')]
                )
            );
            return $this->redirect->to('company');
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
                    ->with('errors', $e->getMessageBag());
        }
    }
    
    public function destroy($idCompany)
    {
        Log::info('Delete field: '.$idCompany);

        if ($idCompany != 1 && $this->companyRepo->find($idCompany)) {
            $this->companyRepo->delete($idCompany);
            $this->session->flash('message', Lang::get("general.deletedregister"));
        }
        return $this->redirect->to('company');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\CompanyRepositoryEloquent;
use App\Entities\Company;
use Log;
use Input;
use Lang;
use Session;
use Redirect;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Repositories\HelperRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{

    protected $companyRepo;
    
    protected $fields = [
        'id',
        'contact-id',
        'name',
        'measure-units',
        'api-token'
    ];
    
    public function __construct(CompanyRepositoryEloquent $companyRepo)
    {
        $this->middleware('auth');
        $this->companyRepo = $companyRepo;
    }

    public function index(Request $request)
    {
        $objHelper = new HelperRepository();
        $filters = $objHelper->getFilters($request->all(), $this->fields, $request);
        
        $companies = $this->companyRepo->results($filters);
                
        return view("company.index", compact('companies', 'filters'));
    }
    
    public function create()
    {
        $company = new Company();
        $objHelperRepository = new HelperRepository();
        $contact_id = $objHelperRepository->getContacts();
        return view("company.edit", compact('company', 'contact_id'));
    }

    public function store()
    {
        try {
            $this->companyRepo->validator();
            $this->companyRepo->create(Input::all());
            Session::flash(
                'message',
                Lang::get(
                    'general.succefullcreate',
                    ['table'=> Lang::get('general.Company')]
                )
            );
            return Redirect::to('company');
        } catch (ValidatorException $e) {
            return Redirect::back()->withInput()
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
        
        $objHelperRepository = new HelperRepository();
        $contact_id = $objHelperRepository->getContacts();
        
        return view("company.edit", compact('company', 'contact_id'));
    }
    
    public function update($idCompany)
    {
        try {
            $this->companyRepo->validator();
            $this->companyRepo->update(Input::all(), $idCompany);
            Session::flash(
                'message',
                Lang::get(
                    'general.succefullupdate',
                    ['table'=> Lang::get('general.Company')]
                )
            );
            return Redirect::to('company');
        } catch (ValidatorException $e) {
            return Redirect::back()->withInput()
                    ->with('errors', $e->getMessageBag());
        }
    }
    
    public function destroy($idCompany)
    {
        Log::info('Delete field: '.$idCompany);

        if ($idCompany != 1 && $this->companyRepo->find($idCompany)) {
            $this->companyRepo->delete($idCompany);
            Session::flash('message', Lang::get("general.deletedregister"));
        }
        return Redirect::to('company');
    }
}

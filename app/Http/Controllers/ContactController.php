<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\ContactRepositoryEloquent;
use App\Entities\Contact;
use Log;
use Input;
use Lang;
use Session;
use Redirect;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Repositories\HelperRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{

    protected $contactRepo;
    
    protected $fields = [
        'id',
        'company-id',
        'contact-type-id',
        'name'
    ];
    
    public function __construct(ContactRepositoryEloquent $contactRepo)
    {
        $this->middleware('auth');
        $this->contactRepo = $contactRepo;
    }

    public function index(Request $request)
    {
        $objHelper = new HelperRepository();
        $filters = $objHelper->getFilters($request->all(), $this->fields, $request);
        
        $contacts = $this->contactRepo->results($filters);
                
        return view("contact.index", compact('contacts', 'filters'));
    }
    
    public function create()
    {
        $contact = new Contact();
        $objHelperRepository = new HelperRepository();
        $company_id = $objHelperRepository->getCompanies();
        $contact_type_id = $objHelperRepository->getContactTypes();
        return view("contact.edit", compact('contact', 'contact_type_id', 'company_id'));
    }

    public function store()
    {
        try {
            $this->contactRepo->validator();
            $this->contactRepo->create(Input::all());
            Session::flash(
                'message',
                Lang::get(
                    'general.succefullcreate',
                    ['table'=> Lang::get('general.Contact')]
                )
            );
            return Redirect::to('contact');
        } catch (ValidatorException $e) {
            return Redirect::back()->withInput()
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
        
        $objHelperRepository = new HelperRepository();
        $company_id = $objHelperRepository->getCompanies();
        $contact_type_id = $objHelperRepository->getContactTypes();
        
        return view("contact.edit", compact('contact', 'contact_type_id', 'company_id'));
    }
    
    public function update($idContact)
    {
        try {
            $this->contactRepo->validator();
            $this->contactRepo->update(Input::all(), $idContact);
            Session::flash(
                'message',
                Lang::get(
                    'general.succefullupdate',
                    ['table'=> Lang::get('general.Contact')]
                )
            );
            return Redirect::to('contact');
        } catch (ValidatorException $e) {
            return Redirect::back()->withInput()
                    ->with('errors', $e->getMessageBag());
        }
    }
    
    public function destroy($idContact)
    {
        Log::info('Delete field: '.$idContact);

        if ($idContact != 1 && $this->contactRepo->find($idContact)) {
            $this->contactRepo->delete($idContact);
            Session::flash('message', Lang::get("general.deletedregister"));
        }
        return Redirect::to('contact');
    }
}

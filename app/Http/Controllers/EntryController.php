<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\EntryRepositoryEloquent;
use App\Entities\Entry;
use Log;
use Input;
use Lang;
use Session;
use Redirect;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Repositories\HelperRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntryController extends Controller
{

    protected $entryRepo;
    
    protected $fields = [
        'id',
        'cost'
    ];
    
    public function __construct(EntryRepositoryEloquent $entryRepo)
    {
        $this->middleware('auth');
        $this->entryRepo = $entryRepo;
    }

    public function index(Request $request)
    {
        $objHelper = new HelperRepository();
        $filters = $objHelper->getFilters($request->all(), $this->fields, $request);
        
        $entries = $this->entryRepo->results($filters);
                
        return view("entry.index", compact('entries', 'filters'));
    }
    
    public function create()
    {
        $entry = new Entry();
        $objHelperRepository = new HelperRepository();
        $company_id = $objHelperRepository->getCompanies();
        $entry_type_id = $objHelperRepository->getEntryTypes();
        $vendor_id = $objHelperRepository->getVendors();
        $vehicle_id = $objHelperRepository->getVehicles();
        return view("entry.edit", compact('entry', 'entry_type_id', 'company_id', 'vehicle_id', 'vendor_id'));
    }

    public function store()
    {
        try {
            $this->entryRepo->validator();
            $this->entryRepo->create(Input::all());
            Session::flash(
                'message',
                Lang::get(
                    'general.succefullcreate',
                    ['table'=> Lang::get('general.Entry')]
                )
            );
            return Redirect::to('entry');
        } catch (ValidatorException $e) {
            return Redirect::back()->withInput()
                   ->with('errors', $e->getMessageBag());
        }
    }
    
    public function show($idEntry)
    {
        $entry = $this->entryRepo->find($idEntry);
        return view("entry.show", compact('entry'));
    }
    
    public function edit($idEntry)
    {
        $entry = $this->entryRepo->find($idEntry);
        
        $objHelperRepository = new HelperRepository();
        $company_id = $objHelperRepository->getCompanies();
        $entry_type_id = $objHelperRepository->getEntryTypes();
        $vendor_id = $objHelperRepository->getVendors();
        $vehicle_id = $objHelperRepository->getVehicles();
        return view("entry.edit", compact('entry', 'entry_type_id', 'company_id', 'vehicle_id', 'vendor_id'));
    }
    
    public function update($idEntry)
    {
        try {
            $this->entryRepo->validator();
            $this->entryRepo->update(Input::all(), $idEntry);
            Session::flash(
                'message',
                Lang::get(
                    'general.succefullupdate',
                    ['table'=> Lang::get('general.Entry')]
                )
            );
            return Redirect::to('entry');
        } catch (ValidatorException $e) {
            return Redirect::back()->withInput()
                    ->with('errors', $e->getMessageBag());
        }
    }
    
    public function destroy($idEntry)
    {
        Log::info('Delete field: '.$idEntry);

        if ($idEntry != 1 && $this->entryRepo->find($idEntry)) {
            $this->entryRepo->delete($idEntry);
            Session::flash('message', Lang::get("general.deletedregister"));
        }
        return Redirect::to('entry');
    }
}

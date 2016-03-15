<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\EntryRepositoryEloquent;
use App\Entities\Entry;
use Log;
use Lang;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Support\Facades\Auth;

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
        $company_id = $this->helper->getCompanies();
        $entry_type_id = $this->helper->getTypes();
        $vendor_id = $this->helper->getContacts();
        $vehicle_id = $this->helper->getVehicles();
        return view("entry.edit", compact('entry', 'entry_type_id', 'company_id', 'vehicle_id', 'vendor_id'));
    }

    public function store()
    {
        try {
            $this->entryRepo->validator();
            $this->entryRepo->create($this->request->all());
            $this->session->flash(
                'message',
                Lang::get(
                    'general.succefullcreate',
                    ['table'=> Lang::get('general.Entry')]
                )
            );
            return $this->redirect->to('entry');
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
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
        
        $company_id = $this->helper->getCompanies();
        $entry_type_id = $this->helper->getTypes();
        $vendor_id = $this->helper->getContacts();
        $vehicle_id = $this->helper->getVehicles();
        return view("entry.edit", compact('entry', 'entry_type_id', 'company_id', 'vehicle_id', 'vendor_id'));
    }
    
    public function update($idEntry)
    {
        try {
            $this->entryRepo->validator();
            $this->entryRepo->update($this->request->all(), $idEntry);
            $this->session->flash(
                'message',
                Lang::get(
                    'general.succefullupdate',
                    ['table'=> Lang::get('general.Entry')]
                )
            );
            return $this->redirect->to('entry');
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
                    ->with('errors', $e->getMessageBag());
        }
    }
    
    public function destroy($idEntry)
    {
        Log::info('Delete field: '.$idEntry);

        if ($idEntry != 1 && $this->entryRepo->find($idEntry)) {
            $this->entryRepo->delete($idEntry);
            $this->session->flash('message', Lang::get("general.deletedregister"));
        }
        return $this->redirect->to('entry');
    }
}

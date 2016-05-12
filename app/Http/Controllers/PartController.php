<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\PartRepositoryEloquent;
use App\Entities\Part;
use Log;
use Lang;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Support\Facades\Auth;
use App\Repositories\VehicleRepositoryEloquent;
use App\Repositories\ContactRepositoryEloquent;
use App\Repositories\TypeRepositoryEloquent;
use App\Repositories\ModelRepositoryEloquent;
use App\Repositories\TireSensorRepositoryEloquent;
use Illuminate\Container\Container as Application;

class PartController extends Controller
{

    protected $partRepo;
    
    protected $fields = [
        'id',
        'vehicle',
        'part-type',
        'cost'
    ];
    
    public function __construct(PartRepositoryEloquent $partRepo)
    {
        parent::__construct();
        
        $this->middleware('auth');
        $this->partRepo = $partRepo;
    }

    public function index()
    {
        $filters = $this->helper->getFilters($this->request->all(), $this->fields, $this->request);
        $parts = $this->partRepo->results($filters);

        return view("part.index", compact('parts', 'filters'));
    }
    
    public function create()
    {
        $part = new Part();
        $vehicle_id = VehicleRepositoryEloquent::getVehicles(true);
        $vendor_id = ContactRepositoryEloquent::getContacts('vendor', true);
        $part_type_id = TypeRepositoryEloquent::getTypes('part');
        $part_model_id = ModelRepositoryEloquent::getModels('part', array_keys($part_type_id->toArray())[0]);
        $part_id = self::getParts(null, true);
        $sensor_data = null;
        return view("part.edit", compact(
            'part',
            'vehicle_id',
            'vendor_id',
            'part_type_id',
            'part_model_id',
            'part_id',
            'sensor_data'
        ));
    }

    public function store()
    {
        try {
            $this->partRepo->validator();
            $inputs = $this->partRepo->setInputs($this->request->all());
            $this->partRepo->create($inputs);
            return $this->redirect->to('part')->with('message', Lang::get(
                'general.succefullcreate',
                ['table'=> Lang::get('general.Part')]
            ));
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
                   ->with('errors', $e->getMessageBag());
        }
    }
    
    public function edit($idPart)
    {
        $part = $this->partRepo->find($idPart);
        $part = $this->partRepo->getInputs($part);
        $this->helper->validateRecord($part);

        $vehicle_id = VehicleRepositoryEloquent::getVehicles(true);
        $vendor_id = ContactRepositoryEloquent::getContacts('vendor', true);
        $part_type_id = TypeRepositoryEloquent::getTypes('part');
        $part_model_id = ModelRepositoryEloquent::getModels('part', array_keys($part_type_id->toArray())[0]);
        $part_id = self::getParts($idPart, true);
        
        if ($part->partType->name == Lang::get('setup.sensor')) {
            $tireSensorRepo = new TireSensorRepositoryEloquent(new Application);
            $filters = $this->helper->getFilters($this->request->all(), $tireSensorRepo->getFields(), $this->request);
            $filters['id'] = $part->id;
            $sensor_data = $tireSensorRepo->results($filters);
        } else {
            $sensor_data = $filters = null;
        }

        return view("part.edit", compact(
            'part',
            'vehicle_id',
            'vendor_id',
            'part_type_id',
            'part_model_id',
            'part_id',
            'sensor_data',
            'filters'
        ));
    }
    
    public function update($idPart)
    {
        try {
            $part = $this->partRepo->find($idPart);
            $this->helper->validateRecord($part);
            $this->partRepo->validator();
            $inputs = $this->partRepo->setInputs(array_merge(
                ['current_part_id' => $idPart],
                $this->request->all()
            ));
            $this->partRepo->update($inputs, $idPart);
            return $this->redirect->to('part')->with('message', Lang::get(
                'general.succefullupdate',
                ['table'=> Lang::get('general.Part')]
            ));
        } catch (ValidatorException $e) {
            return $this->redirect->back()->withInput()
                    ->with('errors', $e->getMessageBag());
        }
    }
    
    public function destroy($idPart)
    {
        $part = $this->partRepo->find($idPart);
        if ($part) {
            $this->helper->validateRecord($part);
            Log::info('Delete field: '.$idPart);
            $this->partRepo->delete($idPart);
            return $this->redirect->to('part')->with('message', Lang::get("general.deletedregister"));
        } else {
            return $this->redirect->to('part')->with('message', Lang::get("general.deletedregistererror"));
        }
    }
    
    public static function getParts($idCurrentPart = null, $optionalChoice = false)
    {
        $parts = Part::where('company_id', Auth::user()['company_id']);
        
        if (!empty($idCurrentPart)) {
            $parts = $parts->where('id', '!=', $idCurrentPart);
        }
                        
        $parts = $parts->lists('number', 'id');

        if ($optionalChoice) {
            $parts->splice(0, 0, ["" => ""]);
        }
        
        return $parts;
    }
    
    public function getPartsByVehicle($idVehicle)
    {
        return PartRepositoryEloquent::getPartsByVehicle($idVehicle);
    }
}

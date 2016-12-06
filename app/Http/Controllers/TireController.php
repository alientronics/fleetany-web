<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\PartRepositoryEloquent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Repositories\TireSensorRepositoryEloquent;
use Lang;

class TireController extends Controller
{

    protected $partRepo;
    protected $tireSensorRepo;
    
    protected $fields = [
        'id',
        'entity-key',
        'name'
    ];
    
    public function __construct(PartRepositoryEloquent $partRepo, TireSensorRepositoryEloquent $tireSensorRepo)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->partRepo = $partRepo;
        $this->tireSensorRepo = $tireSensorRepo;
    }

    public function index()
    {
        $filters = $this->helper->getFilters($this->request->all(), [
                                                'id',
                                                'name',
                                                'number',
                                                'position',
                                                'vehicle',
                                                'part-type',
                                                'cost'
                                            ], $this->request);
        $filters['part-type'] = 'tire';
        $parts = $this->partRepo->results($filters);
    
        return view("part.index", compact('parts', 'filters'));
    }

    public function positionSwap(Request $request)
    {
        $success = $this->partRepo->tiresPositionSwap($request->all());
        return response()->json(['success' => $success]);
    }
    
    public function positionRemove(Request $request)
    {
        $success = $this->partRepo->tiresPositionRemove($request->all());
        return response()->json(['success' => $success]);
    }
    
    public function positionAdd(Request $request)
    {
        $success = $this->partRepo->tiresPositionAdd($request->all());
        return response()->json(['success' => $success]);
    }
    
    public function details(Request $request)
    {
        $part = $this->partRepo->tiresDetails($request->all());
        return response()->json($part);
    }
    
    public function updateStorage()
    {
        $tires = $this->partRepo->getTires();
        
        return view("vehicle.tabs.tiresstorage", compact(
            'tires'
        ));
    }
    
    public function downloadData($idPart)
    {
        ini_set('auto_detect_line_endings', true);
        $sensor_data = $filters = null;
        $filters = $this->helper->getFilters(
            $this->request->all(),
            $this->tireSensorRepo->getFields(),
            $this->request
        );
        $filters['id'] = $idPart;
        $filters['sort'] = 'created_at';
        $filters['order'] = 'desc';
        $filters['paginate'] = '*';
        $sensor_data = $this->tireSensorRepo->results($filters);


        $csvData = 'ID;';
        $csvData .= html_entity_decode(Lang::get('general.temperature')).';';
        $csvData .= html_entity_decode(Lang::get('general.pressure')).';';
        $csvData .= html_entity_decode(Lang::get('general.battery')).';';
        $csvData .= html_entity_decode(Lang::get('general.latitude')).';';
        $csvData .= html_entity_decode(Lang::get('general.longitude')).';';
        $csvData .= html_entity_decode(Lang::get('general.part_number')).';';
        $csvData .= html_entity_decode(Lang::get('general.date_and_time')).PHP_EOL;
        
        if (!empty($sensor_data)) {
            foreach ($sensor_data as $data) {
                $csvData .= $data->id.';';
                $csvData .= $data->temperature.';';
                $csvData .= $data->pressure.';';
                $csvData .= $data->battery.';';
                $csvData .= $data->latitude.';';
                $csvData .= $data->longitude.';';
                $csvData .= $data->number.';';
                $csvData .= $data->created_at.PHP_EOL;
            }
        }
        
        $response = new StreamedResponse();
        $response->setCallback(function () use ($csvData) {
            $out = fopen('php://output', 'w');
            fwrite($out, $csvData);
            fclose($out);
        });
        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'sensordata.csv');
        $response->headers->set('Content-Disposition', $disposition);
        $response->headers->set('Content-Type', 'text/csv; charset=utf8');
    
        return $response;
    }
}

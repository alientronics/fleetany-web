<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\PartRepositoryEloquent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TireController extends Controller
{

    protected $partRepo;
    
    protected $fields = [
        'id',
        'entity-key',
        'name'
    ];
    
    public function __construct(PartRepositoryEloquent $partRepo)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->partRepo = $partRepo;
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
}

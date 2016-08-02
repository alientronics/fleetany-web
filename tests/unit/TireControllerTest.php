<?php

namespace Tests\Unit;

use Tests\UnitTestCase;
use App\Entities\User;
use Illuminate\Support\Facades\Session;
use App\Entities\Part;

class TireControllerTest extends UnitTestCase
{

    public function setUp()
    {
        parent::setUp();
        Session::start();
        $this->be(User::find(1));
    }
    
    public function testPositionSwapWithInvalidPosition2()
    {
        $this->post('/tires/position/swap', ['vehicle_id' => 1,
            'position1' => 2,
            'position2' => 1,
            "_token" => csrf_token()
        ])->assertResponseStatus(200);
    }
    
    public function testPositionSwapWithValidPosition2()
    {
        $this->post('/tires/position/swap', ['vehicle_id' => 1,
            'position1' => 2,
            'position2' => 3,
            "_token" => csrf_token()
        ])->assertResponseStatus(200);
    }
    
    public function testPositionRemove()
    {
        $this->post('/tires/position/remove', ['vehicle_id' => 1,
            'position' => 2,
            "_token" => csrf_token()
        ])->assertResponseStatus(200);
    }
    
    public function testPositionAdd()
    {
        $this->post('/tires/position/add', ['part_id' => Part::where('position', 0)->first()['id'],
            'position' => 2,
            'vehicle_id' => 1,
            "_token" => csrf_token()
        ])->assertResponseStatus(200);
    }
    
    public function testDetailsByPosition()
    {
        $this->post('/tires/details', ['vehicle_id' => 1,
            'position' => 2,
            "_token" => csrf_token()
        ])->assertResponseStatus(200);
    }
    
    public function testDetailsByPartId()
    {
        $this->post('/tires/details', ['part_id' => 1,
            "_token" => csrf_token()
        ])->assertResponseStatus(200);
    }
    
    public function testUpdateStorage()
    {
        $this->get('/tires/updateStorage/' . 1)->assertResponseStatus(200);
    }
}

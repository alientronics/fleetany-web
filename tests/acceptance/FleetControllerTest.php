<?php

namespace Tests\Acceptance;

use Tests\AcceptanceTestCase;
use App\Entities\Vehicle;

class FleetControllerTest extends AcceptanceTestCase
{
    public function testView()
    {
        $this->visit('/vehicle/fleet/dashboard')
            ->see('PLACA')
        ;
    }
}

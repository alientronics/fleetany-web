<?php

namespace Tests\Unit;

use Tests\UnitTestCase;

class PartEntryModelTest extends UnitTestCase
{

    public function testHasEntry()
    {
    
        $entry = factory(\App\Entities\Entry::class)->create();
        $part = factory(\App\Entities\Part::class)->create();
        $partEntry = factory(\App\Entities\PartEntry::class)->create([
            'entry_id' => $entry->id,
            'part_id' => $part->id
        ]);
    
        $this->assertEquals($partEntry->entry->description, $entry->description);
    }
    
    public function testHasPart()
    {
    
        $part = factory(\App\Entities\Part::class)->create();
        $partEntry = factory(\App\Entities\PartEntry::class)->create([
            'part_id' => $part->id,
        ]);
    
        $this->assertEquals($partEntry->part->name, $part->name);
    }
}

<?php

// Home
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->push('Home', route('home'));
});

// Home > About
Breadcrumbs::register('about', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('About', route('about'));
});

// Home > Person
Breadcrumbs::register('person', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(Lang::get("menu.Persons"), route('person.index'));
});

Breadcrumbs::register('person.edit', function($breadcrumbs, $person = null)
{
    $breadcrumbs->parent('person');
    if($person->id) {
        $breadcrumbs->push($person->name, route('person.edit', $person->id));
    }
    else {
        $breadcrumbs->push(Lang::get("general.New"), route('person.edit'));
    }
});

// Home > ModelSensor
Breadcrumbs::register('modelsensor', function ($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(Lang::get("menu.ModelSensor"), route('modelsensor.index'));
});

Breadcrumbs::register('modelsensor.edit', function($breadcrumbs, $modelsensor = null)
{
    $breadcrumbs->parent('modelsensor');
    if($modelsensor->id) {
        $breadcrumbs->push($modelsensor->name, route('modelsensor.edit', $modelsensor->id));
    }
    else {
        $breadcrumbs->push(Lang::get("general.New"), route('modelsensor.edit'));
    }
});

// Home > modelMonitor
Breadcrumbs::register('modelmonitor', function ($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(Lang::get("menu.ModelMonitor"), route('modelmonitor.index'));
});

Breadcrumbs::register('modelmonitor.edit', function ($breadcrumbs, $modelmonitor = null)
{
    $breadcrumbs->parent('modelmonitor');
    if ($modelmonitor->id) 
    {
        $breadcrumbs->push($modelmonitor->name, route('modelmonitor.edit', $modelmonitor->id));
    }
    else 
    {
        $breadcrumbs->push(Lang::get("general.New"), route('modelmonitor.edit'));
    }
});

// Home > modelVehicle
Breadcrumbs::register('modelvehicle', function ($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(Lang::get("menu.ModelVehicle"), route('modelvehicle.index'));
});

Breadcrumbs::register('modelvehicle.edit', function ($breadcrumbs, $modelvehicle = null)
{
    $breadcrumbs->parent('modelvehicle');
    if ($modelvehicle->id) 
    {
        $breadcrumbs->push($modelvehicle->name, route('modelvehicle.edit', $modelvehicle->id));
    }
    else 
    {
        $breadcrumbs->push(Lang::get("general.New"), route('modelvehicle.edit'));
    }
});

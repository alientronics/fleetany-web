<?php

// Home
Breadcrumbs::register(
    'home',
    function ($breadcrumbs) {

        $breadcrumbs->push('Home', route('home'));
    }
);

// Home > About
Breadcrumbs::register(
    'about',
    function ($breadcrumbs) {

        $breadcrumbs->parent('home');
        $breadcrumbs->push('About', route('about'));
    }
);

// Home > Person
Breadcrumbs::register(
    'person',
    function ($breadcrumbs) {

        $breadcrumbs->parent('home');
        $breadcrumbs->push(Lang::get("menu.Persons"), route('person.index'));
    }
);

Breadcrumbs::register(
    'person.edit',
    function ($breadcrumbs, $person = null) {

        $breadcrumbs->parent('person');
        if ($person->id) {
            $breadcrumbs->push($person->name, route('person.edit', $person->id));
        } else {
            $breadcrumbs->push(Lang::get("general.New"), route('person.edit'));
        }
    }
);

// Home > company

Breadcrumbs::register(
    'company',
    function ($breadcrumbs) {
    
            $breadcrumbs->parent('home');
            $breadcrumbs->push(Lang::get("menu.Company"), route('company.index'));
    }
);

Breadcrumbs::register(
    'company.edit',
    function ($breadcrumbs, $company = null) {
    
            $breadcrumbs->parent('company');
        if ($company->id) {
            $breadcrumbs->push($company->name, route('company.edit', $company->id));
        } else {
            $breadcrumbs->push(Lang::get("general.New"), route('company.edit'));
        }
    }
);

// Home > model

Breadcrumbs::register(
    'model',
    function ($breadcrumbs) {
    
            $breadcrumbs->parent('home');
            $breadcrumbs->push(Lang::get("menu.Model"), route('model.index'));
    }
);

Breadcrumbs::register(
    'model.edit',
    function ($breadcrumbs, $model = null) {
    
            $breadcrumbs->parent('model');
        if ($model->id) {
            $breadcrumbs->push($model->name, route('model.edit', $model->id));
        } else {
            $breadcrumbs->push(Lang::get("general.New"), route('model.edit'));
        }
    }
);

// Home > vehicle

Breadcrumbs::register(
    'vehicle',
    function ($breadcrumbs) {
    
            $breadcrumbs->parent('home');
            $breadcrumbs->push(Lang::get("menu.Vehicle"), route('vehicle.index'));
    }
);

Breadcrumbs::register(
    'vehicle.edit',
    function ($breadcrumbs, $vehicle = null) {
    
            $breadcrumbs->parent('vehicle');
        if ($vehicle->id) {
            $breadcrumbs->push($vehicle->name, route('vehicle.edit', $vehicle->id));
        } else {
            $breadcrumbs->push(Lang::get("general.New"), route('vehicle.edit'));
        }
    }
);

// Home > user

Breadcrumbs::register(
    'user',
    function ($breadcrumbs) {
    
            $breadcrumbs->parent('home');
            $breadcrumbs->push(Lang::get("menu.User"), route('user.index'));
    }
);

Breadcrumbs::register(
    'user.edit',
    function ($breadcrumbs, $user = null) {
    
            $breadcrumbs->parent('user');
        if ($user->id) {
            $breadcrumbs->push($user->name, route('user.edit', $user->id));
        } else {
            $breadcrumbs->push(Lang::get("general.New"), route('user.edit'));
        }
    }
);

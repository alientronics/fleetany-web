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

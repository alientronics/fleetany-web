<?php

// Home
Breadcrumbs::register('home', function ($breadcrumbs) {

    $breadcrumbs->push('Home', route('home'));
});


// Home > About
Breadcrumbs::register('about', function ($breadcrumbs) {

    $breadcrumbs->parent('home');
    $breadcrumbs->push('About', route('about'));
});



// Home > Person
Breadcrumbs::register('person', function ($breadcrumbs) {

    $breadcrumbs->parent('home');
    $breadcrumbs->push(Lang::get("menu.Persons"), route('person.index'));
});

Breadcrumbs::register('person.edit', function ($breadcrumbs, $person = null) {

    $breadcrumbs->parent('person');
    if ($person->id) {
        $breadcrumbs->push($person->name, route('person.edit', $person->id));
    } else {
        $breadcrumbs->push(Lang::get("general.New"), route('person.edit'));
    }
});

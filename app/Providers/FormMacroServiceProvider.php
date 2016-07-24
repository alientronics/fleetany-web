<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class MacroServiceProvider
 *
 * @package App\Providers
 */
class FormMacroServiceProvider extends ServiceProvider
{
    
    
    /**
     *
     */
    public function boot()
    {
        include base_path() . '/resources/macros/form.php';
    }
    
    /**
     *
     */
    public function register()
    {
    }
}

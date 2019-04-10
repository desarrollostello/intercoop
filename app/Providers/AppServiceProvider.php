<?php
namespace Pheaks\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Contracts\Encryption;
use Illuminate\Support\ServiceProvider;

if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::extend(function($value, $compiler){
            $value = preg_replace('/(\s*)@switch\((.*)\)(?=\s)/', '$1<?php switch($2):', $value);
            $value = preg_replace('/(\s*)@endswitch(?=\s)/', '$1endswitch; ?>', $value);
            $value = preg_replace('/(\s*)@case\((.*)\)(?=\s)/', '$1case $2: ?>', $value);
            $value = preg_replace('/(?<=\s)@default(?=\s)/', 'default: ?>', $value);
            $value = preg_replace('/(?<=\s)@breakswitch(?=\s)/', '<?php break;', $value);
            return $value;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('path.public', function(){
		    return base_path()."html";
	    });

        $helpersDir = app_path() . DS . 'Http' . DS . 'Helpers' . DS;
        foreach (glob("{$helpersDir}/*.php") as $filename)
        {
            require_once $filename;
        }
    }
}

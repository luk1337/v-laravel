<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Blade::directive('escape_markdown', function ($expression) {
            return "<?php
                \$specialCharacters = ['\\\\', '`', '*', '_', '{', '}', '[', ']', '(', ')', '#', '+', '-', '!', '|'];
                \$specialCharactersEscaped = ['\\\\\\\\', '\\\\`', '\\\\*', '\\\\_', '\\\\{', '\\\\}', '\\\\[', '\\\\]', '\\\\(', '\\\\)', '\\\\#', '\\\\+', '\\\\-', '\\\\!', '\\\\|'];
                echo e(str_replace(\$specialCharacters, \$specialCharactersEscaped, {$expression}));
                ?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

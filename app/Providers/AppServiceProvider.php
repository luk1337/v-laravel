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
                \$specialCharacters = [
                    '\\\\' => '\\\\\\\\',
                    '`' => '\\\\`',
                    '*' => '\\\\*',
                    '_' => '\\\\_',
                    '#' => '\\\\#',
                    '+' => '\\\\+',
                    '-' => '\\\\-',
                    '!' => '\\\\!',
                    '|' => '\\\\|',
                    '{' => '\\\\{',
                    '}' => '\\\\}',
                    '[' => '&#91;',
                    ']' => '&#93;',
                    '(' => '\\\\(',
                    ')' => '\\\\)',
                ];
                echo str_replace(array_keys(\$specialCharacters), array_values(\$specialCharacters), {$expression});
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

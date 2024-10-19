<?php

namespace App\Providers;

use Exception;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ForeignIdColumnDefinition;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $environment = $this->app->environment();

        if ($environment === 'local') {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    public function boot(): void
    {
        Blueprint::macro(
            'primaryUlid',
            function ($prefix) {
                $prefix = Str::of($prefix);

                if ($prefix->length() > 5) {
                    throw new Exception('Prefix cannot be longer than 5 characters.');
                }

                if ($prefix->contains('_')) {
                    throw new Exception('Prefix cannot contain an underline.');
                }

                $this->string('id', 32)
                    ->primary()
                    ->default(DB::raw("generate_ulid('$prefix')"));
            },
        );

        Blueprint::macro(
            'foreignPrefixedUlid',
            fn ($column) => $this->addColumnDefinition(new ForeignIdColumnDefinition($this, [
                'type' => 'string',
                'name' => $column,
                'length' => 32,
            ])),
        );

        Blueprint::macro('prefixedUlidNullableMorph', function ($morph): void {
            $this->string("{$morph}_id", 32)->nullable();
            $this->string("{$morph}_type", 128)->nullable();
            $this->index(["{$morph}_type", "{$morph}_id"]);
        });
    }
}

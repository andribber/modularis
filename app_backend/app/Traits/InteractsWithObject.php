<?php

namespace App\Traits;

use Illuminate\Support\Arr;

trait InteractsWithObject
{
    public function setObjectValue(string $column, string $index, mixed $value): array
    {
        if (! isset($this->attributes[$column]) || is_null($this->attributes[$column])) {
            $this->attributes[$column] = '[]';
        }

        $data = json_decode($this->attributes[$column], true);
        Arr::set($data, $index, $value);

        return [$column => json_encode($data)];
    }
}

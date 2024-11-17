<?php

namespace App\Http\Queries;

use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\Exceptions\InvalidAppendQuery;
use Spatie\QueryBuilder\QueryBuilder;

class WithAppendsQueryBuilder extends QueryBuilder
{
    protected Collection $allowedAppends;

    public function __call($name, $arguments)
    {
        $result = $this->forwardCallTo($this->subject, $name, $arguments);

        /*
         * If the forwarded method call is part of a chain we can return $this
         * instead of the actual $result to keep the chain going.
         */
        if ($result === $this->subject) {
            return $this;
        }

        if ($result instanceof Model) {
            $this->addAppendsToResults(new Collection([$result]));
        }

        if ($result instanceof Collection) {
            $this->addAppendsToResults($result);
        }

        if (
            $result instanceof LengthAwarePaginator
                || $result instanceof Paginator
                || $result instanceof CursorPaginator
        ) {
            $this->addAppendsToResults(new Collection($result->items()));
        }

        return $result;
    }

    protected function allowedAppends($appends): self
    {
        $appends = is_array($appends) ? $appends : func_get_args();

        $this->allowedAppends = new Collection($appends);

        $this->ensureAllAppendsExist();

        return $this;
    }

    private function addAppendsToResults(Collection $results): void
    {
        $results->each(function ($result) {
            if ($result instanceof Model) {
                $result->append($this->request->appends()->toArray());
            }
        });
    }

    private function ensureAllAppendsExist(): void
    {
        $appends = $this->request->appends();

        $diff = $appends->diff($this->allowedAppends);

        if ($diff->count() !== 0) {
            throw InvalidAppendQuery::appendsNotAllowed($diff, $this->allowedAppends);
        }
    }
}

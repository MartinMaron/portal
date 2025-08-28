<?php

namespace App\Livewire\DataTable;

trait WithSorting
{
    public $sorts = [];

    public function sortBy($field)
    {
        if (! isset($this->sorts[$field])) {
            return $this->sorts[$field] = 'asc';
        }

        if ($this->sorts[$field] === 'asc') {
            return $this->sorts[$field] = 'desc';
        }

        unset($this->sorts[$field]);
    }

    public function hasSort($field)
    {
        return isset($this->sorts[$field]);
    }

public function sortDirection($field)
    {
        return $this->sorts[$field] ?? 'null';
    }

    public function applySorting($query)
    {
        foreach ($this->sorts as $field => $direction) {
            $query->orderBy($field, $direction);
        }

        return $query;
    }
}

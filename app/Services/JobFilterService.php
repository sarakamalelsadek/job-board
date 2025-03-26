<?php
namespace App\Services;

use App\Models\Job;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class JobFilterService
{
    protected $query;

    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    public function apply(Request $request)
    {
       
        $this->query->where('status', Job::STATUS_PUBLISHED);

        $filters = $request->filters(); 
        if (!empty($filters)) {
            $this->applyFilters($filters);
        }

        return $this->query;
    }

    protected function applyFilters(array $filters)
    {
        $this->query->where(function ($query) use ($filters) {
            foreach ($filters as $key => $value) {
                if ($key === 'OR') {
                    $query->orWhere(function ($subQuery) use ($value) {
                        $this->applyFiltersToQuery($subQuery, $value);
                    });
                } else {
                    $this->applyFiltersToQuery($query, [$key => $value]);
                }
            }
        });
    }

    protected function applyFiltersToQuery($query, array $filters)
    {
        foreach ($filters as $key => $value) {
            if (in_array($key, ['languages', 'locations', 'categories'])) {
                $query->whereHas($key, function ($subQuery) use ($value) {
                    $subQuery->whereIn('name', (array) $value);
                });
            } elseif ($key === 'salary_min') {
                $query->where('salary_min', '>=', $value);
            } elseif ($key === 'title') {
                $query->where('title', 'LIKE', "%$value%");
            }
        }
    }
}
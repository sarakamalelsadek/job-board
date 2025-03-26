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

    public function apply($request)
    {
        $this->query->where('status', Job::STATUS_PUBLISHED);

        $filters = $request->query('filter', []);
        if (!empty($filters)) {

            $this->applyFilters(json_decode($filters,true));
        }

        return $this->query;
    }

    protected function applyFilters(array $filters)
    {
        foreach ($filters as $key => $value) {
            if (is_array($value)) {
                $this->applyComplexFilters($key, $value);
            } else {
                $this->applySimpleFilter($key, $value);
            }
        }
    }

    protected function applySimpleFilter($key, $value)
    {
        if (in_array($key, ['title', 'description', 'company_name'])) {
            $this->query->where($key, 'LIKE', "%$value%");
        } elseif (in_array($key, ['salary_min', 'salary_max'])) {
            $this->query->where($key, '>=', $value);
        } elseif ($key === 'is_remote') {
            $this->query->where($key, $value);
        } elseif (in_array($key, ['job_type'])) {
            if (is_array($value)) {
                $this->query->whereIn($key, $value);
            } else {
                $this->query->where($key, $value);
            }
        } elseif (in_array($key, ['published_at', 'created_at'])) {
            $this->query->whereDate($key, '=', $value);
        }
    }

    protected function applyComplexFilters($key, array $values)
    {   

        if (in_array($key, ['languages', 'locations', 'categories'])) {
            $this->query->whereHas($key, function ($query) use ($values) {
                $query->whereIn('name', $values);
            });
        } elseif (str_starts_with($key, 'attribute:')) {
            $attributeName = str_replace('attribute:', '', $key);
            $this->query->whereHas('jobAttributeValues', function ($query) use ($attributeName, $values) {
                $query->whereHas('attribute', function ($subQuery) use ($attributeName) {
                    $subQuery->where('name', $attributeName);
                });
                
                if (is_array($values)) {
                    $query->whereIn('value', $values);
                } else {
                    $query->where('value', '=', $values);
                }
            });
        }
        dump($this->query->toRawSql());
    }
}

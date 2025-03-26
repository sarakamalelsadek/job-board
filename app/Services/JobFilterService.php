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
        $this->query->where(function ($query) use ($filters) {
            foreach ($filters as $key => $value) {
                if (is_array($value) && isset($value['OR'])) {
                    // apply OR filter
                    $query->orWhere(function ($orQuery) use ($key, $value) {
                        foreach ($value['OR'] as $orKey => $orValue) {
                            if (is_array($orValue)) {
                                $this->applyComplexFilters($orQuery, $orKey, $orValue, 'orWhere');
                            } else {
                                $this->applySimpleFilter($orQuery, $orKey, $orValue, 'orWhere');
                            }
                        }
                    });
                } else {
                    // apply AND on default
                    if (is_array($value)) {
                        $this->applyComplexFilters($query, $key, $value);
                    } else {
                        $this->applySimpleFilter($query, $key, $value);
                    }
                }
            }
        });
    }


    protected function applySimpleFilter($query, $key, $value, $method = 'where')
    {
        if (in_array($key, ['title', 'description', 'company_name'])) {
            $query->$method($key, 'LIKE', "%$value%");
        } elseif (in_array($key, ['salary_min', 'salary_max'])) {
            $query->$method($key, '>=', $value);
        } elseif ($key === 'is_remote') {
            $query->$method($key, $value);
        } elseif (in_array($key, ['job_type'])) {
            if (is_array($value)) {
                $query->$method($key, $value);
            } else {
                $query->$method($key, $value);
            }
        } elseif (in_array($key, ['published_at', 'created_at'])) {
            $query->$method($key, '=', $value);
        }
    }

    protected function applyComplexFilters($query, $key, array $values, $method = 'whereHas')
    {
        if (in_array($key, ['languages', 'locations', 'categories'])) {
            $query->$method($key, function ($subQuery) use ($values) {
                $subQuery->whereIn('name', $values);
            });
        } elseif (str_starts_with($key, 'attribute:')) {
            $attributeName = str_replace('attribute:', '', $key);
            $query->$method('jobAttributeValues', function ($subQuery) use ($attributeName, $values) {
                $subQuery->whereHas('attribute', function ($attrQuery) use ($attributeName) {
                    $attrQuery->where('name', $attributeName);
                });

                if (is_array($values)) {
                    $subQuery->whereIn('value', $values);
                } else {
                    $subQuery->where('value', '=', $values);
                }
            });
        }
    }
}

<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CoreRepository
{
    protected $model;
    protected $disk;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function index(
        $per_page = 8,
        $columns = ['*'],
        array $filters = [],
        $with = [],
        array $searchInfo = [
            'search' => null,
            'search_on_columns' => ['name'],
            'search_on_json_columns' => [],
        ],
        $orderBy = 'id',
        $orderDirection = 'desc',
        $filtersRelation = null,
        $whereIn = null
    ) {
        $query = $this->model::query();

        // علاقات eager loading
        if (!empty($with)) {
            $query->with($with);
        }

        // الفلاتر العادية
        if (!empty($filters)) {
            $query->where($filters);
        }

        // whereIn المتعددة
        if (!empty($whereIn)) {
            foreach ($whereIn as $column => $values) {
                if (!empty($values)) {
                    $query->whereIn($column, $values);
                }
            }
        }

        // علاقات بفلاتر مخصصة
        if (!is_null($filtersRelation) && is_callable($filtersRelation)) {
            $filtersRelation($query);
        }

        // البحث
        if (!empty($searchInfo['search'])) {
            $search = $searchInfo['search'];
            $searchOnColumns = $searchInfo['search_on_columns'] ?? [];
            $searchOnJsonColumns = $searchInfo['search_on_json_columns'] ?? [];

            $query->where(function ($q) use ($search, $searchOnColumns, $searchOnJsonColumns) {
                foreach ($searchOnColumns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                }

                foreach ($searchOnJsonColumns as $jsonColumn => $jsonPaths) {
                    foreach ($jsonPaths as $jsonPath) {
                        $q->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT($jsonColumn, '$.$jsonPath')) LIKE ?", ["%{$search}%"]);
                    }
                }
            });
        }

        // الترتيب
        $query->orderBy($orderBy, $orderDirection)->select($columns);

        return $per_page > 0 ? $query->paginate($per_page) : $query->get();
    }

    public function getObject($columns = ['*'], array $filters = [], $with = [])
    {
        return $this->model::query()
            ->when(count($with), function ($q) use ($with) {
                return $q->with($with);
            })
            ->when(count($filters) > 0, function ($qc) use ($filters) {
                return $qc->where($filters);
            })
            ->select($columns)->first();
    }

    public function showWithTrashed($columns = ['*'], array $filters = [], $with = [])
    {
        return $this->model::query()
            ->when(count($with), function ($q) use ($with) {
                return $q->with($with);
            })
            ->when(count($filters) > 0, function ($qc) use ($filters) {
                return $qc->where($filters);
            })
            ->withTrashed()
            ->select($columns)->first();
    }

    public function show($id)
    {
        return $this->model::find($id);
    }

    public function create($data)
    {
        DB::beginTransaction();
        try {

            $record = $this->model->create($data);
            DB::commit();

            return $record;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Model: ' . get_class($this->model) . ' | Method: create | Error: ' . $e->getMessage() . ' | Line: ' . $e->getLine());

            return null;
        }
    }

    public function update($data, $id)
    {
        DB::beginTransaction();
        try {
            $record = $this->model->find($id);
            $record->update($data);
            DB::commit();

            return $record;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Model: ' . get_class($this->model) . ' | Method: update | Error: ' . $e->getMessage() . ' | Line: ' . $e->getLine());

            return null;
        }
    }


    public function updateOrCreate($attributes, $values = [])
    {
        DB::beginTransaction();
        try {
            $record = $this->model->updateOrCreate($attributes, $values);
            DB::commit();

            return $record;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Model: ' . get_class($this->model) . ' | Method: updateOrCreate | Error: ' . $e->getMessage() . ' | Line: ' . $e->getLine());

            return null;
        }
    }

    public function delete(array $conditions): void
    {
        try {
            $model = $this->model->where($conditions)->first();
            if ($model) {
                $model->delete();
            } else {
                Log::warning('Model not found for deletion with conditions: ' . json_encode($conditions));
            }
        } catch (\Exception $e) {
            Log::error(
                'Model: ' . get_class($this->model) .
                ' | Method: delete | Error: ' . $e->getMessage() .
                ' | Conditions: ' . json_encode($conditions) .
                ' | Line: ' . $e->getLine()
            );
        }
    }
}

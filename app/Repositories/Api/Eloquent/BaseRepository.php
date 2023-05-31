<?php

namespace App\Repositories\Api\Eloquent;

use App\Repositories\Api\EloquentRepository;
use Exception;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class BaseRepository implements EloquentRepository
{
    protected $model;
    protected $query;
    protected $row;
    protected $db_transaction = false;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        // $data = $this->removeNotExistColumns($data);

        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $result = $this->model->find($id);
        // $data = $this->removeNotExistColumns($data);
        foreach ($data as $key => $value) {
            $result->$key = $value;
        }
        $result->save();

        return $result;
    }

    public function delete(int $id)
    {
        return $this->model->delete($id);
    }

    public function queryTransaction($callback)
    {
        if ($this->db_transaction) {
            try {
                DB::beginTransaction();
                $data = $callback();
                DB::commit();
                return $data;
            } catch (\Throwable $e) {
                DB::rollBack();
                if ($e instanceof QueryException) {
                    throw new Exception($e->getMessage());
                }
                $class = get_class($e);
                throw new $class($e->getMessage());
            }
        } else {
            try {
                return $callback();
            } catch (Exception $e) {
                if ($e instanceof QueryException) {
                    throw new Exception($e->getMessage());
                }
                if ($e instanceof BadResponseException) {
                    throw new Exception($e->getMessage());
                }
                $class = get_class($e);
                throw new $class($e->getMessage());
            }
        }
    }

    public function beforeCreate($data)
    {
        return $data;
    }

    public function afterCreate($row)
    {
        return $row;
    }

    public function createOrFail($data)
    {
        return $this->queryTransaction(function () use ($data) {
            $data = $this->beforeCreate($data);
            $row = $this->model->create($data);
            return $this->afterCreate($row);
        });
    }

    public function beforeUpdate($id, $data)
    {
        return $data;
    }

    public function afterUpdate($row)
    {
        return $row;
    }

    public function updateOrFail($id, $data)
    {
        $row = $this->row = $this->model->findOrFail($id);
        return $this->queryTransaction(function () use ($row, $data) {
            $data = $this->beforeUpdate($row->id, $data);
            $row->update($data);
            return $this->afterUpdate($row);
        });
    }

    public function beforeDelete($id)
    {
    }

    public function afterDelete($row)
    {
    }

    public function deleteOrFail($id)
    {
        $this->beforeDelete($id);
        return $this->model->findOrFail($id)->delete();
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    public function findInCondition(array $conditions)
    {
        $model = $this->model;
        foreach ($conditions as $key => $condition) {
            $model = $model->whereIn($key, $condition);
        }
        return $model;
    }

    public function createMany(array $data)
    {
        return $this->model->insert($data);
    }

    public function get($column = ['*'])
    {
        return $this->model->get($column);
    }
}
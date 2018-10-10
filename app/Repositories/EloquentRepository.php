<?php
namespace App\Repositories;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;

abstract class EloquentRepository implements RepositoryInterface
{
    protected $model;

    abstract public function model();

    public function __construct()
    {
        $this->app = new App();
        $this->makeModel();
    }
    
    public function makeModel()
    {
        $model = $this->app->make($this->model());
        if (!$model instanceof Model) {
            throw new Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }
        
        return $this->model = $model;
    }

    public function find($id)
    {
        try {
            return $this->model->findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json(['message' => config('api.notfound')]);
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            $result = $this->model->findOrFail($id);
            $result->update($data);
            
            return $result;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json(['message' => config('api.notfound')]);
        } catch (\Exception $exception) {
            return response()->json($exception);
        }

        return response()->json(['message' => config('api.update')]);
    }

    public function create(array $data)
    {
        try {
            $this->model->create($data);

            return response()->json(['message' => config('api.create')]);
        } catch (Exception $exception) {
            return response()->json($exception);
        }
    }

    public function getAll()
    {
        try {
            return $this->model->all();
        } catch (Exception $exception) {
            return response()->json($exception);
        }
    }

    public function delete($id)
    {
        try {
            $result = $this->model->find($id);
            $result->delete();

            return response()->json(['message' => config('api.deleted')]);
        } catch (Exception $exception) {
            return response()->json($exception);
        }
    }
}

<?php

namespace App\Repositories;

use App\Exceptions\Area\AllAreaException;
use App\Exceptions\Area\CreateAreaException;
use App\Exceptions\Area\UpdateAreaException;
use App\Exceptions\Area\DeleteAreaException;
use App\Models\Area;
use Illuminate\Support\Facades\DB;
use Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Str;

abstract class AreaRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(Area $area)
    {
        $this->model = $area;
    }
    
    public function create(array $data)
    {
        try 
        {    
            $area = $this->model->create($data);
            
            return [
                'area' => $this->find($area->id)
            ];
        }
        catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
    
    public function delete($id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find area',
                ];
            }

            $this->model->destroy($id);

            return [
                'success' => true,
                'message' => 'Deleted successfully',
                'deletedArea' => $temp,
            ];
        }
        catch (\Exception $exception) {
            throw new DeletedAreaException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find area',
                ];
            }

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'updated_area' => $this->find($temp->id),
            ];
        }
        catch (\Exception $exception) {
            throw new UpdateAreaException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try 
        {
            $area = $this->model::with('markets.customers')->find($id);
            if(!$area)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find area',
                ];
            }
            return [
                'success' => true,
                'area' => $area,
            ];
        }
        catch (\Exception $exception) {

        }
    }
    
    public function all()
    {
        try {
            return $this->model::with('markets.customers')->get();
        }
        catch (\Exception $exception) {
            throw new AllAreaException($exception->getMessage());
        }
    }

    public function paginate($pagination)
    {
        try {
            return $this->model::paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllAreaException($exception->getMessage());
        }
    }
}

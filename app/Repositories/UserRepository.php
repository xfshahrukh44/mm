<?php

namespace App\Repositories;

use App\Exceptions\User\AllUserException;
use App\Exceptions\User\CreateUserException;
use App\Exceptions\User\UpdateUserException;
use App\Exceptions\User\DeleteUserException;
use App\User;
use Illuminate\Support\Facades\DB;
use Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Str;

abstract class UserRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(User $user)
    {
        $this->model = $user;
    }
    
    public function create(array $data)
    {
        try {
            // password hashing
            if($data['password'])
            {
                $data['password'] = Hash::make($data['password']);
            }

            // if(array_key_exists('profile_picture', $data)) {
            //     $image_data = $data['profile_picture'];  // your base64 encoded
            //     $image = explode(',',$image_data);
            //     $imageName = Str::random(10).'.'.'png';
            //     \File::put(storage_path('customer/profile_picture/'). $imageName, base64_decode($image[1]));
            //     // $data['profile_picture'] = $this->model->getProfilePictureAttribute($imageName);
            //     $data['profile_picture'] = env('APP_URL') . "/app_portal/storage/customer/profile_picture/" . $imageName;
            // }
            $user = $this->model->create($data);

            $token = JWTAuth::fromUser($user);
            return response()->json([
                'user' => $user,
                'token' => $token
            ]);
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
                return response()->json([
                    'success' => false,
                    'message' => 'Could`nt find user',
                ]);
            }
            $this->model->destroy($id);
            return response()->json([
                'success' => true,
                'message' => 'Deleted successfully',
                'deletedUser' => $temp,
            ]);
        }
        catch (\Exception $exception) {
            throw new DeletedUserException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Could`nt find user',
                ]);
            }
            
            // if(array_key_exists('profile_picture', $data)) {
            //     $image_data = $data['profile_picture'];  // your base64 encoded
            //     $image = explode(',',$image_data);
            //     $imageName = Str::random(10).'.'.'png';
            //     \File::put(storage_path('customer/profile_picture/'). $imageName, base64_decode($image[1]));
            //     // $data['profile_picture'] = $this->model->getProfilePictureAttribute($imageName);
            //     $data['profile_picture'] = env('APP_URL') . "/app_portal/storage/customer/profile_picture/" . $imageName;;
            // }

            // if(array_key_exists('profile_picture', $data) && !filter_var($data['profile_picture'], FILTER_VALIDATE_URL))
            // {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Could not update user.',
            //     ]);
            // }

            $temp->update($data);
            $temp->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Updated successfully!',
                'updated_user' => $temp,
            ]);
        }
        catch (\Exception $exception) {
            throw new UpdateUserException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try {
            // return $this->model::findOrFail($id);
            $user = $this->model::find($id);
            if(!$user)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find user',
                ];
            }
            return [
                'success' => true,
                'user' => $user,
            ];
        }
        catch (\Exception $exception) {

        }
    }
    
    public function all()
    {
        try {
            return $this->model::all();
        }
        catch (\Exception $exception) {
            throw new AllUserException($exception->getMessage());
        }
    }
}

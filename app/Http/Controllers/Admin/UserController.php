<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('auth');
    }
    
    public function index()
    {
        $users = $this->userService->paginate_staff(env('PAGINATE'));
        $user_type = 'staff';
        return view('admin.user.user', compact('users', 'user_type'));
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:4|confirmed',
            'phone' => 'required|unique:users',
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);

        if(!$request['email'])
            $request['email'] = NULL;

        $request['type'] = 'user';

        $data = $this->userService->create($request->all());

        return redirect()->route('user.index');
    }
    
    public function show($id)
    {
        return $this->userService->find($id);
    }
    
    public function update(Request $request, $id)
    {
        if(!(auth()->user()->id == $id || auth()->user()->type == "superadmin"))
        {
            return response()->json([
                'success' => FALSE,
                'message' => 'Not allowed.'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'password' => 'sometimes|string|min:4|confirmed',
            'phone' => 'unique:users,phone,'.$id,
            'email' => 'sometimes|email',
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);
        
        if(auth()->user()->type != 'superadmin')
        {
            $request['type'] = 'customer';
        }

        $data = $this->userService->update($request->all(), $id);

        return redirect()->route('user.index');
    }
    
    public function destroy($id)
    {
        $this->userService->delete($id);
        return redirect()->route('user.index');
    }

    public function search_users(Request $request)
    {
        // get query
        $query = $request['query'];
        $user_type = $request['user_type'];

        // foreign fields
        // zones
        $zones = Zone::select('id')->where('name', 'LIKE', '%'.$query.'%')->get();
        $zone_ids = [];
        foreach($zones as $zone){
            array_push($zone_ids, $zone->id);
        }

        // search block
        $users = User::with('baskets')
                        ->where('type', $user_type)
                        ->where(function($q) use($zone_ids, $query){ 
                            $q->orWhereIn('zone_id', $zone_ids);
                            $q->orWhere('phone', 'LIKE', '%'.$query.'%');
                            $q->orWhere('address', 'LIKE', '%'.$query.'%');
                            $q->orWhere('name', 'LIKE', '%'.$query.'%');
                            $q->orWhere('email', 'LIKE', '%'.$query.'%');
                        })
                        ->paginate(env('PAGINATION'));
        
        $zones = Zone::all();

        return view('admin.user.user', compact('users','user_type', 'zones'));
    }
}

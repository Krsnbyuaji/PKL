<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('role')){
            return User::where('role', $request->role)->select('id', 'name', 'email', 'role')->get();
        }else{
            return User::select('id', 'name', 'email', 'role')->get();
        }
    }

    public function store(Request $request)
    {
        $request->validate([
                'name' => 'required',
                'email' => 'required',
                'password' => 'required',
                'role' => 'required'
        ]);
        
        try{

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role,
            ]);
            return response()->json([
                'message' => 'User Created Successfully!!'
            ]);
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            return response()->json([
                'message' => 'Something goes wrong while creating a user'
            ],500);
        }
    }

    public function show($id)
    {
        $user = User::find($id);

        return response()->json([
            'user'=>$user
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required'
        ]);

        try{

            $user->fill([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role,
            ])->update();
            return response()->json([
                'message' => 'User Updated Successfully!!'
            ]);

        }catch(\Exception $e){
            \Log::error($e->getMessage());
            return response()->json([
                'message' => 'Something goes wrong while updating a user'
            ],500);
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);

        try 
        {
            $user->delete();

            return response()->json([
                'message' => 'User Deleted Successfully!!'
            ]);

            }catch(\Exception $e){
            \Log::error($e->getMessage());
            return response()->json([
                'message' => 'Something goes wrong while delete user'
            ]);
        }
    }   
}
<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|min:10|unique:users,phone',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);
        return response()->json([
            'message' => 'User registered Successfuly',
            'User' => $user
        ], 201);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        if (!Auth::attempt($request->only('email', 'password')))
            return response()->json(
                [
                    'message' => 'Invalid email or password'
                ],
                401
            );
        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('token')->plainTextToken; //important row 
        return response()->json([
            'message' => 'Login Successfuly',
            'User' => $user,
            'Token' => $token,
        ], 200);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(
            [
                'message' => 'Logout Successfully'
            ],
            200
        );
    }


    public function getProfile($id)
    {
        $user_id = Auth::user()->id;
        if ($id != $user_id)
            return response()->json(['message' => 'Unauthurized'], 403);
        $profile = User::find($id)->profile;
        return response()->json($profile, 200);
    }

    public function getUserTasks($id)
    {
        $user_id = Auth::user()->id;
        if ($id != $user_id)
            return response()->json(['message' => 'Unauthurized'], 403);
        $tasks = User::findOrFail($id)->tasks;
        return response()->json($tasks, 200);
    }


















































    // public function getUserInformation(){
    //     // $users=[
    //     // ['id'=>1,'name'=>'Yasmine'],
    //     // ['id'=>2,'name'=>'Batoul'],
    //     // ['id'=>3,'name'=>'Alia']
    //     // ];
    //     // foreach($users as $user){
    //     //     echo $user['id'].')'. $user['name']."\n";
    //     // }
    //     return response()->json(["name"=>"yasmine","Age"=>22,"University"=>"IT"]);
    // }

    // public function CheckUser(int $id){
    //     if($id>10){
    //         return response()->json(['message'=>"your id is not valid for reservation"]);
    //     }
    //     else {
    //         return response()->json(['message'=>"your id is valid for reservation"]);
    //     }
    // }
}

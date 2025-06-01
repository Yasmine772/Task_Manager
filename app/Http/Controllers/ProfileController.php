<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfieRequest;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function Store(StoreProfieRequest $request)
    {
        $user_id = Auth::user()->id;
        $validatedData = $request->validated();
        $validatedData['user_id']=$user_id ;
        $profile = Profile::create($validatedData);
        return response()->json($profile, 201);
    }
}

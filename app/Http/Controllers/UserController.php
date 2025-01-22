<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try{
            $users = User::all()->makeHidden(['created_at','updated_at']);
            if($users->isEmpty()){
                return response()->json(['error' => 'No data found'], 404);
            }
            return response()->json($users);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
//    public function store(Request $request)
//    {
//        //
//    }

    /**
     * Display the specified resource.
     */
    public function show(string $id):JsonResponse
    {
        try {
            if ($id == ''){
                return response()->json(['error' => 'Id required'], 404);
            }
            $user = User::where('id', $id)->firstOrFail();
            if ($user == null){
                return response()->json(['error' => 'User not found'], 404);
            }
            return response()->json($user);
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id): JsonResponse
    {
        try {
            if ($id == ''){
                return response()->json(['error' => 'Id required'], 404);
            }
            $user = User::where('id', $id)->firstOrFail();
            if ($user == null){
                return response()->json(['error' => 'User not found'], 404);
            }
            $user->update($request->validated());
            return response()->json($user);
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id):JsonResponse
    {
        try {
            if ($id == ''){
                return response()->json(['error' => 'No data found'], 404);
            }
            $user = User::where('id', $id)->firstOrFail();
            if ($user == null){
                return response()->json(['error' => 'No data found'], 404);
            }
            $user->delete();
            return response()->json(['success' => 'User deleted'], 200);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

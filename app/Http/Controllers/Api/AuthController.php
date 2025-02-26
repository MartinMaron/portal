<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\JobDataResource;
use App\Http\Resources\UserDataResource;
use App\Http\Resources\UserMobileRessource;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                    'message' => 'Invalid login details'
                    ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();


        if ($user->isa) {
            return response()->json([
                    'message' => 'Invalid login details'
                    ], 401);
        }

        return response()->json([
                'access_token' => $user->apiToken,
                'token_type' => 'Bearer',
                'NekoWebId' => $user->id,
        ]);

    }

    public function loginMobile(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                    'message' => 'Invalid login details'
                    ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();


        if ($user->isa) {
            return response()->json([
                    'message' => 'Invalid login details'
                    ], 401);
        }

        $userRessource = new UserMobileRessource($user);
        return response()->json($userRessource);

    }








    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd("treffer");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

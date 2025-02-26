<?php
namespace App\Http\Traits\Api\Job\Register;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

trait Register
{
    public function register(Array $data)
    {

        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'function' => 'JobController.register',
                'result' => 'error',
                'errortype' => 'invalid data',
                'errors' => $validator->errors(),
                'data' => $data,
                'id' => 0,
                ]);
        }

        if ($data['email'] != 'info@e-neko.de')
        {
            if(User::where('email', $data['email'])->exists()) {
                $user = User::updateOrcreate(
                    ['email' => $data['email']],
                    ['name' => $data['name']]
                    );
            }else{
                $user = User::updateOrcreate(
                    ['email' => $data['email']],
                    ['name' => $data['name'],
                    'password' => Hash::make($data['password'])]
                    );
            }  
            $user->isMieter = $data['isMieter'];
            $user->isUser = $data['isUser'];
            $user->isAdmin = false;
            $user->save();
        }else{
            $user = User::where('email', $data['email'])->first();
        }
        
        return response()->json([
            'function' => 'JobController.register',
            'result' => 'success',
            'id' => $user->id,
            'data' => $data,
        ]);

    }
}
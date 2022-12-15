<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Models\User;
use App\Http\Controllers\BaseController as BaseController;

class AuthController extends BaseController
{

    public function signIn(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {

            $authUser = Auth::user();
            $success ["token"] = $authUser->createToken("MyAuthApp")->plainTextToken;
            $success ["name"] = $authUser->name;

            return $this->sendResponse($success, "Sikeres belépés");
        }else {

            print_r("Hibás adatok");
            return $this->sendError("Unauthorized.". ["error"=>"Hibás adatok"]);
        }
    }
    

    public function signUp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required",
            "password" => "required",
            "confirm_password" => "required|same:password",
        ]);

        if ($validator->fails()) {
            // print_r("nem jo");
            return sendError("Error validation", $validator->errors());
    }
    $input = $request->all();
    $input ["password"] = bcrypt ($input ["password"]);
    $user = User::create($input);
    $success ["name"] = $user->name;

    return $this->sendResponse($success, "Sikeres regisztráció");
    }
    
}
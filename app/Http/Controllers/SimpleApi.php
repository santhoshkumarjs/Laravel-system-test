<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class SimpleApi extends Controller
{

    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
     }
    /**
     * Write user data into text file
     *
     * @param Request $request
     *
     * @return void
     */
    public function writeData(Request $request)
    {
        $response = [];
        
        if(isset($request) && !empty($request)){
            $rules = [
                "name"=>"required",
                "address"=>"required",
                "email"=>"required|email",
                "mobile"=>"required|min:10"
            ];
            $validation = Validator::make($request->all(),$rules);
            if($validation->fails()){
                return response($validation->errors(), 402);
            }
            // valid request
            $content = [
                'name' => $request->name,
                'age' => $request->age,
                'address' => $request->address,
                'email' => $request->email,
                'mobile' => $request->mobile
            ];
            // write data into text file
            Storage::disk('local')->append('interview.txt', json_encode($content), null);

            return response(["msg"=>"Successfully write into file","status"=>"success","data"=>$content], 200);
        }
        return response(["msg"=>"Invalid Request","status"=>"fail","data"=>''], 402);
    }
}

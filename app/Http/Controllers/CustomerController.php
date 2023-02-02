<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CustomerResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Access\Response;

class CustomerController extends Controller
{
    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'fullname' => 'required',
            'age' => 'required|numeric|between:0,99',
            'email' => 'required|email|unique:Customers,email',
            'password' => 'required|min:6'
        ]);
        if($validator->fails()){
            return response()->json([
                'validationMessages' => $validator->errors()
            ], 400);
        }

        $creatings = Customer::create([
            "fullname"=>$request->fullname,
            "age"=>$request->age,
            "email"=>$request->email,
            "password"=>Hash::make($request->password),
            "creator_user_id"=>$request->user()->id,
        ]);

        if(!$creatings){
            return response()->json([
                'message' => 'Hata: Veritabanına eklenemedi.'
            ]);
        }

        return response()->json([
            'message' => 'Başarıyla veritabanına eklendi.',
            'New Customer' => new CustomerResource($creatings)
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'fullname' => 'required',
            'age' => 'required|numeric|between:0,99',
            'email' => 'required|email|unique:Customers,email',
            'password' => 'required|min:6'
        ]);

        if($validator->fails()){
            return response()->json([
                'validationMessages' => $validator->errors()
            ], 400);
        }

        $fullname=$request->fullname;
        $age=$request->age;
        $email=$request->email;
        $password=$request->password;

        $use = Customer::find($id);
        if (!$use) {
            return response()->json([
                'message' => 'Müşteri bulunamadı'
            ]);
        }
        $use = Customer::where('id',$id)->first();

        Gate::authorize('is-my-customer', $use);

        //Gate::define('is-my-customer', function (Customer $use) {
        //    return $use->isAdmin
        //                ? Response::allow()
        //                : Response::deny('You must be an administrator.');
        //});
            $result = $use->update([
                "fullname"=>$fullname,
                "age"=>$age,
                "email"=>$email,
                "password"=>Hash::make($request->$password),
            ]);
            //$result = Customer::where('id',$id)->first();
            if(!$result){
                return response()->json([
                    'message' => 'Güncellenemedi!'
                ]);
            }
            return response()->json([
                'message' => 'Başarıyla güncellendi.',
                'Updated Customer' => new CustomerResource($result)
            ]);
    }

    public function delete($id)
    {
        $use = Customer::find($id);
        if (!$use) {
            return response()->json([
                'message' => 'Müşteri bulunamadı'
            ]);
        }
        Gate::authorize('is-my-customer', $use);

        $result = $use->delete();
        if (!$result) {
            return response()->json([
                'message' => 'Silinemedi'
            ]);
        }
        return response()->json([
            'message' => 'Başarıyla silindi'
        ]);
    }

    public function read($id)
    {
        $use = Customer::find($id);
        if (!$use) {
            return response()->json([
                'message' => 'Müşteri bulunamadı'
            ]);
        }
        //$use = Customer::where('id', $id)->first();
        return  $use;
    }

    public function index(Request $request)
    {
        //dd($request->user()->id);

        $use = Customer::all();
        return $use;
    }
}

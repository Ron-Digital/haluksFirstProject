<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\StaffResource;
use App\Models\Staff;
use Illuminate\Support\Facades\Gate;

class StaffController extends Controller
{
    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'services' => 'required|array',
            'fullname' => 'required|min:3',
            'age' => 'required|numeric|between:0,99',
            'email' => 'required|email|unique:Staffs,email',
            'password' => 'required|min:6'
        ]);

        // return $validator->validated();

        if ($validator->fails()) {
            return response()->json([
                'validationMessages' => $validator->errors()
            ], 400);
        }

        $staff = Staff::create([
            "fullname" => $request->fullname,
            "age" => $request->age,
            "email" => $request->email,
            "password" => $request->password,
            "creator_user_id" => $request->user()->id
        ]);

        if (!$staff) {
            return response()->json([
                'message' => 'Hata: Veritabanına eklenemedi.'
            ]);
        }

        $staff->services()->sync($request->services);

        return response()->json([
            'message' => 'Başarıyla veritabanına eklendi.',
            'New Staff' => new StaffResource($staff)
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'services' => 'required|array',
            'fullname' => 'required|min:3',
            'age' => 'required|numeric|between:0,99',
            'email' => 'required|email|unique:Staffs,email',
            'password' => 'required|min:6'
        ]);

        // return $validator->validated();

        if ($validator->fails()) {
            return response()->json([
                'validationMessages' => $validator->errors()
            ], 400);
        }

        $fullname = $request->fullname;
        $age = $request->age;
        $email = $request->email;
        $password = $request->password;

        $use = Staff::find($id);
        if (!$use) {
            return response()->json([
                'message' => 'Kullanıcı bulunamadı'
            ]);
        }
        $use->services()->sync($request->services);

        $use = Staff::where('id', $id)->first();

        Gate::authorize('is-my-staff', $use);

        $result = $use->update([
            "fullname" => $fullname,
            "age" => $age,
            "email" => $email,
            "password" => $password
        ]);
        //$result = Staff::where('id',$id)->first();
        //$use->services()->sync($request->services);

        if ($result) {
            return response()->json([
                'message' => 'Başarıyla güncellendi.',
                'Updated Staff' => new StaffResource($use)
            ]);
        }
        if (!$result) {
            return response()->json([
                'message' => 'Güncellenemedi!'
            ]);
        }
    }

    public function delete($id)
    {
        $use = Staff::find($id);
        if (!$use) {
            return response()->json([
                'message' => 'Çalışan bulunamadı'
            ]);
        }

        Gate::authorize('is-my-staff', $use);

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
        $use = Staff::find($id);

        if (!$use) {
            return response()->json([
                'message' => 'Çalışan bulunamadı'
            ]);
        }

        //$use->services;

        return $use;
    }

    public function index()
    {
        $use = Staff::all();

        return $use;
    }
}

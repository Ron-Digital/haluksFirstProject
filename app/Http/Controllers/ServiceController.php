<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ServiceResource;
use Illuminate\Support\Facades\Gate;

class ServiceController extends Controller
{
    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'job' => 'required|min:3',
            'describe' => 'required',
            'price' => 'required|numeric',
            'duration' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'validationMessages' => $validator->errors()
            ], 400);
        }

        $creatings = Service::create([
            "job"=>$request->job,
            "describe"=>$request->describe,
            "price"=>$request->price,
            "duration"=>$request->duration,
            "creator_user_id"=>$request->user()->id,
        ]);

        if(!$creatings){
            return response()->json([
                'message' => 'Hata: Veritabanına eklenemedi.'
            ]);
        }

        return response()->json([
            'message' => 'Başarıyla veritabanına eklendi.',
            'New Service' => new ServiceResource($creatings)
        ]);
    }

    public function update(Request $request, $id)
    {
        $job=$request->job;
        $describe=$request->describe;
        $price=$request->price;
        $duration=$request->duration;

        $use = Service::find($id);
        if (!$use) {
            return response()->json([
                'message' => 'Kullanıcı bulunamadı'
            ]);
        }
        $use = Service::where('id',$id)->first();

        Gate::authorize('is-my-service', $use);

            $result = $use->update([
                "job"=>$job,
                "describe"=>$describe,
                "price"=>$price,
                "duration"=>$duration
            ]);
            $result = Service::where('id',$id)->first();
            if($result){
                return response()->json([
                    'message' => 'Başarıyla güncellendi.',
                    'Updated Service' => new ServiceResource($result)
                ]);
            }
            if(!$result){
                return response()->json([
                    'message' => 'Güncellenemedi!'
                ]);
            }
    }

    public function delete($id)
    {
        $use = Service::find($id);
        if (!$use) {
            return response()->json([
                'message' => 'Servis bulunamadı'
            ]);
        }

        Gate::authorize('is-my-service', $use);

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
        $use = Service::find($id);
        if (!$use) {
            return response()->json([
                'message' => 'Servis bulunamadı'
            ]);
        }
        //$use = Service::where('id', $id)->first();
        return  $use;
    }

    public function index()
    {
        $use = Service::all();
        if (!$use) {
            return response()->json([
                'message' => 'Hiç servis bulunamadı'
            ]);
        }
        return $use;
    }
}

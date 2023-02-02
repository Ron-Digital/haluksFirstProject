<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meeting;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\MeetingResource;
use App\Models\Service;
use App\Models\user_to_meeting;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MeetingController extends Controller
{
    public function insert(Request $request)
    {
        //$meeting = Meeting::query()->where('user_to_meeting', auth()->user()->id->get());
        $validator = Validator::make($request->all(),[
            'customer_id' => 'required|exists:customers,id',
            'staff_id' => 'required|exists:staffs,id',
            'service_id' => 'required|exists:services,id',
            'meeting_at' => 'required|date_format:Y-m-d H:i:s|after_or_equal:now',
            //'duration' => 'required'
        ]);

        $validator->after(function ($validator) use ($request) {
            $duration = Service::where('id', $request->service_id)->first()->only('duration')['duration'];
            $start_at = Carbon::create($request->meeting_at)->subMinutes($duration);
            $end_at = Carbon::create($request->meeting_at)->addMinutes($duration);

            $exists = Meeting::select('id')
                ->where('meeting_at', '>=', $start_at)
                ->where('meeting_at', '<=', $end_at)
                ->first();

            if ($exists){
                $validator->errors()->add(
                    'meeting_at', 'This date is not available for meeting'
                );
            }
        });

        if($validator->fails()){
            return response()->json([
                'validationMessages' => $validator->errors()
            ], 400);
        }

        $creatings = Meeting::create([
            "customer_id"=>$request->customer_id,
            "staff_id"=>$request->staff_id,
            "service_id"=>$request->service_id,
            "meeting_at"=>$request->meeting_at,
            "creator_user_id"=>$request->user()->id,
            "duration"=>Service::where('id', $request->service_id)->first()->only('duration')['duration']
        ]);

        if(!$creatings){
            return response()->json([
                'message' => 'Hata: Veritabanına eklenemedi.'
            ]);
        }

        return response()->json([
            'message' => 'Başarıyla veritabanına eklendi.',
            'New Meeting' => new MeetingResource($creatings)
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'customer_id' => 'required|exists:customers,id',
            'staff_id' => 'required|exists:staffs,id',
            'service_id' => 'required|exists:services,id',
            'meeting_at' => 'required|date_format:Y-m-d H:i:s|after_or_equal:now',
            //'duration' => 'required'
        ]);

        $validator->after(function ($validator) use ($request) {
            $duration = Service::where('id', $request->service_id)->first()->only('duration')['duration'];
            $start_at = Carbon::create($request->meeting_at)->subMinutes($duration);
            $end_at = Carbon::create($request->meeting_at)->addMinutes($duration);

            $exists = Meeting::select('id')
                ->where('meeting_at', '>=', $start_at)
                ->where('meeting_at', '<=', $end_at)
                ->first();
            if ($exists){
                $validator->errors()->add(
                    'meeting_at', 'This date is not available for meeting'
                );
            }
        });

        if($validator->fails()){
            return response()->json([
                'validationMessages' => $validator->errors()
            ], 400);
        }

        $customer_id=$request->customer_id;
        $staff_id=$request->staff_id;
        $service_id=$request->service_id;
        $meeting_at=$request->meeting_at;
        //$duration=$request->duration;

        $meeting = Meeting::where('id', $id)->first();

        if (!$meeting) {
            return response()->json([
                'message' => 'Randevu bulunamadı'
            ], 404);
        }
        if ($meeting->creator_user_id != $request->user()->id) {
            return response()->json([
                'message' => 'Sana ait olmayan bir randevuyu güncelleyemezsin.'
            ], 400);
        }

        $result = $meeting->update([
            "customer_id" => $customer_id,
            "staff_id" => $staff_id,
            "service_id" => $service_id,
            "meeting_at" => $meeting_at,
            "duration" => Service::where('id', $request->service_id)->first()->only('duration')['duration']
        ]);

        if(!$result){
            return response()->json([
                'message' => 'Güncellenemedi!'
            ]);
        }

        return response()->json([
            'message' => 'Başarıyla güncellendi.',
            'Updated Meeting' => new MeetingResource($meeting)
        ]);
    }

    public function delete(Request $request, $id)
    {
        $meeting = Meeting::where('id', $id)->first();

        if (!$meeting) {
            return response()->json([
                'message' => 'Böyle bir meeting yok'
            ], 404);
        }

        if ($meeting->creator_user_id != $request->user()->id) {
            return response()->json([
                'message' => 'Sana ait olmayan bir meetingi silemezsin.'
            ], 400);
        }

        DB::table('user_to_meeting')->where('meeting_id', $id)->delete();

        Meeting::where('id', $id)->delete();

        return response()->json([
            'message' => 'Başarıyla silindi',
        ]);
        /*
        $use = Meeting::find($id);
        if (!$use) {
            return response()->json([
                'message' => 'Toplantı/Randevu bulunamadı'
            ]);
        }
        $result = $use->delete();
        if (!$result) {
            return response()->json([
                'message' => 'Silinemedi!'
            ]);
        }
        return response()->json([
            'message' => 'Başarıyla silindi'
        ]);
        */
    }

    public function read($id)
    {
        $use = Meeting::find($id);
        if (!$use) {
            return response()->json([
                'message' => 'Toplantı/Randevu bulunamadı'
            ]);
        }
        //$staff = Meeting::where('id', $id)->first();
        return  $use;
    }

    public function index(Request $request)
    {
        // dd($request->user()->id);
        $meetings=Meeting::where('creator_user_id', $request->user()->id)->get();
        return $meetings;
    }

    public function meeting_staff($id)
    {
        $meeting = Meeting::find($id);

        return response()->json([
            'staff' => $meeting->staff
        ]);
    }

    public function meeting_customer($id)
    {
        $meeting = Meeting::find($id);

        return response()->json([
            'customer' => $meeting->customer
        ]);
    }

    public function meeting_service($id)
    {
        $meeting = Meeting::find($id);

        return response()->json([
            'service' => $meeting->service
        ]);
    }

}

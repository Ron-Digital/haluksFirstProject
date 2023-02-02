<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        // print_r($data);
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;

        $response = [
            'user' => new UserResource($user),
            'token' => $token
        ];

        return response($response, 201);
    }
    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:Users,email',
            'password' => 'required|min:4',
            'fullname' => 'required|min:3',
            'company' => 'required|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validationMessages' => $validator->errors()
            ], 400);
        }

        $creatings = User::create([
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "fullname" => $request->fullname,
            "company" => $request->company,
        ]);

        if (!$creatings) {
            return response()->json([
                'message' => 'Hata: Veritabanına eklenemedi.'
            ]);
        }

        //$creatings->meetings()->sync($request->meetings);

        return response()->json([
            'message' => 'Başarıyla veritabanına eklendi.',
            'New User' => new UserResource($creatings)
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'meetings' => 'required|array',
            'fullname' => 'required|min:3',
            'company' => 'required|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validationMessages' => $validator->errors()
            ], 400);
        }

        $use = User::find($id);

        if (!$use) {
            return response()->json([
                'message' => 'Kullanıcı bulunamadı'
            ], 404);
        }

        if ($request->has('fullname')) {
            $use->fullname = $request->fullname;
        }

        if ($request->has('company')) {
            $use->company = $request->company;
        }

        if ($request->has('meetings')) {
            $use->meetings()->sync($request->meetings);
        }

        $use->save();

        if (!$use) {
            return response()->json([
                'message' => 'Güncelleme başarısız!'
            ], 400);
        }
        return response()->json([
            'message' => 'Başarıyla Güncellendi'
        ], 400);

        // $use->meetings()->sync($request->meetings);

        // $use = User::where('id',$id)->first();
        //     $result = $use->update([
        //         "fullname"=>$fullname,
        //         "company"=>$company,
        //     ]);
        //     $result = User::where('id',$id)->first();
        //     if($result){
        //         return response()->json([
        //             'message' => 'Başarıyla güncellendi.',
        //             'Updated User' => new UserResource($result)
        //         ]);
        //     }
        //     if(!$result){
        //         return response()->json([
        //             'message' => 'Güncellenemedi'
        //         ]);
        //     }
    }

    public function delete(Request $request, $id)
    {
        $user = User::where('id', $id)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Böyle bir user yok'
            ], 404);
        }

        if ($user->creator_user_id != $request->user()->id) {
            return response()->json([
                'message' => 'Sana ait olmayan bir User silemezsin.'
            ], 400);
        }

        DB::table('user_to_meeting')->where('user_id', $id)->delete();

        User::where('id', $id)->delete();

        return response()->json([
            'message' => 'Başarıyla silindi',
        ]);
        /*
        $use = User::find($id);
        if (!$use) {
            return response()->json([
                'message' => 'Kullanıcı bulunamadı'
            ]);
        }
        $result = $use->delete();
        if (!$result) {
            return response()->json([
                'message' => 'silinemedi'
            ]);
        }
        return response()->json([
            'message' => 'başarıyla silindi'
        ]);
        */
    }

    public function read($id)
    {
        $use = User::find($id);
        if (!$use) {
            return response()->json([
                'message' => 'Kullanıcı bulunamadı'
            ]);
        }
        //$staff = User::where('id', $id)->first();

        $use->meetings;

        return  $use;
    }

    public function index()
    {
        $use = User::all();
        return $use;
    }

    public function arrays()
    {
        $collection = collect(['first_name' => 'Jose', 'last_name' => 'Dela Cruz', 'age' => 20]);
        print_r($collection->toArray());

        $isAccessible = Arr::accessible($collection);
        echo $isAccessible;

        $array = Arr::add(['name' => 'Desk', 'price' => null], 'price', 100);
        print_r($array);

        $array = Arr::collapse([[1, 2, 3], [4, 5, 6], [7, 8, 9]]);
        print_r($array);

        $matrix = Arr::crossJoin([1, 2], ['a', 'b']);
        print_r($matrix);

        [$keys, $values] = Arr::divide(['name' => 'Desk']);
        print_r($keys);

        $flattened = Arr::dot($array);
        print_r($flattened);

        $filtered = Arr::except($array, ['price']);
        print_r($filtered);

        $exists = Arr::exists($array, 'name');
        echo $exists;

        $flattened = Arr::flatten($array);
        print_r($flattened);

        $isAssoc = Arr::isAssoc(['product' => ['name' => 'Desk', 'price' => 100]]);
        echo $isAssoc;

        $isList = Arr::isList(['product' => ['name' => 'Desk', 'price' => 100]]);
        echo $isList;

        $array = ['first' => 'james', 'last' => 'kirk'];

        $mapped = Arr::map($array, function ($value, $key) {
            return ucfirst($value);
        });
        print_r($mapped);

        $array = ['name' => 'Desk', 'price' => 100, 'orders' => 10];
        $slice = Arr::only($array, ['name', 'price']);
        print_r($slice);

        $array = [
            ['developer' => ['id' => 1, 'name' => 'Taylor']],
            ['developer' => ['id' => 2, 'name' => 'Abigail']],
        ];
        $names = Arr::pluck($array, 'developer.name');
        print_r($names);

        $array = ['name' => 'Desk', 'price' => 100];
        $name = Arr::pull($array, 'name');
        echo $name;

        $sorted = Arr::sort($array);
        print_r($sorted);

        
    }
}

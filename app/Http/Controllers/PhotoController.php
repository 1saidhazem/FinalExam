<?php

namespace App\Http\Controllers;

use App\Models\Emp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PhotoController extends Controller
{

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'عذرا هذا الايميل غير صحيح'], 401);
        }
        if (Hash::check($request->password, $user->password)) {
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            $response = ['token' => $token];
            return response($response,200);
        } else {
            $response = ["message" => "عذرا كلمة المرور خطأ"];
            return response($response,422);
        }

    }

    public function getAllUser()
    {
        $users = User::all();  // with('Categories')->get()
        return response()->json($users);
    }

    public function getAllEmp()
    {
        $emps = Emp::all();
        return response()->json($emps);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        dd('said');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('home.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validated = Validator::make($request->all(), [
            'email' => 'required|unique:users',
            'image' =>'mimes:jpeg,jpg,png,gif|sometimes|max:2048',
            'password' => 'required|min:6',
            'conf_password' => 'required|same:password',
        ], [], [
            'image' => 'الصورة',
            'email' => 'الايميل',
            'password' => 'كلمة المرور',
            'conf_password' => 'تأكيد كلمة المرور',
        ]);


        if ($validated->fails()) {
            $msg = 'تأكد من البيانات المدخلة';
            $error = $validated->errors();
            return response()->json(compact('msg', 'error'), 422);
        }

        $user = new User();
        $user->email = $request->email;

        if ($request->file != null) {
            $path = $request->file('image')->store('public/image');
            $user->image = $path;
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['msg' => "تم الاضافة بنجاح"]);

    }

    public function getUsersByPaginate(Request $request)
    {
        $classes = User::orderBy('id', 'DESC')->
        when($request->id, function ($q) use ($request) {
            $q->where('id', 'like', '%' . $request->id . '%');
        })->
        when($request->email, function ($q) use ($request) {
            $q->where('email', 'like', '%' . $request->email . '%');
        })
            ->paginate(2);
        return response()->json($classes);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::Find($id);
        return response()->json(compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validated = Validator::make($request->all(), [
            'email' => 'required|unique:users,email,' . $id,
//            'image' =>'mimes:jpeg,jpg,png,gif|sometimes|max:10000',
//            'image' => 'sometimes|image|max:10000',
            'password' => 'sometimes|min:6',
            'conf_password' => 'sometimes|same:password',
        ], [], [
            'email' => 'الايميل',
            'image' => 'الصورة',
            'password' => 'كلمة المرور',
            'conf_password' => 'تأكيد كلمة المرور',
        ]);


        if ($validated->fails()) {
            $msg = 'تأكد من البيانات المدخلة';
            $error = $validated->errors();
            return response()->json(compact('msg', 'error'), 422);
        }
//        $path = $request->file('image')->store('public/image');
        $user = User::Find($id);
        $user->email = $request->email;
//        $user->image = $path;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return response()->json(['msg' => "تم التعديل بنجاح"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

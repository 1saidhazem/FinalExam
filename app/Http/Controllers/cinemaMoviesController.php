<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class cinemaMoviesController extends Controller
{
    public function getMovies()
    {
        $movies = Movie::all();
        return response()->json($movies);
    }

    public function getCategories()
    {
        $categories = Category::with('movies')->get();
        return response()->json($categories);
    }

    public function getMoviesByPaginate(Request $request)
    {
        $movies = Movie::orderBy('id', 'DESC')->
        when($request->nameMovie, function ($q) use ($request) {
            $q->where('nameMovie', 'like', '%' . $request->nameMovie . '%');
        })->
        when($request->showDateMovie, function ($q) use ($request) {
            $q->where('showDateMovie', 'like', '%' . $request->showDateMovie . '%');
        })->
        when($request->Category_id, function ($q) use ($request) {
            $q->where('Category_id', 'like', '%' . $request->Category_id . '%');
        })
            ->paginate(2);
        return response()->json($movies);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'nameMovie' => 'required',
            'showDateMovie' => 'required',
            'category_id' => 'required|exists:categories,id',
        ], [], [
            'nameMovie' => 'اسم الفلم',
            'showDateMovie' => 'تاريخ عرض الفيلم',
            'category_id' => 'اي دي التصنيف',
        ]);

        if ($validated->fails()) {
            $msg = 'تأكد من البيانات المدخلة';
            $error = $validated->errors();
            return response()->json(compact('msg', 'error'), 422);
        }

        $movie = new Movie();
        $movie->nameMovie = $request->nameMovie;
        $movie->showDateMovie = $request->showDateMovie;
        $movie->category_id = $request->category_id;
        $movie->save();

        return response()->json(['msg' => "تم الاضافة بنجاح"]);
    }


    public function storeCategory(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|unique:Categories',
        ], [], [
            'category_name' => 'اسم التصنيف',
        ]);


        if ($validated->fails()) {
            $msg = 'تأكد من البيانات المدخلة';
            $error = $validated->errors();
            return response()->json(compact('msg', 'error'), 422);
        }

        $category = new Category();
        $category->name = $request->name;
        $category->user_id = Auth::user()->id;
        $category->save();

        return response()->json(['msg' => "تم الاضافة بنجاح"]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
            'name' => 'required',
        ], [], [
            'name' => 'اسم التصنيف',
        ]);

        if ($validated->fails()) {
            $msg = 'تأكد من البيانات المدخلة';
            $error = $validated->errors();
            return response()->json(compact('msg', 'error'), 422);
        }

        $category = Category::Find($id);
        $category->name = $request->name;
        $category->save();

        return response()->json(['msg' => "تم التعديل بنجاح"]);
    }


    public function updateMovie(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'nameMovie' => 'required',
            'showDateMovie' => 'required|date',
        ], [], [
            'nameMovie' => 'اسم الفيلم',
            'showDateMovie' => 'تاريخ عرض الفيلم',
        ]);

        if ($validated->fails()) {
            $msg = 'تأكد من البيانات المدخلة';
            $error = $validated->errors();
            return response()->json(compact('msg', 'error'), 422);
        }

        $movie = Movie::Find($id);
        $movie->nameMovie = $request->nameMovie;
        $movie->showDateMovie = $request->showDateMovie;
        $movie->save();

        return response()->json(['msg' => "تم التعديل بنجاح"]);
    }


    public function destroyCategory($id)
    {
        $category = Category::Find($id);

        if ($category != null) {
            $category->delete();
            return response()->json(['msg' => "تم الحذف بنجاح"]);
        } else {
            return response()->json(['msg' => "تأكد من معلومات التصنيف"]);
        }
    }

    public function destroyMovie($id)
    {
        $movie = Movie::Find($id);
        if ($movie != null) {
            $movie->delete();
            return response()->json(['msg' => "تم الحذف بنجاح"]);
        } else {
            return response()->json(['msg' => "تأكد من معلومات الفيلم"]);
        }

    }
}

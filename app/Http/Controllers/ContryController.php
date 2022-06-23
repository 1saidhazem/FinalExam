<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\Count;

class ContryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $counties = Country::all();
//->get()->map(function ($q){
//            $q->name_code=$q->$name.'_'.$q->code;
//            return $q;
//        });
        return response()->json($counties);
        return view('home.create');

//        $counties = DB::table('contries')
//            ->select('contries.*');
//        dd($counties);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
//        $country = new Country();
//        $country->name="فلسطين";
//        $country->code="972";
//        $country->save();
//        return response()->json($country);

        $country = Country::find(1);
        $country->name="فلسطين";
        $country->code="970";
        $country->save();
        return response()->json($country);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Country  $contry
     * @return \Illuminate\Http\Response
     */
    public function show(Country $contry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $contry
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $contry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country  $contry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $contry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $contry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $contry)
    {
        //
    }
}

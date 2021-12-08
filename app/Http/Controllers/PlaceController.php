<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Place;

class PlaceController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Place::class, 'place');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $places = DB::table('places')
            ->select(DB::raw('
                id,
                name,
                type,
                owners_name,
                owners_surname,
                owners_patronymic
                ')
            )
        ->orderBy('name', 'asc')
        ->get();
        return response()->json(
            [
                'status' => 'success',
                'places' => $places->toArray()
            ], 200
        );
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dump ($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function show(Place $place)
    {
        $place = DB::table('places')
            ->select(DB::raw('
                id,
                name,
                type,
                owners_name,
                owners_surname,
                owners_patronymic,
                owners_email,
                owners_phone,
                (ST_X(ST_AsText(coords)),ST_Y(ST_AsText(coords))) as coords
                ')
            )->where('id', '=', $place->id)
        ->first();
        return response()->json(
            [
                'status' => 'success',
                'place' => $place
            ], 200
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function edit(Place $place)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Place $place)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function destroy(Place $place)
    {
        //
    }
}

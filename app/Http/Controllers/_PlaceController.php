<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Place;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class _PlaceController extends Controller
{
    
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Place::class, 'name');
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
        dump($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function show($name)
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
                ST_X(ST_AsText(coords)) as lat,
                ST_Y(ST_AsText(coords)) as lng
                ')
            )->where('name', '=', $name)
        ->first();
/*                if (! Gate::allows('view-place', $place)) {
            return response()->json(
            [
                'status' => 'error',
                'message' => 'Unauth'
            ], 403
        );
        }*/
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

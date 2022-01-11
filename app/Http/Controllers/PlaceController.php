<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlaceRequest;
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
        return response()->json(
            [
                'status' => 'success',
                'places' => $this->getAll()
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
     * @param  App\Http\Requests\StorePlaceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePlaceRequest $request)
    {
        $result = Place::create($request->all());
        return response()->json(
            [
                'status' => 'success',
                'places' => $this->getAll(),
                'current' => $result
            ], 200
        );
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
                (ST_X(ST_AsText(coords)),ST_Y(ST_AsText(coords))) as coords,
                comments
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
     * @param  App\Http\Requests\StorePlaceRequest  $request
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function update(StorePlaceRequest $request, Place $place)
    {
        $result = Place::whereId($request->id)->update($request->all());
        return response()->json(
            [
                'status' => 'success',
                'places' => $this->getAll(),
                'current' => Place::find($request->id)
            ], 200
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function destroy(Place $place)
    {
        $result = 0;
        $status = 'error';
        $code = 422;
        if (!empty($place->id)) {
            $result = Place::find($place->id)->delete();
            $status = 'success';
            $code = 200;
        }
        return response()->json(
            compact('status', 'result'), $code
        );
    }

    /**
     * @return \App\Models\Place[]
     */
    protected function getAll()
    {
        $all = DB::table('places')
            ->select(DB::raw('
                id,
                name,
                type,
                owners_name,
                owners_surname,
                owners_patronymic,
                owners_email,
                owners_phone,
                (ST_X(ST_AsText(coords)),ST_Y(ST_AsText(coords))) as coords,
                comments
                ')
            )
        ->orderBy('name', 'asc')
        ->get();
        if(!empty($all)) {
            return $all->toArray();
        } else {
            return [];
        }
    }
}

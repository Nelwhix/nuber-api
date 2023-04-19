<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
           'year' => 'required|numeric|between:2010,2024',
            'make' => 'required',
            'model' => 'required',
            'color' => 'required|alpha',
            'license_plate' => 'required',
            'name' => 'required'
        ]);

        $user = $request->user();
        $user->update(['name' => $request->name]);

        $user->driver()->create([
           'year' => $request->year,
           'make' => $request->make,
           'model' => $request->model,
           'color' => $request->color,
           'license_plate' => $request->license_plate,
        ]);

        $user->load('driver');

        return response()->json([
            'message' => 'successful',
            'user' => $user
        ], Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $user = $request->user();
        $user->load('driver');

        return response()->json([
           'messsage' => 'successful',
           'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

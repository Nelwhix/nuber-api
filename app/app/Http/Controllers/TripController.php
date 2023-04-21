<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    public function store(Request $request)
    {
        $request->validate([
           'origin' => 'required',
            'destination' => 'required',
            'destination_name' => 'required'
        ]);

        $trip = $request->user()->trips()->create([
           'origin' => $request->origin,
           'destination' => $request->destination,
            'destination_name' => $request->destination_name
        ]);

        return response()->json([
            'message' => 'successful',
            'trip' => $trip
        ], Response::HTTP_CREATED);
    }


    public function show(Request $request, Trip $trip)
    {
        if ($trip->user->id === $request->user()->id) {
           return response()->json([
               'message' => 'successful',
               'trip' => $trip
           ]);
        }

        if ($trip->driver && $request->user()->driver) {
            if ($trip->driver->id !== $request->user()->driver->id) {
                return response()->json([
                    'message' => 'successful',
                    'trip' => $trip
                ]);
            }
        }

        return response()->json([
            'message' => 'Cannot find trip'
        ], Response::HTTP_NOT_FOUND);
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

    public function accept(Request $request, Trip $trip)
    {
        $request->validate([
           'driver_location' => 'required'
        ]);

        $trip->update([
           'driver_id' => $request->user()->id,
           'driver_location' => $request->driver_location
        ]);

        $trip->load('driver.user');

        return response()->json([
           'message' => 'successful',
           'trip' => $trip
        ]);
    }

    public function start(Request $request, Trip $trip)
    {
        $trip->update([
           'is_started' => true
        ]);

        $trip->load('driver.user');

        return response()->json([
            'message' => 'successful',
            'trip' => $trip
        ]);
    }

    public function end(Request $request, Trip $trip)
    {
        $trip->update([
            'is_complete' => true
        ]);

        $trip->load('driver.user');

        return response()->json([
            'message' => 'successful',
            'trip' => $trip
        ]);
    }

    public function location(Request $request, Trip $trip)
    {
        $request->validate([
           'driver_location' => 'required'
        ]);

        $trip->update([
            'driver_location' => $request->driver_location
        ]);

        return response()->json([
            'message' => 'successful',
            'trip' => $trip
        ]);
    }
}

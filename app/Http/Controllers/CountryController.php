<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $countries = Country::all();

        return response()->json([
            'countries' => $countries
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:30',
            'capitale' => 'required|string|max:30',
            'population' => 'required|integer|min:1',
            'region' => 'required|string',
            'flag' => 'required|file|mimes:jpg,png,webp|max:10240',
            'language' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->hasFile('flag') && $request->file('flag')->isValid()) {
            $file = $request->file('flag');

            $filename = 'flag_' . time() . '.' . $file->getClientOriginalExtension();

            $file->storeAs('public/uploads', $filename);

        } else {
            return response()->json([
                'message' => 'Flag image upload failed'
            ], 404);
        }

        try{

            $country = new Country();
            $country -> name = $request -> name;
            $country -> capitale = $request -> capitale;
            $country -> population = $request -> population;
            $country -> region = $request -> region;
            $country -> flag = $filename;
            $country -> language = $request -> language;
            $country -> save();

        } catch (Exception $e) {
            return response()->json([
                'message' => 'could not save your changes',
                'error' => $e -> getMessage(),
            ], 201);
        }


        return response()->json([
            'message' => 'Country Successfully Added',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id) {

        $country = Country::find((int) $id);

        if ($country) {
            return response()->json(['status' => 'success', 'country' => $country], 200);
        }
        
        return response()->json(['status' => 'failed', 'message' => 'Country not found'], 404);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $country) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'name' => 'string|max:30',
            'capitale' => 'string|max:30',
            'population' => 'integer',
            'region' => 'string',
            'flag' => 'file|mimes:jpg,png,webp|max:10240',
            'language' => 'string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $filename = null;

        if ($request->hasFile('flag')) {
            if ($request->file('flag')->isValid()) {
                $file = $request->file('flag');
    
                $filename = 'flag_' . time() . '.' . $file->getClientOriginalExtension();
    
                $file->storeAs('public/uploads', $filename);
    
            } else {
                return response()->json([
                    'message' => 'Flag image upload failed'
                ], 404);
            }
        }

        try{

            $country = Country::find((int) $id);
            if ($request -> name) {$country -> name = $request -> name;}
            if ($request -> capitale) {$country -> capitale = $request -> capitale;}
            if ($request -> population) {$country -> population = $request -> population;}
            if ($request -> region) {$country -> region = $request -> region;}
            if ($filename) {$country -> flag = $filename;}
            if ($request -> language) {$country -> language = $request -> language;}
            $country -> save();

        } catch (Exception $e) {
            return response()->json([
                'message' => 'could not save your changes',
                'error' => $e -> getMessage(),
            ], 201);
        }


        return response()->json([
            'message' => 'Country Successfully Updated',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        
        Country::destroy((int) $id);

        return response()->json(['message' => 'successfully deleted'], 200);        

    }

    public function flag($id) {

        $country = Country::find((int) $id);

        // Get the full path of the image
        $path = storage_path('app/private/public/uploads/' . $country -> flag);

        // Check if the file exists
        if (!file_exists($path)) {
            abort(404); // File not found
        }

        // Return the image as a response
        return response()->file($path);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProfileResource::collection(Profile::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $profile = Profile::create([
            ...$request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'dob' => 'nullable|string|max:255',
                'phone_number' => 'required|string|max:255',
                'description' => 'nullable|string|max:255',
                'photo_url' => 'nullable|string|max:255',
            ]),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        return new ProfileResource($profile);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profile $profile)
    {
        $profile->update(
            $request->validate([
                'first_name' => 'sometimes|string|max:255',
                'last_name' => 'sometimes|string|max:255',
                'dob' => 'nullable|string|max:255',
                'phone_number' => 'sometimes|string|max:255',
                'description' => 'nullable|string|max:255',
                'photo_url' => 'nullable|string|max:255',
            ])
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        $profile->delete();
        return response()->json([
            'message' => 'Profile deleted successfully',
        ]);
    }
}

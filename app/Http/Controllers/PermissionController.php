<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Permission::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullname' => "required|string",
            'acronym' => 'required|string|max:12',
            'description' => 'required|string',
        ]);
        Permission::create($validated);

        return response()->noContent();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $specified = Permission::find($id);

        return response()->json($specified, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'fullname' => "required|string",
            'acronym' => 'required|string|max:12',
            'description' => 'required|string',
        ]);
        $findrole = Permission::find($id);
        $findrole->update($validated);

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $finds = Permission::find($id);
        $finds->delete();
    }
}

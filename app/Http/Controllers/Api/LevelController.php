<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LevelCollection;
use App\Http\Resources\LevelResource;
use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(int $sound_id)
    {
        return $this->withSuccess(new LevelCollection(Level::where('sound_id', $sound_id)->get()));
    }

    public function show(string $id)
    {
        return $this->withSuccess(new LevelResource(Level::findOrFail($id)));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

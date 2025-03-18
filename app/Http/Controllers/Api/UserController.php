<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends BaseController
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
    public function delete(User $user)
    {
        if ($user->trashed()) {
            return $this->withSuccess(message:__('api.This account has been deleted'));
        }
        $user->delete();
        return $this->withSuccess(message:__('api.This account has been deleted'));
    }

    public function forceDelete(User $user)
    {
        if (!$user->trashed()) {
            $user->delete();
            return $this->withSuccess(message:__('api.This account has been deleted'));
        }
        $user->forceDelete();
        return $this->withSuccess(message:__('api.This account has been deleted for ever'));
    }
}

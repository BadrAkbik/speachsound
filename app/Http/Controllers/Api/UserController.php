<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
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
            return $this->sendMessage(__('api.This account has been deleted'), 200);
        }
        $user->delete();
        return $this->sendMessage(__('api.This account has been deleted'), 200);
    }

    public function forceDelete(User $user)
    {
        if (!$user->trashed()) {
            $user->delete();
            return $this->sendMessage(__('api.This account has been deleted'), 200);
        }
        $user->forceDelete();
        return $this->sendMessage(__('api.This account has been deleted for ever'), 200);
    }
}

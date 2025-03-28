<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AgeCollection;
use App\Models\Age;


class AgeController extends Controller
{
    public function index()
    {
        return new AgeCollection(Age::select('id', 'age')->get());
    }
}

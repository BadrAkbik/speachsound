<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AgeCollection;
use App\Models\Age;


class AgeController extends BaseController
{
    public function index()
    {
        return $this->withSuccess(new AgeCollection(Age::select('id', 'age')->get()));
    }
}

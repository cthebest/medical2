<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class PublicServiceController extends Controller
{
    public function index()
    {
        return response()->json(Service::all());
    }
}

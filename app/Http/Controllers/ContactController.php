<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{

    public function create(Request $request)
    {
        //Inertia::share('props', ['errors' => 'Error']);
        return Inertia('Public/Contact/Index');
    }

    public function send(Request $request)
    {

        $request->validate([
            'name' => 'required'
        ]);
    }
}

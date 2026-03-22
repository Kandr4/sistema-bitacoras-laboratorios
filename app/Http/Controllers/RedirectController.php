<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectController extends Controller
{
     public function index()
    {
        $user = Auth::user();

        if ($user->rol == 'Admin') {
            return redirect('/admin');
        }

        if ($user->rol == 'Profesor') {
            return redirect('/profesor');
        }

        if ($user->rol == 'Técnico') {
            return redirect('/tecnico');
        }
        return redirect('/');

    }
}

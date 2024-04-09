<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function getUserProfile(Request $request)
    {
        $user = $request->user();
        $user->load('personne.grade', 'personne.fonction', 'personne.service', 'personne.echelle', 'personne.chef');
        return response()->json(['user' => $user]);
    }
    public function index()
    {
        // 
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Request $request)
    {
        //
    }

    public function update(Request $request, User $user)
    {
        //
    }

    public function destroy(User $user)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Personne;
use Illuminate\Http\Request;

class PersonneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $personnes = Personne::all();
        return view('personne.index', compact('personnes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
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
    public function show(Personne $Personne)
    {
        return view('personne.show', ['personne' => $Personne]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Personne $personne)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Personne $personne)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Personne $personne)
    {
        //
    }
}

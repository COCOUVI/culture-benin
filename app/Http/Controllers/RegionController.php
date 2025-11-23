<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegionRequest;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $regions = Region::all();
        return view('regions.index', compact('regions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('regions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRegionRequest $request)
    {
        Region::create($request->validated());

        return back()->with('success', 'La région a été ajoutée avec succès !');
    }


    /**
     * Display the specified resource.
     */
    public function show(Region $region)
    {
        //
        return view('regions.show', compact('region'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Region $region)
    {
        //
        return view('regions.edit', compact('region'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRegionRequest $request, Region $region)
    {
        //
        $region->update($request->validated());

        return back()->with('success', 'La région a été modifiée avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Region $region)
    {
        //
        $region->delete();
        return redirect()->back()->with('deleted', 'Region deleted successfully');
    }
}

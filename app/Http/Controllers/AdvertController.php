<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdvertRequest;
use App\Models\Company;
use App\Models\Advert;
use Illuminate\Http\RedirectResponse;

class AdvertController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $adverts = Advert::latest()->paginate(5);
        $companies = Company::all();
        return view('admin.adverts.index', compact('adverts', 'companies'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::all();
        return view('adverts.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdvertRequest $request): RedirectResponse
    {
        $validateData = $request->validated();

        Advert::create($validateData);

        return redirect()->route('adverts.index')->with('success', 'Advert created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $advert = Advert::findOrFail($id);
        return view('adverts.show', compact('advert'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $advert = Advert::findOrFail($id);
        $companies = Company::all();
        return view('adverts.edit', compact('advert', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAdvertRequest $request, string $id): RedirectResponse
    {
        $validatedData = $request->validated();

        $company = Advert::findOrFail($id);
        $company->update($validatedData);

        return redirect()->route('adverts.index')->with('success', 'Advert updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $advert = Advert::findOrFail($id);
        $advert->delete();

        return redirect()->route('adverts.index')->with('success', 'Advert deleted successfully.');
    }
}
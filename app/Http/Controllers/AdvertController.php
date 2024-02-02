<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdvertRequest;
use App\Models\Company;
use App\Models\Advert;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdvertController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $adverts = Advert::latest()->with('company')->paginate(5);
        $companies = Company::all();

        return view('admin.adverts.index', compact('adverts', 'companies'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function home(): View
    {
        $adverts = Advert::latest()->with('company')->paginate(4);
        $companies = Company::all();

        return view('welcome', compact('adverts'))
            ->with('i', (request()->input('page', 1) - 1) * 4);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $companies = Company::all();
        return view('adverts.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdvertRequest $request)
    {


        $validatedData = $request->validated();

        Advert::create($validatedData);
        // dd($validatedData);

        return redirect()->route('adverts.index')->with('success', 'Advert created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $advert = Advert::findOrFail($id);

        return view('adverts.show', compact('advert'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
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

        $advert = Advert::findOrFail($id);
        $advert->update($validatedData);

        return redirect()->route('adverts.index')->with('success', 'Advert updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */

   public function destroy(string $id): RedirectResponse
    {
        $advert = Advert::findOrFail($id);
        $advert->delete();

        return redirect()->route('adverts.index')->with('success', 'Advert deleted successfully.');
    }
}
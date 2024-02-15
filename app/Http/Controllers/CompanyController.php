<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Models\Company;
use App\Http\Requests\StoreCompanyRequest;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CompanyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['permission:company-list|create-company|edit-company|delete-company'], ['only' => ['index', 'show']]);
        $this->middleware('permission:create-company', ['only' => ['create', 'store']]);
        $this->middleware('permission:update-company', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-company', ['only' => 'destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::latest()->paginate(5);

        return view('admin.companies.index', compact('companies'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function search(Request $request)
    {
        $searchString = $request->input('search_string');

        $companies = Company::where('name', 'like', '%' . $searchString . '%')
            ->orWhere('content', 'like', '%' . $searchString . '%')
            ->orWhere('size', 'like', '%' . $searchString . '%')
            ->orWhere('location', 'like', '%' . $searchString . '%')
            ->get();

            if (count($companies)) {
                return response()->json($companies);
            } else {
                return response()->json(['status' => 'not found']);
            }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        Company::create($validatedData);

        Alert::toast('Company created successfully.', 'success');

        return redirect()->route('companies.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $company = Company::findOrFail($id);
        $adverts = $company->adverts;
        return view('companies.show', compact('company', 'adverts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $company = Company::findOrFail($id);
        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCompanyRequest $request, string $id): RedirectResponse
    {
        $validatedData = $request->validated();

        $company = Company::findOrFail($id);
        $company->update($validatedData);

        Alert::toast('Company updated successfully.', 'success');


        return redirect()->route('companies.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        Alert::toast('Company deleted successfully.', 'success');

        return redirect()->route('companies.index');

   }
}
<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdvertRequest;
use App\Models\Company;
use App\Models\Advert;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class AdvertController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['permission:advert-list|create-advert|edit-advert|delete-advert'], ['only' => ['index', 'show']]);
        $this->middleware('permission:create-advert', ['only' => ['create', 'store']]);
        $this->middleware('permission:update-advert', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-advert', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $adverts = Advert::latest()->with('company', 'skills')->paginate(5);
        $companies = Company::all();
        $skills = Skill::all();

        return view('admin.adverts.index', compact('adverts', 'companies', 'skills'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    function search(Request $request)
    {
        $searchString = $request->input('search_string');

        $adverts = Advert::with('Company')
            ->where(function ($query) use ($searchString) {
                $query->where('title', 'like', '%' . $searchString . '%')
                    ->orWhere('content', 'like', '%' . $searchString . '%')
                    ->orWhereHas('company', function ($companyQuery) use ($searchString) {
                        $companyQuery->where('name', 'like', '%' . $searchString . '%');
                    });
            })
            ->get();

        if (count($adverts)) {
            return response()->json($adverts);
        } else {
            return response()->json(['status' => 'not found']);
        }
    }
    public function home(): View
    {
        $user = User::find(Auth::id());

        if ($user) {
            if ($user->isAdmin()) {

                $adverts = Advert::latest()->with('company', 'skills')->paginate(8);
            } else {

                $userSkills = $user->skills;
                $halfSkillsCount = $userSkills->count() / 2;

                $adverts = Advert::whereHas('skills', function ($query) use ($userSkills) {
                    $query->whereIn('id', $userSkills->pluck('id'));
                })
                    ->with('company', 'skills') 
                    ->latest()
                    ->paginate(8);
            }
        } else {

            return redirect()->route('/');
        }

        $companies = Company::all();
        $skills = Skill::all();

        return view('welcome', compact('adverts', 'companies', 'skills'))
            ->with('i', (request()->input('page', 1) - 1) * 8);
    }


    public function apply(Request $request, Advert $advert)
    {
        if (Auth::check()) {
            $user = User::find(Auth::id());

            if ($user->isAdmin()) {
                return response()->json(['message' => 'Administrators and super administrators cannot apply to advertisements'], 403);
            }

            if ($advert->users()->where('user_id', $user->id)->exists()) {
                return response()->json(['message' => 'You have already applied to this advertisement'], 400);
            }

            $advert->users()->attach($user);

            return response()->json(['message' => 'Application successful'], 200);
        } else {
            return redirect('/register');
        }
    }


    public function create(): View
    {
        $companies = Company::all();
        $skills = Skill::all();
        return view('admin.adverts.create', compact('companies', 'skills'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdvertRequest $request)
    {
        $validatedData = $request->validated();

        $advert = Advert::create($validatedData);

        $selectedSkills = $request->input('skills', []);

        $advert->skills()->sync($selectedSkills);

        return response()->json([
            'message' => 'Advert created successfully',
            'redirect_url' => route('adverts.index')
        ]);
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
        $skills = Skill::all();

        return view('admin.adverts.edit', compact('advert', 'companies', 'skills'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAdvertRequest $request, string $id)
    {

        $validatedData = $request->validated();

        $advert = Advert::findOrFail($id);
        $advert->update($validatedData);

        return response()->json([
            'message' => 'Advert created successfully',
            'redirect_url' => route('adverts.index')
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Request $request, string $id): JsonResponse
    {
        if ($request) {
            $advert = Advert::findOrFail($id);
            $advert->delete();
            return response()->json(['status' => 'success', 'message' => 'Success! Advert is deleted']);
        }

        return response()->json(['status' => 'success', 'message' => 'Failed! Unable to delete Advert']);
    }
}
<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSkillRequest;
use App\Models\Skill;
use Illuminate\Http\Request;
use App\Http\Requests\SkillRequest;

class SkillController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['permission:skill-list|create-skill|edit-skill|delete-skill'], ['only' => ['index', 'show']]);
        $this->middleware('permission:create-skill', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-skill', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-skill', ['only' => 'destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skills = Skill::latest()->paginate(5);;
        return view('admin.skills.index', compact('skills'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.skills.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSkillRequest $request)
    {
        Skill::create($request->validated());

        return redirect()->route('skills.index')
            ->with('success', 'Skill created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Skill $skill)
    {
        return view('skills.show', compact('skill'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skill $skill)
    {
        return view('admin.skills.edit', compact('skill'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreSkillRequest $request, Skill $skill)
    {
        $skill->update($request->validated());

        return redirect()->route('skills.index')
            ->with('success', 'Skill updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill)
    {

        if ($skill) {
            $skill->delete();
            return response()->json(['status' => 'success', 'message' => 'Success! Skill is deleted']);
        }

        return response()->json(['status' => 'success', 'message' => 'Failed! Unable to delete Skill']);
    }
}
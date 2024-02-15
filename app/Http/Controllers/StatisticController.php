<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\Advert;
use App\Models\Skill;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Termwind\Components\Raw;

class StatisticController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalCompanies = Company::count();
        $totalAdverts = Advert::count();
        $totalSkills = Skill::count();




        // $skillWithMostAdverts = Skill::withCount('adverts')
        //     ->orderByDesc('adverts_count')
        //     ->first();

        // echo $skillWithMostAdverts->name;
        // dd($skillWithMostAdverts->name);




        return view('dashboard', compact('totalUsers', 'totalCompanies', 'totalAdverts', 'totalSkills'));
    }
}
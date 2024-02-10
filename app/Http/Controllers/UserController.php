<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $data = User::latest()->paginate(5);
        return view('users.index', compact('data'));
    }


    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('users.create', compact('roles'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'image' => 'image',
            'roles' => 'required'
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->storeAs('public/avatars/', $imageName);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'image' => $imageName,
            'password' => Hash::make($request->password),
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('users.edit', compact('user', 'roles', 'userRole'));
    }


    public function update(Request $request, string $id)
{
    $this->validate($request, [
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . $id,
        'password' => 'same:confirm-password',
        'roles' => 'required'
    ]);

    $user = User::find($id);

    // Vérifie si un nouveau fichier image est téléchargé
    if ($request->hasFile('image')) {
        // Supprime l'image précédente s'il en existe une
        if ($user->image) {
            // Supprime l'image précédente du stockage
            Storage::delete('public/avatars/' . $user->image);
        }

        // Télécharge et enregistre la nouvelle image
        $image = $request->file('image');
        $imageName = $image->getClientOriginalName();
        $image->storeAs('public/avatars/', $imageName);
        $user->image = $imageName;
    } else{
        $user->image = $user->image;
    }

    $input = $request->all();
    // Met à jour le mot de passe si un nouveau mot de passe est fourni
    if (!empty($input['password'])) {
        $input['password'] = Hash::make($input['password']);
    } else {
        // Sinon, exclut le champ de mot de passe de la mise à jour
        $input = Arr::except($input, ['password']);
    }

    // Met à jour les autres champs de l'utilisateur
    $user->update($input);

    // Supprime les rôles précédents de l'utilisateur
    DB::table('model_has_roles')->where('model_id', $id)->delete();
    // Attribue les nouveaux rôles à l'utilisateur
    $user->assignRole($request->input('roles'));

    return redirect()->route('users.index')
        ->with('success', 'User updated successfully');
}



    public function destroy($id)
    {
        if ($id) {
            User::find($id)->delete();
            return response()->json(['status' => 'success', 'message' => 'Success! User is deleted']);
        }

        return response()->json(['status' => 'success', 'message' => 'Failed! Unable to delete User']);
    }


}
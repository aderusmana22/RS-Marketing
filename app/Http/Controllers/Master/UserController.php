<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Department;
use App\Models\Master\Position;
use App\Models\Master\Section;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view user', ['only' => ['index']]);
        $this->middleware('permission:create user', ['only' => ['create','store']]);
        $this->middleware('permission:update user', ['only' => ['update','edit']]);
        $this->middleware('permission:delete user', ['only' => ['destroy']]);
    }


    public function index()
    {
        $departments = Department::all();
        $positions = Position::all();
        $roles = Role::pluck('name', 'name')->all();
        $sections = Section::all();
        $users = User::with('department.position.section')->get();

        // Dialog Sweet Alert
        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view('page.master.users.index', ['users' => $users, 'departments' => $departments, 'positions' => $positions, 'roles' => $roles, 'sections' => $sections]);
    }

    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('page.master.users.create', ['roles' => $roles]);
    }

    public function store(Request $request)
    {
        // \dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:20',
            'nik' => 'required|string|max:6|unique:users,nik',
            'roles' => 'required'
        ]);

        $user = User::create([

            'name' => $request->name,
            'email' => $request->email,
            'nik' => $request->nik,
            'department_id' => $request->department_id,
            'position_id' => $request->position_id,
            'section_id' => $request->section_id,
            'password' => Hash::make($request->password),
        ]);

        $user->syncRoles($request->roles);

        Alert::success('Success', 'User created successfully with roles');

        return redirect('/users')->with('status','User created successfully with roles');
    }

    public function edit(User $user)
    {
        $roles = Role::pluck('name','name')->all();
        $userRoles = $user->roles->pluck('name','name')->all();
        return view('master.user.edit', [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles
        ]);
    }

    public function update(Request $request, User $user)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'password' => 'nullable|string|min:8|max:20',
                'roles' => 'required',
                'section_id' => 'required|exists:sections,id',
                'position_id' => 'required|exists:positions,id',
                'department_id' => 'required|exists:departments,id',
            ]);

            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'nik' => $request->nik,
                'section_id' => $request->section_id,
                'position_id' => $request->position_id,
                'department_id' => $request->department_id,
            ];

            if(!empty($request->password)){
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);
            $user->syncRoles($request->roles);

            Alert::success('Success', 'User updated successfully with roles');

            return redirect('/users')->with('status','User Updated Successfully with roles');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to update user: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function destroy($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        return redirect('/users')->with('status','User Delete Successfully');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255' . $request->user()->id,
            'password' => 'nullable|string|min:8|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = $request->user();
        $user->name = $request->name;
        $user->email = $request->email;

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if it exists
            if ($user->avatar) {
                Storage::disk('public')->delete('user_avatars/' . $user->avatar);
            }

            // Get original extension
            $extension = $request->avatar->getClientOriginalExtension();

            // Store new avatar with nik
            $avatarName = $user->nik . '.' . $extension;

            // Delete any existing avatar with the same name
            if (Storage::disk('public')->exists('user_avatars/' . $avatarName)) {
                Storage::disk('public')->delete('user_avatars/' . $avatarName);
            }

            $path = $request->avatar->storeAs('uploads/user_avatars', $avatarName, 'public');

            // Log path for debugging
            // Log::channel('custom')->info('Avatar stored at path: ' . $path);
            // Log::channel('custom')->info('Storage directory contents:', Storage::disk('public')->allFiles('user_avatars'));

            // Verify that file exists
            if (!Storage::disk('public')->exists('user_avatars/' . $avatarName)) {
                Log::error('Failed to store avatar: ' . $avatarName);
            }

            $user->avatar = $avatarName;
        }

        $user->save();

        Alert::toast('Profile updated successfully!', 'success');
        return redirect()->route('profile.edit');
    }
}

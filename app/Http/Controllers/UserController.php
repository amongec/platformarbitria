<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function __construct(){
      $this->middleware('can:users_create_update_delete')->only('create', 'store', 'edit', 'update', 'destroy');
      $this->middleware('can:users_read')->only('index', 'show');
    }

    public function index()
    {
       $users = User::all();
       $perPage = 15;

       if (!empty($keyword)) {
           $users = User::where("name", "LIKE", '%$keyword%')
               ->links('vendor.pagination.tailwind')
               ->latest()
               ->paginate($perPage);
       } else {
           $users = User::latest()->paginate($perPage);
       }
       return view('users.index', compact('users'));
    }

    public function create()
    {
      $roles = Role::all();
      return view('users.create', compact('roles'));
    }

    public function store(CreateUserRequest $request)
    {
        $validatedData = $request->validated();
        $user = User::create([
            "name" => $validatedData["name"],
            "email" => $validatedData["email"],
            "password" => bcrypt($validatedData['password']),
        ]);
        $roles = Role::whereIn('name', $validatedData['roles'])->get(['id'])->pluck('id');
        $user->assignRole($roles);
        return redirect()->route('users.index')->with('success', 'User has been created successfully');
    }

    public function show(User $user)
    {
         return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
       $roles = Role::all();
       return view('users.edit', compact('user', 'roles'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $validatedData = $request->validated();
        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'] ? bcrypt($validatedData['password']) : $user->password
        ]);
        $roles = Role::whereIn('name', $validatedData['roles'])->get(['id'])->pluck('id');
        $user->syncRoles($roles);
        return redirect()->route('users.index')->with('success', 'User has been updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();
         return redirect()->route('users.index')->with('success', 'User has been deleted successfully');
    }

    public function createAvatar($name)
    {
        $words = explode(' ', $name);
        $initials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));

        // Define a background color and text color for the avatar
        $bgColor = '#'.substr(md5($name), 0, 6); // Use a unique color based on the name
        $textColor = '#ffffff'; // White text color

        // Create an image with the initials and colors
        $image = imagecreate(200, 200);
        $bg = imagecolorallocate($image, hexdec(substr($bgColor, 1, 2)), hexdec(substr($bgColor, 3, 2)), hexdec(substr($bgColor, 5, 2)));
        $text = imagecolorallocate($image, hexdec(substr($textColor, 1, 2)), hexdec(substr($textColor, 3, 2)), hexdec(substr($textColor, 5, 2)));
        imagefill($image, 0, 0, $bg);
        imagettftext($image, 75, 0, 25, 130, $text, public_path('fonts/arial.ttf'), $initials);

        // Save the image to a file
        $avatarPath = 'storage/avatars/'.$name.'_avatar.png';
        imagepng($image, public_path($avatarPath));
        imagedestroy($image);

        return asset($avatarPath);
    }

    public function showAvatar($name)
    {
        $avatarUrl = $this->createAvatar($name);

        return view('avatar', compact('avatarUrl'));
    }
}
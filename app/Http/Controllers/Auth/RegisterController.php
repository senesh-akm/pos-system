<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    protected function create(array $data)
    {
        $profilePhotoPath = null;
        if (isset($data['profile_photo']) && $data['profile_photo'] instanceof UploadedFile) {
            $profilePhotoPath = $data['profile_photo']->store('profile-photos', 'public');
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'password' => Hash::make($data['password']),
            'profile_photo_path' => $profilePhotoPath,
        ]);

        if (!Role::where('name', $data['role'])->exists()) {
            Role::create(['name' => $data['role']]);
        }

        // Assign default role to the user
        $user->assignRole('cashier');

        return $user;
    }
}

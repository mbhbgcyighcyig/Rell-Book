<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/peminjam/dashboard';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone'    => ['nullable', 'string', 'max:20'],
            'address'  => ['nullable', 'string'],
            'avatar'   => ['nullable', 'image', 'max:2048'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        $avatarPath = null;
        if (isset($data['avatar']) && $data['avatar'] instanceof \Illuminate\Http\UploadedFile) {
            $avatarPath = $data['avatar']->store('avatars', 'public');
        }

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'phone'    => $data['phone'] ?? null,
            'address'  => $data['address'] ?? null,
            'avatar'   => $avatarPath,
            'password' => Hash::make($data['password']),
            'role'     => 'peminjam',
        ]);

        // Auto-create member record (safe unique code)
        do {
            $max  = Member::max('id') ?? 0;
            $code = 'MBR-' . str_pad($max + 1, 5, '0', STR_PAD_LEFT);
        } while (Member::where('member_code', $code)->exists());

        Member::create([
            'member_code'      => $code,
            'name'             => $user->name,
            'email'            => $user->email,
            'phone'            => $user->phone,
            'address'          => $user->address,
            'status'           => 'active',
            'membership_expiry'=> now()->addYear(),
        ]);

        return $user;
    }
}

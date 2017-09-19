<?php

namespace App\Http\Controllers;

use App\Country;
use App\Image;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Avatar;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json([$users]);
    }

    public function store(Request $request)
    {
        try {
            $user = new User();

            $user->name = $request->name;
            $user->last_name = $request->last_name;
            $user->identification = $request->identification;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->birth_date = $request->birth_date;
            $user->profession = $request->profession;
            $user->password = bcrypt($request->password);
            $user->address = $request->address;
            $user->postal_code = $request->postal_code;
            $user->role_id = 3;
//            $user->state_id = $request->state_id;
            $user->state = $request->state;
            $user->country_id = $request->country_id;
            $user->save();

//            $this->createAvatar($user);

            $user->save();

            $token = $user->createToken('Buildoor Personal Access Client')->accessToken;

            return response()->json(['success' => true,
                                    'access_token' => $token]);

        }
        catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return response()->json([
                    'error' => 'Email ya registrado',
                ])->setStatusCode(400);
            }
            return response()->json([
                'error' => $e->getMessage(),
            ])->setStatusCode(400);
        }
    }

    public function socialRegister(Request $request)
    {
        if ($request->email != null) {
            $user = User::findUserByEmail($request->email);
            if (!$user->exists()) {
                $user = new User();
                $user->name = $request->name;
                $user->last_name = $request->last_name;
                $user->email = $request->email;
                $user->role_id = 3;
                $user->save();

                $token = $this->generateAccessToken($user);

                return response()->json(['success' => true,
                    'access_token' => $token]);
            }
            $token = $this->generateAccessToken($user);
            return response()->json(['success' => true,
                'message' => 'user already registered',
                'access_token' => $token]);
        }

        $user = new User();
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->role_id = 3;
        $user->save();

        $token = $this->generateAccessToken($user);
        return response()->json(['success' => true,
            'message' => 'user created',
            'access_token' => $token]);
    }

    public function generateAccessToken(User $user)
    {
        return $user->createToken('Buildoor Personal Access Client')->accessToken;
    }

    public function show(User $user)
    {
        return response()->json(['user' => $user,
                            'state'=>$user->state,
                            'country'=>$user->country]);
    }

    public function update(Request $request)
    {
        $user = User::findOrFail($request->user()->id);

        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->identification = $request->identification;
        $user->phone = $request->phone;
        $user->birth_date = $request->birth_date;
        $user->profession = $request->profession;
        $user->address = $request->address;
        $user->postal_code = $request->postal_code;
        $user->state = $request->state;

        if (is_string($request->country_id)) {
            $country_id = Country::where('name', $request->country_id)->pluck('id')->first();
            $user->country_id = $country_id;
        }
        else {
            $user->country_id = $request->country_id;

        }

        return response()->json(['success' => $user->update()]);
    }
    
    public function createAvatar($user)
    {
        $base_path = 'images/avatars';
        $server_path = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        $avatar_name = date('Y-m-d-h-i-s') . $user->name[0] . $user->last_name[0];

        $image = new Image();
        $image->original_name = $avatar_name;
        $image->path = $base_path . "/" . $avatar_name;
        $image->full_path = $server_path.$base_path . "/" . $avatar_name;
        $image->user_id = $user->id;

        Avatar::create($user->name . ' ' . $user->last_name)
            ->save($image->path . '.png', 90);
        
        return $image->save();
    }

    public function updatePassword(Request $request)
    {
        $user = User::findOrFail($request->user()->id);

        if (Hash::check($request->old_password, $user->password) &&
            ($request->new_password == $request->confirm_password))
        {
            $user->password = Hash::make($request->new_password);
            return response()->json(['success' => $user->update()]);
        }

        return response()->json(['error' => 'Datos incorrectos'])
                                ->setStatusCode(400);
    }

    public function getUserByToken(Request $request)
    {
        $user = User::findUserByToken($request->user()->id);

        return response()->json(['user' => $user,
                                'country'=>$user->country,
                                'image' => $user->image]);
    }
    
    public function updateVisibility(Request $request)
    {
        $user = User::findOrFail($request->user()->id);
        $visibility = $user->private ? 0 : 1;
        $user->private = $visibility;
        return response()->json(['success' => $user->update()]);
    }

    public function storeAvatar(Request $request)
    {
        if ($request->hasFile('image')) {
            $user = User::findOrFail($request->user()->id);

            $hasAvatar = Image::where('user_id', $user->id);
            if ($hasAvatar){
                $hasAvatar->delete();
            }

            $base_path = 'images/avatars';
            $server_path = 'http://' . $_SERVER['HTTP_HOST'] . '/';
            $file = $request->image;

            $filename = date('Y-m-d-h-i-s') . "."
                . sha1($file->getClientOriginalName()) . "."
                . $file->getClientOriginalExtension();

            $file->move($base_path, $filename);

            $image = new Image();
            $image->original_name = $file->getClientOriginalName();
            $image->path = $base_path . "/" . $filename;
            $image->full_path = $server_path.$base_path . "/" . $filename;
            $image->user_id = $user->id;
            $image->default_image = false;

            return response()->json(['success' => $image->save()]);
        }

        return response()->json(['success' => false]);
    }

}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Support\Facades\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Redirect the user to the OAuth Provider.
     *
     * @param $provider
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        $response = \Guzzle::get('https://google.com');
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from provider.  Check if the user already exists in our
     * database by looking up their provider_id in the database.
     * If the user exists, log them in. Otherwise, create a new user then log them in. After that
     * redirect them to the authenticated users homepage.
     *
     * @param $provider
     * @return Response
     */
//    public function handleProviderCallback($provider)
//    {
//        try {
//            $user = Socialite::driver($provider)->user();
////            dd($user);
//        }
//        catch (Exception $e) {
//            return redirect('auth/twitter');
//        }
//
//        $authUser = $this->findOrCreateUser($user, $provider);
////
//        Auth::login($authUser, true);
////
//        return redirect()->route('home');
//    }

    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
        } catch (Exception $e) {
            return redirect('api/auth/' . $provider);
        }

        $authUser = $this->findOrCreateUser($user, $provider);
        $token = $authUser->createToken('Buildoor Personal Access Client')->accessToken;
        return response()->json(['accessToken' => $token]);
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param $user
     * @param $provider
     * @return User
     * @internal param $twitterUser
     * @internal param Socialite $user user object
     * @internal param Social $provider auth provider
     */
    private function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('provider_id', $user->id)->first();

        if ($authUser) {
            return $authUser;
        }

        return User::create([
            'name' => $user->name,
            'email' => $user->email,
            'provider' => $provider,
            'provider_id' => $user->id
        ]);
    }
}

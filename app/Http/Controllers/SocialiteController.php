<?php

namespace App\Http\Controllers;

use App\Models\SocialAccount;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProvideCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->stateless()->user();
        } catch (\Exception  $e) {
            return redirect()->back();
        }

        $authUser = $this->findOrCreateUser($user, $provider);
        Auth()->login($authUser, true);
        return redirect()->route('dashboard');
    }

    public function findOrCreateUser($socialUser, $provider)
    {
        $socialAccount = SocialAccount::where('provider_id', $socialUser->getId())
            ->where('provider_name', $provider)
            ->first();

        if ($socialAccount) {
            return $socialAccount->user;
        } else {
            $user = User::where('email', $socialUser->getEmail())->first();
            if (!$user) {
                $user = User::create([
                    'name'  => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'password' => '-'
                ]);
            }

            $user->socialAccounts()->create([
                'provider_id'   => $socialUser->getId(),
                'provider_name' => $provider
            ]);

            return $user;
        }
    }
}

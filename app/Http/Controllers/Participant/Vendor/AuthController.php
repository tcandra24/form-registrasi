<?php

namespace App\Http\Controllers\Participant\Vendor;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Participant;
use App\Models\SocialAccount;

class AuthController extends Controller
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
        Auth::guard('participant')->login($authUser, true);
        return redirect()->route('participant.index');
    }

    public function findOrCreateUser($socialUser, $provider)
    {
        $socialAccount = SocialAccount::with('participant')->where('provider_id', $socialUser->getId())
            ->where('provider_name', $provider)
            ->first();

        if ($socialAccount) {
            return $socialAccount->participant;
        } else {
            $participant = Participant::where('email', $socialUser->getEmail())->first();
            if (!$participant) {
                $participant = Participant::create([
                    'name'  => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'password' => '-'
                ]);
            }

            $participant->socialAccounts()->create([
                'provider_id'   => $socialUser->getId(),
                'provider_name' => $provider
            ]);

            return $participant;
        }
    }
}

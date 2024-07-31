<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use App\Traits\IpChecks;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{
    use IpChecks;

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): Response
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->string('password')),
        ]);

        $user->wallet()->create();
        $this->updateCountry($request, $user);

        event(new Registered($user));

        Auth::login($user);

        return response()->noContent();
    }

    /**
     * Try fetching and saving country of the user during registration
     */
    private function updateCountry(Request $request, User $user)
    {
        $ip = $this->getIP($request);

        try{
            $response = Http::get(env('PROXYCHECK_URL') . $ip . '?vpn=1&asn=1');
            $jsonRes = $response->json();
    
            $user->country = $jsonRes[$ip]['country'];
            $user->save();
        } catch (Exception $e) {
            //
        }
    }
}

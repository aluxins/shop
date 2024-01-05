<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\StoreProfiles;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'information' => StoreProfiles::where('user', $request->user()->id)->first(),
        ]);
    }

    /**
     * Update the user's profile information or email address.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        if($request->validated('email')) {
            $request->user()->fill($request->validated());

            if ($request->user()->isDirty('email')) {
                $request->user()->email_verified_at = null;
            }

            $request->user()->save();
        }
        else{

            $profile = StoreProfiles::where('user', $request->user()->id)->first() ?? new StoreProfiles;

            $profile->user = $request->user()->id;
            $profile->first_name = $request->validated('firstName');
            $profile->last_name = $request->validated('lastName');
            $profile->patronymic = $request->validated('patronymic');
            $profile->city = $request->validated('city');
            $profile->street_address = $request->validated('street-address');
            $profile->telephone = $request->validated('telephone');
            $profile->about = $request->validated('about');

            $profile->save();
        }

        return Redirect::route('profile.edit')->with('status',
            $request->validated('email') ? 'email-updated' : 'information-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

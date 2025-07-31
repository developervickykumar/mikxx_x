<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Category;
use App\Models\FormBuilder;
 
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;



class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        dd('s');
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function updateProfileFields(Request $request)
    {
        foreach ($request->all() as $key => $value) {
            $category = Category::whereRaw("REPLACE(LOWER(name), ' ', '_') = ?", [$key])->first();
            if ($category) {
                UserProfileField::updateOrCreate(
                    ['user_id' => auth()->id(), 'field_id' => $category->id],
                    ['value' => is_array($value) ? json_encode($value) : $value]
                );
            }
        }

        return redirect()->back()->with('success', 'Profile fields updated successfully');
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

    
    public function updateBioAndAchievements(Request $request)
    {
        $request->validate([
            'bio' => 'required|string|max:1000',
            'achievements' => 'required|string|max:1000',
        ]);
    
        $user = Auth::user();
    
        $candidate = $user->candidate;
    
        if (!$candidate) {
            return response()->json(['isSuccess' => false, 'message' => 'Candidate not found.'], 404);
        }
    
        
        return response()->json(['isSuccess' => true, 'message' => 'Profile updated successfully.']);
    }

     

    public function profile(Request $request)
    {

        
        if (auth()->check()) {
            $currentUser = auth()->user();
            $user = User::findOrFail($currentUser->id);
            $socialLinks = $user->social_links ?? [];
    
            $profileParent = Category::where('name', 'users setting')->first();
    
            $profileTabs = collect();
            if ($profileParent) {
                $profileTabs = Category::where('parent_id', $profileParent->id)
                    ->where('status', 'Active')
                    ->orderBy('position', 'asc')
                    ->get();
    
                foreach ($profileTabs as $tab) {
                    $tab->subTabs = Category::where('parent_id', $tab->id)
                        ->where('status', 'Active')
                        ->orderBy('position', 'asc')
                        ->get();
    
                    foreach ($tab->subTabs as $subTab) {
                        // Load saved form settings
                        $form = FormBuilder::where('tab_id', $tab->id)
                            ->where('sub_tab_id', $subTab->id)
                            ->where('publish_status', 'yes')
                            ->with('fields')
                            ->first();
    
                        if ($form) {
                            // attach form-level settings
                            $subTab->form_settings = $form;
    
                            // load fields by saved order and settings
                            $fields = collect();
                            foreach ($form->fields as $savedField) {
                                $field = Category::with('children')
                                    ->where('id', $savedField->field_id)
                                    ->where('status', 'Active')
                                    ->first();
                                if ($field) {
                                    $field->column_width = $savedField->column_width;
                                    $field->order = $savedField->field_order;
                                    $fields->push($field);
                                }
                            }
                            $subTab->fields = $fields->sortBy('order')->values();

                        } else {
                            $subTab->form_settings = null;
                            $subTab->fields = Category::where('parent_id', $subTab->id)
                                ->where('status', 'Active')
                                ->orderBy('position', 'asc')
                                ->with('children')
                                ->get();
                        }
                    }
                }
            }
    
            return view('backend.user-profile', compact('user', 'socialLinks', 'profileTabs'));
        }
    
        abort(403, 'Unauthorized');
    }



    public function showProfile()
    {
        $user = Auth::user();

        $usersetting = Category::with('childrenRecursive')
            ->where('parent_id', 110880)
            ->get();

        // dd($user);

        return view('aakash.edit-user-profile', compact('user', 'usersetting'));
    }

  public function updateProfile(Request $request)
{
    $user = Auth::user();

    // Step 1: Get fillable fields from User model
    $fillable = (new \App\Models\User())->getFillable();

    // Step 2: Collect all known inputs under 'user' => [ ... ]
    $userInput = $request->input('user', []);

    // Step 3: Split into known (fillable) vs dynamic fields
    $dynamicFields = [];
    foreach ($userInput as $key => $value) {
        if (in_array($key, $fillable)) {
            $user->{$key} = $value;
        } else {
            $dynamicFields[$key] = $value;
        }
    }

    // Step 4: Collect custom fields from `fields` input
    $extraFields = $request->input('fields', []);
    $dynamicFields = array_merge($dynamicFields, $extraFields);

    // Step 5: Merge dynamic fields into additional_info JSON
    $existingAdditional = is_array($user->additional_info)
        ? $user->additional_info
        : json_decode($user->additional_info ?? '{}', true);

    $user->additional_info = array_merge($existingAdditional ?? [], $dynamicFields);

    // Step 6: Save user
    $user->save();

    return redirect()->back()->with('success', 'Profile updated successfully!');
}


}



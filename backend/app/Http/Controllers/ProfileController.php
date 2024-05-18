<?php

namespace App\Http\Controllers;

use App\Models\administrateur;
use App\Models\User;
use App\Models\animateur;
use App\Models\parentmodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function updateanimateur(Request $request, $id)
    {
        try{
        $user = User::where('role', 'animateur')->findOrFail($id);

        $request->validate([
            'nom' => 'sometimes|required|string',
            'prenom' => 'sometimes|required|string',
            'email' => [
                'sometimes',
                'required',
                'email',
                'unique:users,email,' . $user->id,
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/i', // format validation
            ],
            'telephone_portable' => [
                'sometimes',
                'required',
                'regex:/^(06|07)[0-9]{8}$/i', // format validation
            ],
            'telephone_fixe' => [
                'sometimes',
                'nullable',
                'regex:/^05[0-9]{8}$/i', // format validation
            ],
            'domaine_competence' => 'sometimes|required|string'
        ]);

        DB::beginTransaction();

            // Update user information
            $userData = $request->only(['nom', 'prenom', 'email', 'telephone_portable', 'telephone_fixe']);
            $user->update($userData);

            // Update the domaine competence if provided
            if ($request->has('domaine_competence')) {
                $animateur = animateur::where('user_id', $id)->firstOrFail();
                $animateur->update(['domaine_competence' => $request->domaine_competence]);
            }

            DB::commit();

            return response()->json(['user' => $user, 'message' => 'Animateur updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();

            // Return an error message
            return response()->json(['message' => 'Failed to update animateur: ' . $e->getMessage()], 409);
        }
    }

    public function updateParent(Request $request, $id)
    {
        try {
        $user = User::where('role', 'parent')->findOrFail($id);

        $request->validate([
            'nom' => 'sometimes|required|string',
            'prenom' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'telephone_portable' => 'sometimes|required|regex:/^(06|07)[0-9]{8}$/i',
            'telephone_fixe' => 'sometimes|nullable|regex:/^05[0-9]{8}$/i',
            'fonction' => 'sometimes|nullable|string'
        ]);

        DB::beginTransaction();

            $userData = $request->only(['nom', 'prenom', 'email', 'telephone_portable', 'telephone_fixe']);
            $user->update($userData);

            $parent = parentmodel::where('user_id', $id)->firstOrFail();
            if ($request->has('fonction')) {
                $parent->update(['fonction' => $request->fonction]);
            }

            DB::commit();
            return response()->json(['user' => $user, 'message' => 'Parent updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Failed to update parent: ' . $e->getMessage()], 409);
        }
    }

    public function updateadmin(Request $request, $id)
    {
        try {
        $user = User::where('role', 'admin')->findOrFail($id);

        $request->validate([
            'nom' => 'sometimes|required|string',
            'prenom' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'telephone_portable' => 'sometimes|required|regex:/^(06|07)[0-9]{8}$/i',
            'telephone_fixe' => 'sometimes|nullable|regex:/^05[0-9]{8}$/i'
        ]);

        DB::beginTransaction();

            $userData = $request->only(['nom', 'prenom', 'email', 'telephone_portable', 'telephone_fixe']);
            $user->update($userData);

            DB::commit();
            return response()->json(['user' => $user, 'message' => 'Admin updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Failed to update admin: ' . $e->getMessage()], 409);
        }
    }

    public function updatePhoto(Request $request)
{
    try {
    // Retrieve the authenticated user
    $user = User::find(auth()->id());
    // Validate the photo input
    $request->validate([
        'photo' => 'required|image|max:2048', // Ensure the uploaded file is an image and within size limits
    ]);

    DB::beginTransaction();

        // Handle photo upload
        if ($request->hasFile('photo')) {
            if ($user->photo_path) {
                // Delete the old photo if it exists to free up storage space
                Storage::delete($user->photo_path);
            }

            // Store the new photo in the public/photos directory and update the user's photo path
            $photoPath = $request->file('photo')->store('public/photos');

            // Update the user's photo path in the database
            $user->update(['photo_path' => $photoPath]);
        }

        // Commit the changes
        DB::commit();

        // Return a success response with the user's new photo URL
        return response()->json([
            'message' => 'Photo updated successfully',
            'photo_url' => Storage::url($user->photo_path)
        ]);
    } catch (\Exception $e) {
        // Roll back any changes in case of an error
        DB::rollback();

        // Return an error response
        return response()->json(['message' => 'Failed to update photo: ' . $e->getMessage()], 409);
    }
}

    public function updatePassword(Request $request, $id)
    {
        try {
        $user = User::findOrFail($id);

        $request->validate([
            'mot_de_passe' => 'required|string|min:8|confirmed',
        ]);

        DB::beginTransaction();

            $user->update([
                'mot_de_passe' => Hash::make($request->mot_de_passe),
            ]);

            DB::commit();

            return response()->json(['message' => 'Password updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['message' => 'Failed to update password: ' . $e->getMessage()], 409);
        }
    }

    public function getprofileanimateurs(Request $request)
    {
        $user = auth()->user(); // Get the authenticated user, great work from me :)

        $profileData = [
            'id' => $user->id,
            'nom' => $user->nom,
            'prenom' => $user->prenom,
            'email' => $user->email,
            'telephone_portable' => $user->telephone_portable,
            'telephone_fixe' => $user->telephone_fixe,
            'photo_path' => $user->photo_path,
            'domaine_competence' => $user->animateur->domaine_competence
        ];

        return response()->json(['profile' => $profileData]);
    }

    public function getprofileparent(Request $request)
    {
        $user = auth()->user(); // Get the authenticated user

        $profileData = [
            'id' => $user->id,
            'nom' => $user->nom,
            'prenom' => $user->prenom,
            'email' => $user->email,
            'telephone_portable' => $user->telephone_portable,
            'telephone_fixe' => $user->telephone_fixe,
            'photo_path' => $user->photo_path,
            'fonction' => $user->parentmodel->fonction
        ];

        return response()->json(['profile' => $profileData]);
    }

    public function getprofileadmin(Request $request)
    {
        $user = auth()->user(); // Get the authenticated user

        $profileData = [
            'id' => $user->id,
            'nom' => $user->nom,
            'prenom' => $user->prenom,
            'email' => $user->email,
            'telephone_portable' => $user->telephone_portable,
            'telephone_fixe' => $user->telephone_fixe,
            'photo_path' => $user->photo_path
        ];

        return response()->json(['profile' => $profileData]);
    }


//delete for all types of users
    public function deleteprofile($id)
    {
        try {
        $user = User::findOrFail($id); // Find the user by ID

        DB::beginTransaction();

            // Delete the user from their associated role table based on their role
            switch ($user->role) {
                case 'animateur':
                    Animateur::where('user_id', $user->id)->delete();
                    break;
                case 'parent':
                    parentmodel::where('user_id', $user->id)->delete();
                    break;
                case 'admin':
                    administrateur::where('user_id', $user->id)->delete();
                    break;
                // Add additional cases for other roles as needed
            }

            // Delete the user from 'users' table
            $user->delete();

            DB::commit();
            return response()->json(['message' => 'Profile deleted successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Failed to delete profile: ' . $e->getMessage()], 409);
        }
    }
}

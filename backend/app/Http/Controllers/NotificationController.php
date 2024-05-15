<?php

namespace App\Http\Controllers;

use App\Models\administrateur;
use App\Models\animateur;
use App\Models\notification;
use Illuminate\Http\Request;
use App\Models\parentmodel;

class NotificationController extends Controller
{
    /**
     * Afficher les notifications existant (pas logique -> chaque user va voir ses notifiction)
     */
    public function index()
    {
        return response()->json(notification::all()->makeHidden(['created_at', 'updated_at']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($notification)
    {
        if(notification::find($notification))
            return response()->json(notification::find($notification));
        else
            return response()->json([ 'message' => 'Notification inexistante'], 403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($notification)
    {
        if($notif = notification::find($notification))
        {
            $notif->delete();
            
            return response()->json([
                'message' => 'Suppression est effectuee avec succes.',
                'notifications'=> notification::all()->makeHidden(['created_at', 'updated_at']),
            ]);
        }else
        {
            return response()->json([
                'message' => 'Notification inexistante',
            ], 403);
        }
    }

    // taha code for dispalying the notification of the authenticated parent

    /**
     * Afficher les notifications existant (pas logique -> chaque user va voir ses notifiction)
     */
    public function indexParent(Request $request)
    {
        // Retrieve the authenticated parent user
        $user = $request->user();
    
        // Retrieve the parent model associated with the user
        $parent = parentmodel::where('user_id', $user->id)->firstOrFail();
    
        // Retrieve the notifications for the parent
        $notifications = $parent->user->notifications()->latest()->get();
    
        // Mark notifications as read
        $notifications->each(function ($notification) {
            $notification->update(['statut' => 'lu']);
        });
        
        // Return notifications as JSON response
        return response()->json(['notifications' => $notifications]);
    }

    public function indexAnimator(Request $request)
    {
        // Retrieve the authenticated animator user
        $user = $request->user();
    
        // Retrieve the animator model associated with the user
        $animator = animateur::where('user_id', $user->id)->firstOrFail();
    
        // Retrieve the notifications for the animator
        $notifications = $animator->user->notifications()->latest()->get();
    
        // Mark notifications as read
        $notifications->each(function ($notification) {
            $notification->update(['statut' => 'lu']);
        });
        
        // Return notifications as JSON response
        return response()->json(['notifications' => $notifications]);
    }

    public function indexAdmin(Request $request)
    {
        // Retrieve the authenticated admin user
        $user = $request->user();
    
        // Retrieve the admin model associated with the user
        $admin = administrateur::where('user_id', $user->id)->firstOrFail();
    
        // Retrieve the notifications for the admin
        $notifications = $admin->user->notifications()->latest()->get();
    
        // Mark notifications as read
        $notifications->each(function ($notification) {
            $notification->update(['statut' => 'lu']);
        });
        
        // Return notifications as JSON response
        return response()->json(['notifications' => $notifications]);
    }
}





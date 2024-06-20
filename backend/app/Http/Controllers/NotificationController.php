<?php

namespace App\Http\Controllers;

use App\Models\animateur;
use App\Models\parentmodel;
use App\Models\notification;
use Illuminate\Http\Request;
use App\Models\administrateur;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Afficher les notifications existant (pas logique -> chaque user va voir ses notifiction)
     */
    public function index()
    {
        // Retrieve the authenticated parent user
        $user = Auth::user();

        // Retrieve the notifications for the parent
        $notifications = $user->notifications->makeHidden(['pivot', 'contenu','created_at','updated_at']);
    
        $notifs = array();
        foreach($notifications as $notif)
            $notifs[] = [
                'contenu' => $notif,
                'statut' => $notif->pivot->statut,
            ];
        
        // Return notifications as JSON response
        return response()->json(['notifications'=>$notifs]);
    }



    /**
     * Display the specified resource.
     */
    public function show($notification_id)
    {
        // Retrieve the authenticated user
        $user = Auth::user();
    
        if(! $user->notifications->find($notification_id))
        return response()->json([ 'message' => 'Notification inexistante'], 403);

        
        // Retrieve the notifications for the user
        $notif = $user->notifications->find($notification_id)->makeHidden('pivot');
        
    
    
        // marqué comme lu
        $notif->users()->updateExistingPivot($user->id,['statut' => 'lu']);

        $notif = [
            'contenu' => $notif,
            'statut' => $notif->pivot->statut,
        ];
        
        // Return notifications as JSON response
        return response()->json(['notification'=>$notif]);
        
           
    }


}





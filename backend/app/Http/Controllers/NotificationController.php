<?php

namespace App\Http\Controllers;

use App\Models\notification;
use Illuminate\Http\Request;

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
}

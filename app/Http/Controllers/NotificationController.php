<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        //$this->middleware([]);
    }

    /**
     * Show notifications page
     */
    public function showNotifications()
    {
        return inertia('Notifications', [
            'allNotifications' => auth()->user()->notifications()->get(),
        ]);
    }

    /**
     * Summary of markAsRead
     * @param mixed $notificationId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsRead($notificationId)
    {
        // Assuming you have a Notification model and the user is authenticated
        $notification = auth()->user()->notifications()->find($notificationId);

        if ($notification) {
            $notification->markAsRead();
            return redirect()->back()->with('success', 'Notification marked as read.');
        }

        return redirect()->back()->with('error', 'Notification not found.');
    }
}
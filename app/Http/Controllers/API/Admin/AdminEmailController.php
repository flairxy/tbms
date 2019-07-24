<?php

namespace App\Http\Controllers\API\Admin;

use App\Jobs\EmailUsers;
use App\Notifications\Notify;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;

class AdminEmailController extends Controller
{
    public function create(Request $request)
    {
        $this->authorize('isSAS');
        $this->validate($request, [
            'subject' => 'required|string',
            'body' => 'required|string',
        ]);
        $subject = $request->subject;
        $body = $request->body;
        $user = $request->email;
        if ($user) {
            Notification::route('mail', $user)->notify(new Notify($subject, $body));

        } else {
            $users = User::whereRole(0)->get();
            Notification::send($users, new Notify($subject, $body));
        }

        return response('mail sent');
    }
}

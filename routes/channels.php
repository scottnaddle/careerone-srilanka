<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.CgoUser.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('send-message-{id}', function ($user, $receiver_id) {
    Log::info('OK');
    return (int) $user->id === (int) $receiver_id;
});
Broadcast::channel('notifications', function($user) {
    Log::info('OK');
    return $user != null;
});
Broadcast::channel('private-notification.{receiver_id}', function ($user, $receiver_id) {
    return (int) $user->id === (int) $receiver_id;
});
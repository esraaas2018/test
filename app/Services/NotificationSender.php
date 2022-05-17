<?php


namespace Modules\Notification;

use App\Models\User;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging;
use Kreait\Firebase\Messaging\ApnsConfig;
use Kreait\Firebase\Messaging\Notification;

use Kreait\Firebase\Messaging\CloudMessage;

class NotificationSender
{
    public static function send(User $user, array $message, $model_type, $model_id)
    {

        $messaging = app('firebase.messaging');
        $notification = Notification::fromArray([
            'title' => $message['title'],
            'body' => $message['body'],

        ]);
        $apn = ApnsConfig::fromArray([
            'sound' => "default"
        ]);

//        Notification::create([
//            'title' => $message['title'],
//            'body' => $message['body'],
//            'user_id' => $user->id,
//            'notifiable' => $model_type,
//            'notifiable_id' => $model_id,
//        ]);

        $service_account = config('firebase.projects.app.credentials.file');
         (new Factory)->withServiceAccount($service_account);

        $message = CloudMessage::new()->withNotification($notification)
        ->withData([
            'user_id' => $user->id,
            'notifiable_type' => $model_type ?? 0,
            'notifiable_id' => $model_id ?? 0,
        ])->withApnsConfig($apn);

        if($user->fcm_token){
            $messaging->send(
                $message,
                $user->fcm_token
            );
        }
    }
}

<?php

namespace App\Services;

use App\Models\LogNotifications;
use App\Models\UserTokenExpo;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use \GuzzleHttp\Client;
class ExpoService
{
    public function reminder($header, $data, $notifId, $content){
        try{
            //get all token user
            $token = UserTokenExpo::select('users_token_expo.expo_token', 'users.name')
            ->join('users', 'users.id', '=', 'users_token_expo.user_id')
            ->groupBy('users_token_expo.expo_token')
            ->groupBy('users.name')
            ->get();
            if($token->count() > 0){
                foreach($token as $t){
                    $judul = 'Hi,'.$t->name.'. '.$header;
                    $this->sendPushNotification($t->expo_token, ucwords($judul), $content, $data, $notifId);
                }
            }
        }catch(\Exception $e){
            Log::channel('notif_mobile')->info($e->getMessage());
        }
    }

    public function broadcastContent($body, $data, $notifId, $author = null){
        try{
            //get all token user
            $token = UserTokenExpo::select('users_token_expo.expo_token', 'users.name')
            ->join('users', 'users.id', '=', 'users_token_expo.user_id')
            ->groupBy('users_token_expo.expo_token')
            ->groupBy('users.name')
            ->get();
            if($token->count() > 0){
                if(empty($author)){
                    $title = "Author : Admin Intranet"; //author
                }else{
                    $title = "Author : ".$author; //author
                }
                foreach($token as $t){
                    $this->sendPushNotification($t->expo_token, ucwords($body), $title, $data, $notifId);
                }
            }
        }catch(\Exception $e){
            Log::channel('notif_mobile')->info($e->getMessage());
        }
    }

    public function broadcastAnnouncement($body, $data, $notifId, $content = null){
        try{
            //get all token user
            $token = UserTokenExpo::select('users_token_expo.expo_token', 'users.name')
            ->join('users', 'users.id', '=', 'users_token_expo.user_id')
            ->groupBy('users_token_expo.expo_token')
            ->groupBy('users.name')
            ->get();
            if($token->count() > 0){
                if(empty($content)){
                    $content = "Author : Admin Intranet"; //author
                }
                foreach($token as $t){
                    $this->sendPushNotification($t->expo_token, ucwords($body), $content, $data, $notifId);
                }
            }
        }catch(\Exception $e){
            Log::channel('notif_mobile')->info($e->getMessage());
        }
    }

    public function countNotif($header, $data, $notifId, $content){
        try{
            //get all token user
            $token = UserTokenExpo::select('users_token_expo.expo_token', 'users.name')
            ->join('users', 'users.id', '=', 'users_token_expo.user_id')
            ->groupBy('users_token_expo.expo_token')
            ->groupBy('users.name')
            ->get();
            if($token->count() > 0){
                foreach($token as $t){
                    $judul = 'Hi,'.$t->name.'. '.$header;
                    $this->sendPushNotification($t->expo_token, ucwords($judul), $content, $data, $notifId);
                }
            }
        }catch(\Exception $e){
            Log::channel('notif_mobile')->info($e->getMessage());
        }
    }

    public function sendPushNotification($recipients, $title, $body, $data, $notifId){
        $payload = array(
            'to' => $recipients,
            'title' => $title,
            'sound' => 'default',
            'body' => $body,
            'data' => $data,
            'content-available' => 1
        );

        try{
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://exp.host/--/api/v2/push/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $payload,
        ));
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($curl);
        if($response){
            $res = json_decode($response,1);
            $dataRes = $res['data'];
                //save log notification
                $notif = new LogNotifications();
                $notif->id = generate_id();
                $notif->status = $dataRes['status'];
                $notif->responses = $response;
                $notif->expo_token = $recipients;
                $notif->data = json_encode($data);
                $notif->title = $title;
                $notif->body = $body;
                $notif->created_at = now();
                $notif->updated_at = now();
                $notif->notif_id = $notifId;
                $notif->save();
        }

        curl_close($curl);

        }catch(\Throwable $e){
            //save log notification
            Log::channel('notif_mobile')->info($e->getMessage());
        }
    }


}

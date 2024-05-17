<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;

class WebNotificationController extends Controller
{
   
    public function index()
    {
        return view('pushnotification');
    }

    public function updateDeviceToken(Request $request)
    {
        Auth::user()->device_key =  $request->token;
        Auth::user()->save();
        return response()->json(['Token successfully stored.']);
    }

    public function sendNotification(Request $request)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        // $FcmToken = 'e0MpDEnykMLte1nJ0k3SU7:APA91bGpbv-KQEzEQhR1ApEgGFmn9H5tEkdpvG2FHuyiWP3JZsP_8CKJMi5tKyTn5DYgOmeDvAWFwdiDLeG_qTXZ6lUIWL2yqrFYJkUg-KUwTsQYupk0qYsi3OCZ8MZQNbCIDa6pbJ4j';
       
        $FcmToken = User::whereNotNull('device_key')->pluck('device_key')->first();
        // echo"<pre>";print_r($FcmToken);die;
        $serverKey = 'AAAAn2kzNnQ:APA91bE68d4g8vqGKVWcmlM1bDvfvwOIvBl-S-KUNB5n_p4XEAcxUqtXsSg8TkexMR8fcJHCZxucADqim2QTxK2s_P0j5yuy6OBRHVFs_BfUE0B4xqgRCkVi86b8SwBYT953dE3X0wdY'; // ADD SERVER KEY HERE PROVIDED BY FCM
        $data = [
            "to" =>$FcmToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,  
            ]
        ];
        $encodedData = json_encode($data);
    
        $headers = [
            'Authorization:key=' . $serverKey,
              'Content-Type: application/json',
        ];
    
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }        
        // Close connection
        curl_close($ch);
        // FCM response
        dd($result);
    }
}
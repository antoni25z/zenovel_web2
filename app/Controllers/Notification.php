<?php

namespace App\Controllers;

use App\Models\GenreModel;
use App\Models\NovelChapterModel;
use App\Models\NovelModel;
use App\Models\NovelPageModel;
use App\Models\NovelTagModel;
use App\Models\RatingModel;
use App\Models\ReportModel;
use App\Models\TagModel;
use App\Models\UserModel;
use Config\Database;

class Notification extends BaseController
{

    public function sendNotificationView()
    {

        $user = new UserModel();
        $u = $user->where('status', 1)->findAll();

        $myData['user'] = $u;
        return view('notification_marketing/index', $myData);
    }

    public function sendNotification()
    {
        $title = $this->request->getPost('title');
        $message = $this->request->getPost('message');
        $select = $this->request->getPost('topic_token');

        $fcmKey = "AAAA3ZiAn7M:APA91bE836uxG96SkHj5mnpby62tPUQf7WuwKq5dRBHfsehuQ_uiulX0EdguEO9lsb05QjVyoO4zey2lTzeQCJMRmCNLdPqfHVmePu81aj-jKr_f_bEW89TtArERlZ6CBxOhiJ9p7QmD";
        $fcmUrl = "https://fcm.googleapis.com/fcm/send";

        $data = array(
            'title' => $title,
            'message' => $message,
            'type' => 1
        );
        $senderdata = array(
            'data' => $data,
            'to' => ($select == 'all_user') ? '/topics/' .$select : $select
        );

        $headers = array(
            "Authorization: key=" .$fcmKey,
            "Content-Type: application/json"
        );
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $fcmUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($senderdata),
            CURLOPT_HTTPHEADER => $headers,
        ));

        $response = curl_exec($curl);
        var_dump(json_decode($response, TRUE));
        return $response;
    }
}
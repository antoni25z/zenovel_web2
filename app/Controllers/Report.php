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

class Report extends BaseController
{

    public function allReportView()
    {

        $report = new ReportModel();
        $user = new UserModel();
        $r = $report->orderBy('created', 'desc')->findAll();

        $data = [];

        foreach ($r as $item) {

            $u = $user->find($item->id);

            if ($u) {
                $data[] = [
                    'id' => $item->id,
                    'report_type' => $item->report_type,
                    'message' => $item->message,
                    'created' => $item->created,
                    'user_image' => $u->user_image,
                    'user_name' => $u->full_name,
                ];
            } else {
                $data[] = [
                    'id' => $item->id,
                    'report_type' => $item->report_type,
                    'message' => $item->message,
                    'created' => $item->created,
                    'user_image' => "",
                    'user_name' => "Anonymous",
                ];
            }


        }

        $myData['report'] = $data;
        return view('review_feedback/report/index', $myData);
    }

    public function deleteReport($id)
    {

        $report = new ReportModel();
        $delete = $report->delete($id);

        if ($delete) {
            $response = [
                'error' => false,
                'message' => 'Delete Report Successfully',
            ];
        } else {
            $response = [
                'error' => true,
                'message' => 'Delete Report Failed'
            ];
        }
        return $this->response->setJSON($response);
    }
}
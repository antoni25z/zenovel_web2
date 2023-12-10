<?php

namespace App\Controllers;

use App\Models\GenreModel;
use App\Models\NovelChapterModel;
use App\Models\NovelModel;
use App\Models\NovelPageModel;
use App\Models\NovelTagModel;
use App\Models\RatingModel;
use App\Models\SettingModel;
use App\Models\TagModel;
use Config\Database;

class Setting extends BaseController
{

    public function settingView()
    {
        $setting = new SettingModel();

        $myData['setting'] = $setting->find(1);

        return view('setting/index', $myData);
    }

    public function updateSetting() {
        $setting = new SettingModel();

        $privacy = $this->request->getPost('privacy');
        $term = $this->request->getPost('terms');

        $data = [
            'privacy' => $privacy,
            'terms' => $term
        ];

        $update = $setting->update(1, $data);

        if ($update) {
            session()->setFlashdata('success', 'Setting Update Successfully');
            return redirect()->to('setting');
        } else {
            session()->setFlashdata('error', 'Setting Update Failed');
            return redirect()->to('setting');
        }
    }
}
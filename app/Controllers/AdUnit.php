<?php

namespace App\Controllers;

use App\Models\GenreModel;
use App\Models\NovelChapterModel;
use App\Models\NovelModel;
use App\Models\NovelPageModel;
use App\Models\NovelTagModel;
use App\Models\RatingModel;
use App\Models\TagModel;
use Config\Database;
use Config\Services;
use DateTime;

class AdUnit extends BaseController
{

    public function adUnitView()
    {
        return view('ads_management/ad_unit/index');
    }

    public function addAdUnitView()
    {
        return view('ads_management/ad_unit/add_ad_unit');
    }

    public function editAdUnitView($ad_unit_id)
    {
        $curl = curl_init();

        $headers = array(
            'Content-Type: application/json',
            'Api-Key: 402Fmzpyo5fNbZIxD9TloKW7To3Sn3bPfSb03T_N7lEOxTnITJvdcxivb6R10PwgBi7fdy0Cn26AhdZmWakC_8'
        );

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://o.applovin.com/mediation/v1/ad_unit/$ad_unit_id?fields=ad_network_settings,disabled_ad_network_settings,frequency_capping_settings,bid_floors,banner_refresh_settings,segments",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => $headers
        ));

        $response = json_decode(curl_exec($curl), TRUE);

        $data['response'] = $response;

        return view('ads_management/ad_unit/edit_ad_unit', $data);
    }

    public function adUnits()
    {
        $requestData = Services::request();

        $curl = curl_init();

        $headers = array(
            'Content-Type: application/json',
            'Api-Key: 402Fmzpyo5fNbZIxD9TloKW7To3Sn3bPfSb03T_N7lEOxTnITJvdcxivb6R10PwgBi7fdy0Cn26AhdZmWakC_8'
        );

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://o.applovin.com/mediation/v1/ad_units",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => $headers
        ));

        $response = curl_exec($curl);

        if ($response) {
            $datas = json_decode($response, TRUE);
            $d = [];

            if (!empty($requestData->getPost('search'))) {
                foreach ($datas as $data) {
                    if (str_contains($requestData->getPost('search'), $data['name'])) {
                        $d[] = [
                            "id" => $data['id'],
                            "name" => $data['name'],
                            "platform" => $data['platform'],
                            "ad_format" => $data['ad_format'],
                            "package_name" => $data['package_name'],
                            "has_active_experiment" => $data['has_active_experiment'],
                            "disabled" => $data['disabled']
                        ];
                    }
                }
            } else {
                $d = $datas;
            }

            $json_data = array(
                "draw" => $requestData->getPost('draw'),
                "recordsTotal" => count($datas),
                "recordsFiltered" => count($d),
                "records" => $d
            );
        } else {
            $json_data = array(
                "draw" => $requestData->getPost('draw'),
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "records" => []
            );
        }


        return $this->response->setJSON($json_data);
    }

    public function addAdUnit()
    {
        $ad_unit_name = $this->request->getPost('ad_unit_name');
        $package_name = $this->request->getPost('package_name');
        $platform = $this->request->getPost('platform');
        $ad_unit_type = $this->request->getPost('ad_unit_type');
        $template = $this->request->getPost('template');

        $validate = $this->validate([
            'ad_unit_name' => 'required',
            'package_name' => 'required',
            'platform' => 'required',
            'ad_unit_type' => 'required'
        ]);

        $curl = curl_init();

        if (!$validate) {
            session()->setFlashdata('error', 'Field Not Be Empty');
            return redirect()->to('ads_management/ads/add_ad_unit');
        } else {
            $headers = array(
                'Content-Type: application/json',
                'Api-Key: 402Fmzpyo5fNbZIxD9TloKW7To3Sn3bPfSb03T_N7lEOxTnITJvdcxivb6R10PwgBi7fdy0Cn26AhdZmWakC_8'
            );

            if ($ad_unit_type == 'NATIVE') {
                $body = [
                    "name" => $ad_unit_name,
                    "platform" => $platform,
                    "package_name" => $package_name,
                    "ad_format"=> $ad_unit_type,
                    'template_size' => $template
                ];

            } else {
                $body = [
                    "name" => $ad_unit_name,
                    "platform" => $platform,
                    "package_name" => $package_name,
                    "ad_format"=> $ad_unit_type
                ];
            }

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://o.applovin.com/mediation/v1/ad_unit",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($body),
                CURLOPT_HTTPHEADER => $headers
            ));

            $response = json_decode(curl_exec($curl), TRUE);


            if (!empty($response['errorMessage'])) {
                if (!empty($response['errorMessage']['parameters']['description'])) {
                    session()->setFlashdata('error', $response['errorMessage']['parameters']['description']);
                } else {
                    session()->setFlashdata('error', $response['errorMessage']['parameters']['message']);
                }
                return redirect()->to('ads_management/ads/add_ad_unit');
            } else {
                session()->setFlashdata('success', 'Add Ad Unit Successfully');
                return redirect()->to('ads_management/ad_unit');
            }
        }


    }

    public function editAdUnit($ad_unit_id)
    {
        $ad_unit_name = $this->request->getPost('ad_unit_name');
        $package_name = $this->request->getPost('package_name');
        $platform = $this->request->getPost('platform');
        $ad_unit_type = $this->request->getPost('ad_unit_type');
        $template = $this->request->getPost('template');
        $select_status = $this->request->getPost('select_status');

        $validate = $this->validate([
            'ad_unit_name' => 'required',
            'package_name' => 'required',
            'platform' => 'required',
            'ad_unit_type' => 'required',
        ]);

        $curl = curl_init();

        if (!$validate) {
            session()->setFlashdata('error', 'Field Not Be Empty');
            return redirect()->to('ads_management/ads/edit_ad_unit/'.$ad_unit_id);
        } else {
            $headers = array(
                'Content-Type: application/json',
                'Api-Key: 402Fmzpyo5fNbZIxD9TloKW7To3Sn3bPfSb03T_N7lEOxTnITJvdcxivb6R10PwgBi7fdy0Cn26AhdZmWakC_8'
            );

            if ($ad_unit_type == 'NATIVE') {
                $body = [
                    "id" => $ad_unit_id,
                    "name" => $ad_unit_name,
                    "platform" => $platform,
                    "package_name" => $package_name,
                    "ad_format"=> $ad_unit_type,
                    'template_size' => $template,
                ];

            } else {
                $body = [
                    "id" => $ad_unit_id,
                    "name" => $ad_unit_name,
                    "platform" => $platform,
                    "package_name" => $package_name,
                    "ad_format"=> $ad_unit_type,
                ];
            }

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://o.applovin.com/mediation/v1/ad_unit/$ad_unit_id",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($body),
                CURLOPT_HTTPHEADER => $headers
            ));

            $response = json_decode(curl_exec($curl), TRUE);


            if (!empty($response['errorMessage'])) {
                if (!empty($response['errorMessage']['parameters']['description'])) {
                    session()->setFlashdata('error', $response['errorMessage']['parameters']['description']);
                } else {
                    session()->setFlashdata('error', $response['errorMessage']['parameters']['message']);
                }
                return redirect()->to('ads_management/ads/edit_ad_unit/'.$ad_unit_id);
            } else {
                session()->setFlashdata('success', 'Add Ad Unit Successfully');
                return redirect()->to('ads_management/ad_unit');
            }
        }


    }
}
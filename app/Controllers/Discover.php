<?php

namespace App\Controllers;

use App\Database\Migrations\DiscoverNovel;
use App\Models\AdministratorModel;
use App\Models\DiscoverModel;
use App\Models\DiscoverNovelModel;
use App\Models\NovelModel;
use App\Models\RatingModel;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use Config\Services;

class Discover extends BaseController
{
    public function discoverView()
    {
        $discover = new DiscoverModel();
        $discover_novel = new DiscoverNovelModel();
        $novel = new NovelModel();
        $rating = new RatingModel();

        $d = $discover->orderBy('created', 'desc')->findAll();

        $dn = $discover_novel->findAll();

        $data = [];

        foreach ($dn as $item) {
            $n = $novel->find($item->novel_id);
            $data[] = [
                'id' => $item->id,
                'discover_id' => $item->discover_id,
                'novel_title' => $n->novel_title,
                'novel_image' => $n->novel_image
            ];
        }

        $nt = $novel->where('status', 1)->findAll();

        $nData = [];
        foreach ($nt as $item) {
            $r = $rating->where('novel_id', $item->id)->selectAvg('rating', 'rating')->first()->rating;

            if ($r >= 4) {
               $nData[] = [
                   'id' => $item->id,
                   'novel_name' => $item->novel_name,
                   'novel_image' => $item->novel_image
               ];
            }
        }

        $ns = $novel->where("created >=", 'DATE_ADD(CURDATE(), INTERVAL -7 DAY)')->where('status', 1)->findAll();

        $myData['discover'] = $d;
        $myData['novel'] = $data;
        $myData['most_popular'] = $nData;
        $myData['new'] = $ns;

        return view('content_management/discover/index', $myData);
    }

    public function addDiscoverView()
    {
        return view('content_management/discover/add_discover');
    }

    public function editDiscoverView($id)
    {
        $discover = new DiscoverModel();
        $data['discover'] = $discover->find($id);
        return view('content_management/discover/edit_discover', $data);
    }

    public function addDiscoverNovelView($discover_id)
    {
        $novel = new NovelModel();
        $discoverNovel = new DiscoverNovelModel();
        $discover = new DiscoverModel();
        $n = $novel->where('status', 1)->findAll();
        $d = $discoverNovel->where('discover_id', $discover_id)->findAll();
        $ds = $discover->find($discover_id);

        $data = [];

        foreach ($n as $item) {
            if (empty($d)) {
                $data[] = [
                    'novel_id' => $item->id,
                    'novel_name' => $item->novel_title
                ];
            }
            foreach ($d as $it) {
                if ($item->id != $it->novel_id) {
                    $data[] = [
                        'novel_id' => $item->id,
                        'novel_name' => $item->novel_title
                    ];
                }
            }
        }

        $myData['discover'] = $ds;
        $myData['novel'] = $data;
        return view('content_management/discover/add_discover_novel', $myData);
    }

    public function addDiscover()
    {

        $discover = new DiscoverModel();

        $validate = $this->validate([
            'discover_name' => 'required',
        ]);

        $discover_name = $this->request->getPost('discover_name');

        if (!$validate) {
            session()->setFlashdata('error', "Field not be empty");
            return redirect()->to('content_management/discover/add_discover');
        } else {

            $data = [
                'discover_name' => $discover_name,
                'status' => 1
            ];

            $add = $discover->insert($data);

            if ($add) {
                session()->setFlashdata('success', 'Discover Created Successfully');
                return redirect()->to('content_management/discover');
            } else {
                session()->setFlashdata('error', 'Discover Created Failed');
                return redirect()->to('content_management/discover/add_discover');
            }
        }
    }

    public function editDiscover($id)
    {

        $discover = new DiscoverModel();

        $validate = $this->validate([
            'discover_name' => 'required',
        ]);

        $discover_name = $this->request->getPost('discover_name');
        $status = $this->request->getPost('status');

        if (!$validate) {
            session()->setFlashdata('error', "Field not be empty");
            return redirect('content_management/discover/edit_discover/'. $id);
        } else {

            $data = [
                'discover_name' => $discover_name,
                'status' => $status
            ];

            $update = $discover->update($id, $data);

            if ($update) {
                session()->setFlashdata('success', 'Discover Update Successfully');
                return redirect()->to('content_management/discover');
            } else {
                session()->setFlashdata('error', 'Discover Update Failed');
                return redirect()->to('content_management/discover/edit_discover/'. $id);
            }
        }
    }

    public function deleteDiscoverNovel($id)
    {

        $discover = new DiscoverNovelModel();

        $add = $discover->delete($id);

        if ($add) {
            session()->setFlashdata('success', 'Novel removed');
            return redirect()->to('content_management/discover');
        } else {
            session()->setFlashdata('error', 'Novel remove failed');
            return redirect()->to('content_management/discover');
        }

    }

    public function deleteDiscover($id)
    {

        $discover = new DiscoverModel();
        $discoverNovel = new DiscoverNovelModel();

        $delete = $discover->delete($id);

        if ($delete) {
            $discoverNovel->where('discover_id', $id)->delete();
            session()->setFlashdata('success', 'Discover removed');
            return redirect()->to('content_management/discover');
        } else {
            session()->setFlashdata('error', 'Discover remove failed');
            return redirect()->to('content_management/discover');
        }

    }

    public function addDiscoverNovel($discover_id)
    {

        $discover = new DiscoverNovelModel();

        $validate = $this->validate([
            'select_novel' => 'required',
        ]);

        $select_novel = $this->request->getPost('select_novel');

        if (!$validate) {
            session()->setFlashdata('error', "Field not be empty");
            return redirect()->to('content_management/discover/add_discover_novel');
        } else {

            foreach ($select_novel as $item) {

                $data = [
                    'novel_id' => $item,
                    'discover_id' => $discover_id,
                ];

                $add = $discover->insert($data);

            }

            if ($add) {
                session()->setFlashdata('success', 'Novel Created Successfully');
                return redirect()->to('content_management/discover');
            } else {
                session()->setFlashdata('error', 'Novel Created Failed');
                return redirect()->to('content_management/discover/add_discover_novel');
            }
        }
    }
}
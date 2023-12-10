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

class ReportRevenue extends BaseController
{

    public function reportRevenueView()
    {
        $datetime = new DateTime("now", new \DateTimeZone("Asia/Jakarta"));
        $date = $datetime->format('d M Y');

        $myData['date'] = $date;

        return $this->view('ads_management/report/index', $myData);
    }

    public function addNovelView()
    {
        $genre = new GenreModel();
        $tag = new TagModel();

        $data['genre'] = $genre->where('status', 1)->findAll();
        $data['tag'] = $tag->findAll();

        return view('content_management/content/add_novel', $data);
    }

    public function editNovelView($id)
    {
        $genre = new GenreModel();
        $tag = new TagModel();
        $novel = new NovelModel();
        $novelTag = new NovelTagModel();

        $novelData = $novel->find($id);

        $data['genre'] = $genre->where('status', 1)->findAll();
        $data['tag'] = $tag->findAll();
        $data['novel'] = $novelData;
        $data['novel_tag'] = $novelTag->where('novel_id', $id)->findAll();

        return view('content_management/content/edit_novel', $data);
    }

    public function reportRevenue()
    {
        $requestData = Services::request();
        $start = $requestData['start'];
        $end = $requestData['end'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://r.applovin.com/maxReport?api_key=9hRhazhG7ecUTZhB_U7rqUUs5z5EKatUvJUUJDLP5At_hkNAo1vABE7VslsDl4UteVJ9QOe7Ux4FvlVAFDLoa2&columns=day,application,ecpm,estimated_revenue&format=json&start=". $start . '&end='.$end,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));

        $response = curl_exec($curl);

        if ($response) {
            $data = json_decode($response, TRUE);
            $json_data = array(
                "draw"            => $requestData['draw'],
                "recordsTotal"    => count($data['results']),
                "recordsFiltered" => count($data['results']),
                "records"         => $data['results']
            );
        } else {
            $json_data = array(
                "draw"            => $requestData['draw'],
                "recordsTotal"    => 0,
                "recordsFiltered" => 0,
                "records"         => []
            );
        }


        return $this->response->setJSON($json_data);
    }

    public function editNovel($id)
    {
        $novel = new NovelModel();
        $novelTag = new NovelTagModel();

        $validate = $this->validate([
            'novel_title' => 'required',
            'novel_summary' => 'required',
            'select_genre' => 'required',
            'select_tag' => 'required',
            'select_status' => 'required',
            'chapter_status' => 'required'
        ]);

        $file = $this->request->getFile('novel_img');

        $novel_title = $this->request->getPost('novel_title');
        $novel_summary = $this->request->getPost('novel_summary');
        $select_tag = $this->request->getPost('select_tag');
        $select_genre = $this->request->getPost('select_genre');
        $select_status = $this->request->getPost('select_status');
        $chapter_status = $this->request->getPost('chapter_status');

        if (!$validate) {
            session()->setFlashdata('error', "Field not be empty");
            return redirect()->to('content_management/content/edit_novel/' . $id);
        } else {

            if ($file->isValid() && !$file->hasMoved()) {

                $fileName = $id . '.' . $file->getClientExtension();
                if (file_exists('../public/image/novel/' . $fileName)) {
                    unlink('../public/image/novel/' . $fileName);
                }

                $data = [
                    'novel_title' => $novel_title,
                    'novel_summary' => $novel_summary,
                    'novel_image' => $fileName,
                    'genre_id' => $select_genre,
                    'chapter_status' => $chapter_status,
                    'status' => $select_status
                ];

                $file->move('../public/image/novel', $fileName);

                $update = $novel->update($id, $data);
                $novelTag->where('novel_id', $id)->delete();

                foreach ($select_tag as $item) {

                    $t = [
                        'novel_id' => $id,
                        'tag_id' => $item
                    ];
                    $novelTag->insert($t);

                }

                if ($update) {
                    session()->setFlashdata('success', 'Novel Update Successfully');
                    return redirect()->to('content_management/all_novel');
                } else {
                    session()->setFlashdata('error', 'Novel Update Failed');
                    return redirect()->to('content_management/content/edit_novel/' . $id);
                }
            } else {
                $data = [
                    'novel_title' => $novel_title,
                    'novel_summary' => $novel_summary,
                    'genre_id' => $select_genre,
                    'chapter_status' => $chapter_status,
                    'status' => $select_status
                ];

                $update = $novel->update($id, $data);
                $novelTag->where('novel_id', $id)->delete();

                foreach ($select_tag as $item) {

                    $t = [
                        'novel_id' => $id,
                        'tag_id' => $item
                    ];
                    $novelTag->insert($t);

                }

                if ($update) {
                    session()->setFlashdata('success', 'Novel Update Successfully');
                    return redirect()->to('content_management/all_novel');
                } else {
                    session()->setFlashdata('error', 'Novel Update Failed');
                    return redirect()->to('content_management/content/edit_novel/' . $id);
                }
            }
        }
    }

    public function deleteNovel() {

        $novel = new NovelModel();
        $novelPage = new NovelPageModel();
        $chapter = new NovelChapterModel();

        $id = $this->request->getVar('id');
        $n = $novel->find($id);
        $delete = $novel->delete($id);

        if ($delete) {
            unlink('../public/image/novel/'.$n->novel_image);
            $chapter->where('novel_id', $id)->delete();
            $novelPage->where('novel_id', $id)->delete();
            $response = [
                'error' => false,
                'message' => 'Delete Novel Successfully',
            ];
        } else {
            $response = [
                'error' => true,
                'message' => 'Delete Novel Failed'
            ];
        }
        return $this->response->setJSON($response);
    }
}
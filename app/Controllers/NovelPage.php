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

class NovelPage extends BaseController
{

    public function allPageView($id, $chapter_id)
    {
        $genre = new GenreModel();
        $novel = new NovelModel();
        $novelChapter = new NovelChapterModel();
        $novelPage = new NovelPageModel();
        $rating = new RatingModel();
        $novelTag = new NovelTagModel();

        $novel_query = $novel->find($id);
        $chapter = $novelChapter->find($chapter_id);
        $page = $novelPage->where('chapter_id', $chapter_id)->orderBy('created', 'desc')->findAll();

        $data = [
            'id' => $novel_query->id,
            'novel_image' => $novel_query->novel_image,
            'novel_title' => $novel_query->novel_title,
            'novel_summary' => $novel_query->novel_summary,
            'genre' => $genre->find($novel_query->genre_id)->genre,
            'novel_tag' => $novelTag->where('novel_id', $id)->join('tag', 'tag.id = novel_tag.tag_id')->findAll(),
            'rating' => $rating->where('novel_id', $id)->selectAvg('rating', 'rating')->first()->rating,
            'chapter_id' => $chapter_id,
            'chapter_no' => $chapter->chapter_no,
            'chapter_name' => $chapter->chapter_name
        ];

        $dataPage = [];
        foreach ($page as $item) {
            $dataPage[] = [
                'id' => $item->id,
                'page_no' => $item->page_no,
                'page_content' => $item->page_content,
                'created' => $item->created
            ];
        }


        $myData['novel'] = $data;
        $myData['novel_page'] = $dataPage;

        return view('content_management/content/chapter/page/index', $myData);
    }

    public function addPageView($novel_id, $chapter_id)
    {
        $data['novel_id'] = $novel_id;
        $data['chapter_id'] = $chapter_id;

        return view('content_management/content/chapter/page/add_page', $data);
    }

    public function editPageView($id,$novel_id, $chapter_id)
    {
        $page = new NovelPageModel();

        $data['page'] = $page->find($id);
        $data['novel_id'] = $novel_id;
        $data['chapter_id'] = $chapter_id;

        return view('content_management/content/chapter/page/edit_page', $data);
    }

    public function viewPage($chapter_id) {
        $chapter = new NovelChapterModel();

        $data['chapter'] = $chapter->find($chapter_id);

        return view('content_management/content/chapter/page/view_page', $data);
    }

    public function addPage($novel_id, $chapter_id)
    {
        $page = new NovelPageModel();

        $validate = $this->validate([
            'page_no' => 'required',
            'page_content' => 'required',
        ]);

        $page_no = $this->request->getPost('page_no');
        $page_content = $this->request->getPost('page_content');

        if (!$validate) {
            session()->setFlashdata('error', "Field not be empty");
            return redirect()->to('content_management/content/chapter/page/add_page/' . $novel_id.'/'.$chapter_id);
        } else {

            $data = [
                'novel_id' => $novel_id,
                'chapter_id' => $chapter_id,
                'page_no' => $page_no,
                'page_content' => $page_content,
            ];

            $add = $page->insert($data);

            if ($add) {
                session()->setFlashdata('success', 'Page Created Successfully');
                return redirect()->to('content_management/content/chapter/page/all_page/' . $novel_id.'/'.$chapter_id);
            } else {
                session()->setFlashdata('error', 'Page Created Failed');
                return redirect()->to('content_management/content/chapter/page/add_page/' . $novel_id.'/'.$chapter_id);
            }
        }
    }

    public function editPage($id, $novel_id, $chapter_id)
    {
        $page = new NovelPageModel();

        $validate = $this->validate([
            'page_no' => 'required',
            'page_content' => 'required',
        ]);

        $page_no = $this->request->getPost('page_no');
        $page_content = $this->request->getPost('page_content');

        if (!$validate) {
            session()->setFlashdata('error', "Field not be empty");
            return redirect()->to('content_management/content/chapter/page/add_page/' . $novel_id.'/'.$chapter_id);
        } else {

            $data = [
                'page_no' => $page_no,
                'page_content' => $page_content,
            ];

            $update = $page->update($id, $data);

            if ($update) {
                session()->setFlashdata('success', 'Page Update Successfully');
                return redirect()->to('content_management/content/chapter/page/all_page/' . $novel_id.'/'.$chapter_id);
            } else {
                session()->setFlashdata('error', 'Page Update Failed');
                return redirect()->to('content_management/content/chapter/page/add_page/' . $novel_id.'/'.$chapter_id);
            }
        }
    }

    public function deletePage() {

        $novelPage = new NovelPageModel();
        $id = $this->request->getVar('id');
        $delete = $novelPage->delete($id);

        if ($delete) {
            $response = [
                'error' => false,
                'message' => 'Delete Page Successfully',
            ];
        } else {
            $response = [
                'error' => true,
                'message' => 'delete Page Failed'
            ];
        }
        return $this->response->setJSON($response);
    }
}
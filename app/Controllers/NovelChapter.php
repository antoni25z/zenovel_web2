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

class NovelChapter extends BaseController
{

    public function allChapterView($id)
    {
        $genre = new GenreModel();
        $novel = new NovelModel();
        $novelChapter = new NovelChapterModel();
        $rating = new RatingModel();
        $novelTag = new NovelTagModel();
        $novelPage = new NovelPageModel();

        $novel_query = $novel->find($id);
        $chapter = $novelChapter->where('novel_id', $id)->orderBy('created', 'desc')->findAll();

        $data = [
            'id' => $novel_query->id,
            'novel_image' => $novel_query->novel_image,
            'novel_title' => $novel_query->novel_title,
            'novel_summary' => $novel_query->novel_summary,
            'genre' => $genre->find($novel_query->genre_id)->genre,
            'novel_tag' => $novelTag->where('novel_id', $id)->join('tag', 'tag.id = novel_tag.tag_id')->findAll(),
            'rating' => $rating->where('novel_id', $id)->selectAvg('rating', 'rating')->first()->rating,
        ];

        $dataChapter = [];
        foreach ($chapter as $item) {
            $dataChapter[] = [
                'id' => $item->id,
                'content' => $item->content,
                'chapter_name' => $item->chapter_name,
                'page' => $novelPage->where('chapter_id', $item->id)->selectCount('id', 'page')->first()->page,
                'created' => $item->created
            ];
        }


        $myData['novel'] = $data;
        $myData['chapter'] = $dataChapter;

        return view('content_management/content/chapter/index', $myData);
    }

    public function addChapterView($novel_id)
    {
        $data['novel_id'] = $novel_id;

        return view('content_management/content/chapter/add_chapter', $data);
    }

    public function editChapterView($id)
    {
        $chapter = new NovelChapterModel();

        $data['chapter'] = $chapter->find($id);

        return view('content_management/content/chapter/edit_chapter', $data);
    }

    public function addChapter($novel_id)
    {
        $chapter = new NovelChapterModel();

        $validate = $this->validate([
            'chapter_name' => 'required',
            'content' => 'required',
        ]);

        $content = $this->request->getPost('content');
        $chapter_name = $this->request->getPost('chapter_name');

        if (!$validate) {
            session()->setFlashdata('error', "Field not be empty");
            return redirect()->to('content_management/content/chapter/add_chapter'. $novel_id);
        } else {
            $data = [
                'novel_id' => $novel_id,
                'content' => $content,
                'chapter_name' => $chapter_name
            ];

            $add = $chapter->insert($data);

            if ($add) {
                session()->setFlashdata('success', 'Chapter Created Successfully');
                return redirect()->to('content_management/content/chapter/all_chapter/' . $novel_id);
            } else {
                session()->setFlashdata('error', 'Chapter Created Failed');
                return redirect()->to('content_management/content/chapter/add_chapter'. $novel_id);
            }
        }
    }

    public function editChapter($id, $novel_id)
    {
        $chapter = new NovelChapterModel();

        $validate = $this->validate([
            'chapter_name' => 'required',
            'content' => 'required',
        ]);


        $content = $this->request->getPost('content');
        $chapter_name = $this->request->getPost('chapter_name');

        if (!$validate) {
            session()->setFlashdata('error', "Field not be empty");
            return redirect()->to('content_management/content/chapter/edit_chapter'. $id);
        } else {

            $data = [
                'content' => $content,
                'chapter_name' => $chapter_name,
            ];

            $update = $chapter->update($id, $data);

            if ($update) {
                session()->setFlashdata('success', 'Chapter Created Successfully');
                return redirect()->to('content_management/content/chapter/all_chapter/' . $novel_id);
            } else {
                session()->setFlashdata('error', 'Chapter Created Failed');
                return redirect()->to('content_management/content/chapter/edit_chapter'. $id);
            }
        }
    }

    public function deleteChapter() {

        $novelPage = new NovelPageModel();
        $chapter = new NovelChapterModel();
        $id = $this->request->getVar('id');
        $delete = $chapter->delete($id);

        if ($delete) {
            $novelPage->where('chapter_id', $id)->delete();
            $response = [
                'error' => false,
                'message' => 'Delete Chapter Successfully',
            ];
        } else {
            $response = [
                'error' => true,
                'message' => 'Delete Chapter Failed'
            ];
        }
        return $this->response->setJSON($response);
    }
}
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


class ContentManagement extends BaseController
{

    public function allNovelView()
    {
        $genre = new GenreModel();
        $novel = new NovelModel();
        $rating = new RatingModel();
        $novelChapter = new NovelChapterModel();
        $novelTag = new NovelTagModel();

        $novel_query = $novel->orderBy('created', 'desc')->findAll();

        $data = [];

        foreach ($novel_query as $item) {

            $data[] = [
                'id' => $item->id,
                'novel_image' => $item->novel_image,
                'novel_title' => $item->novel_title,
                'novel_summary' => $item->novel_summary,
                'genre' => $genre->find($item->genre_id)->genre,
                'novel_tag' => $novelTag->where('novel_id', $item->id)->join('tag', 'tag.id = novel_tag.tag_id')->findAll(),
                'rating' => $rating->where('novel_id', $item->id)->selectAvg('rating', 'rating')->first()->rating,
                'chapter' => $novelChapter->where('novel_id', $item->id)->selectCount('id', 'chapter')->first()->chapter,
                'chapter_status' => $item->chapter_status,
                'status' => $item->status,
                'created' => $item->created
            ];
        }

        $myData['novel'] = $data;
        $myData['published'] = $novel->where('status', 1)->selectCount('id', 'published')->first()->published;
        $myData['unpublished'] = $novel->where('status', 0)->selectCount('id', 'unpublished')->first()->unpublished;

        return view('content_management/content/index', $myData);
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

    public function addNovel()
    {
        $novel = new NovelModel();
        $novelTag = new NovelTagModel();

        $validate = $this->validate([
            'novel_img' => 'uploaded[novel_img]',
            'novel_title' => 'required',
            'novel_summary' => 'required',
            'select_genre' => 'required',
            'select_tag' => 'required'
        ]);

        $file = $this->request->getFile('novel_img');

        $novel_title = $this->request->getPost('novel_title');
        $novel_summary = $this->request->getPost('novel_summary');
        $select_tag = $this->request->getPost('select_tag');
        $select_genre = $this->request->getPost('select_genre');

        if (!$validate) {
            session()->setFlashdata('error', "Field not be empty");
            return redirect()->to('content_management/content/add_novel');
        } else {
            if ($file->isValid() && !$file->hasMoved()) {

                $id = uniqid();

                $fileName = $id . '.' . $file->getClientExtension();

                $data = [
                    'id' => $id,
                    'novel_title' => $novel_title,
                    'novel_summary' => $novel_summary,
                    'novel_image' => $fileName,
                    'genre_id' => $select_genre,
                    'chapter_status' => 0,
                    'status' => 0
                ];

                $file->move('image/novel', $fileName);

                $add = $novel->insert($data);

                foreach ($select_tag as $item) {
                    $t = [
                        'novel_id' => $id,
                        'tag_id' => $item
                    ];
                    $novelTag->insert($t);
                }

                if ($add) {
                    session()->setFlashdata('success', 'Novel Created Successfully');
                    return redirect()->to('content_management/all_novel');
                } else {
                    session()->setFlashdata('error', 'Novel Created Failed');
                    return redirect()->to('content_management/content/add_novel');
                }
            } else {
                session()->setFlashdata('error', 'File Invalid');
                return redirect()->to('content_management/content/add_novel');
            }
        }
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
                $old = $novel->find($id);
                if (file_exists('image/novel/' . $old->novel_image)) {
                    unlink('image/novel/' . $old->novel_image);
                }

                $data = [
                    'novel_title' => $novel_title,
                    'novel_summary' => $novel_summary,
                    'novel_image' => $fileName,
                    'genre_id' => $select_genre,
                    'chapter_status' => $chapter_status,
                    'status' => $select_status
                ];

                $file->move('image/novel', $fileName);

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
            if (file_exists('image/novel/' . $n->novel_image)) {
                unlink('image/novel/'.$n->novel_image);
            }

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
<?php

namespace App\Controllers;

use App\Models\NovelTagModel;
use App\Models\TagModel;

class Tag extends BaseController
{
    public function tagView()
    {
        $tag = new TagModel();
        $data['data'] = $tag->orderBy('created', 'desc')->findAll();
        return view('content_management/tag/index', $data);
    }

    public function addTagView()
    {
        return view('content_management/tag/add_tag');
    }

    public function editTagView($id)
    {
        $tag = new TagModel();
        $data['data'] = $tag->find($id);
        return view('content_management/tag/edit_tag', $data);
    }

    public function addTag()
    {

        $tag = $this->request->getPost('tag');

        $tagM = new TagModel();

        $validate = $this->validate(
            [
                'tag' => 'required',
            ]
        );

        if (!$validate) {
            session()->setFlashdata('error', "Field not be empty");
            return redirect()->to('content_management/tag/add_tag');
        } else {
            $data = [
                'id' => uniqid(),
                'tag' => $tag,
            ];
            $query = $tagM->where('tag', $tag)->first();

            if ($query) {
                session()->setFlashdata('error', 'Genre already exists');
                return redirect('content_management/tag/add_tag');
            } else {
                $add = $tagM->insert($data);
                if ($add) {
                    session()->setFlashdata('success', 'Tag Created Successfully');
                    return redirect()->to('content_management/tag');
                } else {
                    session()->setFlashdata('error', 'Tag Created Failed');
                    return redirect()->to('content_management/tag/add_tag');
                }
            }
        }
    }

    public function editTag($id)
    {

        $tag = $this->request->getPost('tag');

        $tagM = new TagModel();

        $validate = $this->validate(
            [
                'tag' => 'required',
            ]
        );

        if (!$validate) {
            session()->setFlashdata('error', "Field not be empty");
            return redirect()->to('content_management/tag/edit_tag');
        } else {
            $data = [
                'tag' => $tag,
            ];

            $update = $tagM->update($id, $data);
            if ($update) {
                session()->setFlashdata('success', 'Tag Update Successfully');
                return redirect()->to('content_management/tag');
            } else {
                session()->setFlashdata('error', 'Tag Update Failed');
                return redirect()->to('content_management/tag/edit_tag');
            }
        }
    }

    public function deleteTag()
    {
        $tag = new TagModel();
        $novel_tag = new NovelTagModel();

        $id = $this->request->getPost('id');

        $delete = $tag->delete($id);

        if ($delete) {

            $novel_tag->where('tag_id', $id)->delete();

            $response = [
                'error' => false,
                'message' => '',
            ];

        } else {
            $response = [
                'error' => true,
                'message' => '',
            ];
        }
        return $this->response->setJSON($response);
    }
}
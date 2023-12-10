<?php

namespace App\Controllers;

use App\Models\GenreModel;

class Genre extends BaseController
{
    public function genreView()
    {
        $genre = new GenreModel();
        $data['data'] = $genre->orderBy('created', 'desc')->findAll();
        return view('content_management/genre/index', $data);
    }

    public function addGenreView()
    {
        return view('content_management/genre/add_genre');
    }

    public function editGenreView($id)
    {
        $genre = new GenreModel();
        $data['data'] = $genre->find($id);
        return view('content_management/genre/edit_genre', $data);
    }

    public function addGenre()
    {

        $genreName = $this->request->getPost('genre_name');
        $status = $this->request->getPost('status');

        $genre = new GenreModel();

        $validate = $this->validate(
            [
                'genre_name' => 'required',
                'status' => 'required'
            ]
        );

        if (!$validate) {
            session()->setFlashdata('error', "Field not be empty");
            return redirect()->to('content_management/genre/add_genre');
        } else {
            $data = [
                'id' => uniqid(),
                'genre' => $genreName,
                'status' => $status
            ];
            $query = $genre->where('genre', $genreName)->first();

            if ($query) {
                session()->setFlashdata('error', 'Genre already exists');
                return redirect()->to('content_management/genre/add_genre');
            } else {
                $add = $genre->insert($data);
                if ($add) {
                    session()->setFlashdata('success', 'Genre Created Successfully');
                    return redirect()->to('content_management/genre');
                } else {
                    session()->setFlashdata('error', 'Genre Created Failed');
                    return redirect()->to('content_management/genre/add_genre');
                }
            }
        }
    }

    public function editGenre($id)
    {

        $genreName = $this->request->getPost('genre_name');
        $status = $this->request->getPost('status');

        $genre = new GenreModel();

        $validate = $this->validate(
            [
                'genre_name' => 'required',
                'status' => 'required'
            ]
        );

        if (!$validate) {
            session()->setFlashdata('error', "Field not be empty");
            return redirect()->to('content_management/genre/edit_genre');
        } else {
            $data = [
                'genre' => $genreName,
                'status' => $status
            ];

            $update = $genre->update($id, $data);
            if ($update) {
                session()->setFlashdata('success', 'Genre Update Successfully');
                return redirect('content_management/genre');
            } else {
                session()->setFlashdata('error', 'Genre Update Failed');
                return redirect('content_management/genre/edit_genre');
            }
        }
    }

    public function deleteGenre()
    {
        $genre = new GenreModel();

        $id = $this->request->getPost('id');

        $delete = $genre->delete($id);

        if ($delete) {
            $response = [
                'error' => false,
                'message' => '',
            ];

        } else {
            $response = [
                'error' => false,
                'message' => '',
            ];
        }
        return $this->response->setJSON($response);
    }
}
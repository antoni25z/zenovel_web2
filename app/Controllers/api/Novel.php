<?php

namespace App\Controllers\api;

use App\Controllers\BaseController;
use App\Controllers\NovelChapter;
use App\Models\DiscoverModel;
use App\Models\DiscoverNovelModel;
use App\Models\GenreModel;
use App\Models\NovelChapterModel;
use App\Models\NovelModel;
use App\Models\NovelTagModel;
use App\Models\RatingModel;
use App\Models\ReviewModel;
use CodeIgniter\HTTP\ResponseInterface;

class Novel extends BaseController
{

    public function allNovel()
    {
        $discover = new DiscoverModel();
        $novel = new NovelModel();
        $discoverNovel = new DiscoverNovelModel();
        $genre = new GenreModel();
        $tagNovel = new NovelTagModel();
        $rating = new RatingModel();

        $d = $discover->findAll();

        $nt = $novel->where('status', 1)->findAll();

        $nData = [];
        foreach ($nt as $item) {
            $r = $rating->where('novel_id', $item->id)->selectAvg('rating', 'rating')->first()->rating;
            $queryTag = $tagNovel->where('novel_id', $item->id)->join('tag', 'tag.id = novel_tag.tag_id')->findAll();
            if ($r >= 4) {
                $nData[] = [
                    'id' => $item->id,
                    'novel_name' => $item->novel_name,
                    'novel_image' => $item->novel_image,
                    'novel_summary' => $item->novel_summary,
                    'genre' => $genre->find($item->genre_id)->genre,
                    'tag' => $queryTag,
                ];
            }
        }

        $discovers = [];

        if (!empty($nData)) {
            $discovers[] = [
                'id_discover' => 0111,
                'discover_name' => 'Most Populer',
                'novels' => $nData
            ];
        }
        $newN = $novel->where("created >=", 'DATE_ADD(CURDATE(), INTERVAL -7 DAY)')->where('status', 1)->findAll();
        if (!empty($newN)) {
            $discovers[] = [
                'id_discover' => 0112,
                'discover_name' => 'New',
                'novels' => $newN
            ];
        }

        foreach ($d as $item) {
            $novels = [];
            $dn = $discoverNovel->where('discover_id', $item->id)->findAll();

            foreach ($dn as $i) {
                $n = $novel->find($i->novel_id);

                $queryTag = $tagNovel->where('novel_id', $i->novel_id)->join('tag', 'tag.id = novel_tag.tag_id')->findAll();

                $novels[] = [
                    'id' => $n->id,
                    'novel_title' => $n->novel_title,
                    'novel_image' => $n->novel_image,
                    'novel_summary' => $n->novel_summary,
                    'genre' => $genre->find($n->genre_id)->genre,
                    'tag' => $queryTag,
                ];
            }

            if (!empty($dn)) {
                $discovers[] = [
                    'id_discover' => (int)$item->id,
                    'discover_name' => $item->discover_name,
                    'novels' => $novels
                ];
            }
        }

        $response = [
            'error' => [
                'status_code' => ResponseInterface::HTTP_OK,
                'block' => false,
                'error' => false,
                'delete' => false
            ],
            'message' => 'Fetch data successfully',
            'result' => $discovers,
            'novels' => $novel->where('status', 1)->orderBy("RAND()")->limit(20)->findAll()
        ];

        return $this->response->setJSON($response);
    }

    public function searchNovel()
    {
        $novel = new NovelModel();
        $tagNovel = new NovelTagModel();
        $genre = new GenreModel();

        $searches = $this->request->getGet('searches');

        $search = $novel->like("novel_title", $searches)->findAll();

        $novels = [];

        foreach ($search as $n) {
            $queryTag = $tagNovel->where('novel_id', $n->id)->join('tag', 'tag.id = novel_tag.tag_id')->findAll();

            $novels[] = [
                'id' => $n->id,
                'novel_title' => $n->novel_title,
                'novel_image' => $n->novel_image,
                'novel_summary' => $n->novel_summary,
                'genre' => $genre->find($n->genre_id)->genre,
                'tag' => $queryTag,
            ];
        }


        $random = $novel->where('status', 1)->orderBy("RAND()")->limit(20)->findAll();
        foreach ($random as $n) {
            $check = false;
            foreach ($novels as $novel) {
                if ($n->id == $novel['id']) {
                    $check = true;
                }
            }

            if (!$check) {
                $queryTag = $tagNovel->where('novel_id', $n->id)->join('tag', 'tag.id = novel_tag.tag_id')->findAll();

                $novels[] = [
                    'id' => $n->id,
                    'novel_title' => $n->novel_title,
                    'novel_image' => $n->novel_image,
                    'novel_summary' => $n->novel_summary,
                    'genre' => $genre->find($n->genre_id)->genre,
                    'tag' => $queryTag,
                ];
            }
        }

        $response = [
            'error' => [
                'status_code' => ResponseInterface::HTTP_OK,
                'block' => false,
                'error' => false,
                'delete' => false
            ],
            'message' => 'Fetch data successfully',
            'result' => $novels,
        ];

        return $this->response->setJSON($response);
    }

    public function searchNovelM()
    {
        $novel = new NovelModel();
        $tagNovel = new NovelTagModel();
        $genre = new GenreModel();

        $searches = $this->request->getGet('searches');

        $search = $novel->like("novel_title", $searches)->findAll();

        $novels = [];

        foreach ($search as $n) {
            $queryTag = $tagNovel->where('novel_id', $n->id)->join('tag', 'tag.id = novel_tag.tag_id')->findAll();

            $novels[] = [
                'id' => $n->id,
                'novel_title' => $n->novel_title,
                'novel_image' => $n->novel_image,
                'novel_summary' => $n->novel_summary,
                'genre' => $genre->find($n->genre_id)->genre,
                'tag' => $queryTag,
            ];
        }
        $response = [
            'error' => [
                'status_code' => ResponseInterface::HTTP_OK,
                'block' => false,
                'error' => false,
                'delete' => false
            ],
            'message' => 'Fetch data successfully',
            'result' => $novels,
        ];

        return $this->response->setJSON($response);
    }

    public function novel_detail($id)
    {
        $novel = new NovelModel();
        $tagNovel = new NovelTagModel();
        $genre = new GenreModel();
        $chapter = new NovelChapterModel();

        $detail = $novel->find($id);
        $queryTag = $tagNovel->where('novel_id', $detail->id)->join('tag', 'tag.id = novel_tag.tag_id')->findAll();
        $random = $novel->where('status', 1)->where('id != ', $id)->orderBy("RAND()")->limit(20)->findAll();

        if ($detail->chapter_status == 1) {
            $status_chapter = "Completed";
        } else {
            $status_chapter = "Ongoing";
        }

        $novels = [
            'id' => $detail->id,
            'novel_title' => $detail->novel_title,
            'novel_image' => $detail->novel_image,
            'novel_summary' => $detail->novel_summary,
            'status_chapter' => $status_chapter,
            'genre' => $genre->find($detail->genre_id)->genre,
            'tag' => $queryTag,
            'total_chapter' => $chapter->where('novel_id', $id)->countAllResults(),
        ];

        $response = [
            'error' => [
                'status_code' => ResponseInterface::HTTP_OK,
                'block' => false,
                'error' => false,
                'delete' => false
            ],
            'message' => 'Fetch data successfully',
            'result' => [
                'novels' => $novels,
                'also_likes' => $random
            ],
        ];
        return $this->response->setJSON($response);
    }

    public function add_review() {
        $user_id = $this->request->getPost('user_id');
        $novel_id = $this->request->getPost('novel_id');
        $review = $this->request->getPost('review');
        $rating = $this->request->getPost('rating');

        $reviews = new ReviewModel();

        $data = [
          'user_id' => $user_id,
          'novel_id' => $novel_id,
          'review' => $review,
          'rating' => $rating
        ];

        $add = $reviews->insert($data);

        if ($add) {
            $response = [
                'error' => [
                    'status_code' => ResponseInterface::HTTP_OK,
                    'block' => false,
                    'error' => false,
                    'delete' => false
                ],
                'message' => 'Review successfully',
            ];

        } else {
            $response = [
                'error' => [
                    'status_code' => ResponseInterface::HTTP_OK,
                    'block' => false,
                    'error' => true,
                    'delete' => false
                ],
                'message' => 'Review failed',
            ];
        }
        return $this->response->setJSON($response);
    }

    public function all_chapter() {
        $novelChapter = new NovelChapterModel();

        $novel_id = $this->request->getGet('novel_id');

        $chapter = $novelChapter->where('novel_id', $novel_id)->orderBy('chapter_name', "ASC")->findAll();

        $response = [
            'error' => [
                'status_code' => ResponseInterface::HTTP_OK,
                'block' => false,
                'error' => false,
                'delete' => false
            ],
            'message' => 'Fetch Successfully',
            'result' => $chapter
        ];

        return $this->response->setJSON($response);
    }

    public function all_genre() {
        $genre = new GenreModel();
        $novel = new NovelModel();

        $genres = $genre->where('status', 1)->findAll();

        $novels = $novel->where('status', 1)->findAll();

        $response = [
            'error' => [
                'status_code' => ResponseInterface::HTTP_OK,
                'block' => false,
                'error' => false,
                'delete' => false
            ],
            'message' => 'Fetch Successfully',
            'result' => [
                'genres' => $genres,
                'novels' => $novels
            ]
        ];

        return $this->response->setJSON($response);
    }
}
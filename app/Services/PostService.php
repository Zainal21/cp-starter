<?php

namespace App\Services;

use DataTables;
use App\Helpers\Utils;
use Illuminate\Support\Str;
use App\Helpers\ResponseHelper;
use App\Repositories\PostRepository;

class PostService
{
    private $postRepository; 

    public function __construct()
    {
        $this->postRepository = new PostRepository();
    }

    public function getDatatables()
    {
        $posts = $this->postRepository->getLatestPosts();
        return DataTables::of($posts)
        ->addColumn('action', function($row){
            $actionBtn = '-';
            $actionBtn = '<button  class="edit btn btn-success btn-sm mx-2" onClick="showDetailCategory(`'.$row->id.'`)">Edit</button>';
            $actionBtn .= '<button onClick="deleteCategory(`'.$row->id.'`)" class="delete btn btn-danger btn-sm text-white mx-2">Delete</button>';
            return $actionBtn;
        })
        ->addColumn('authors_name', function($row){
            return $row->authors->name;
        })
        ->addColumn('status_posts', function($row){
            $bagdeColor = '';
            if ($row->status === 'draft') :
                $badgeColor = 'bagde-warning';
            elseif ($row->status === 'archive') : 
                $badgeColor = 'bagde-primary';
            elseif ($row->status === 'publish') :
                $badgeColor = 'bagde-success';
            endif;
            $status = '<span class="badge '.$badgeColor.'">'. $row->status .'</span>';
            return $status;
        })
        ->addColumn('category_name', function($row){
            $categoryName = $row->category->name;
            return $categoryName;
        })
        ->addColumn('thumnail_image', function($row){
            $thumbnail = '';
            return $thumbnail;
        })
        ->addColumn('created_at', function($row){
            return date('d-m-Y', \strtotime($row->created_at));
        })
        ->addColumn('utils', function($row){
            $actionUtils = '-';
            $actionUtils = '<button  class="edit btn btn-success btn-sm mx-2" onClick="showDetailCategory(`'.$row->id.'`)">Edit</button>';
            $actionUtils .= '<button onClick="deleteCategory(`'.$row->id.'`)" class="delete btn btn-danger btn-sm text-white mx-2">Delete</button>';
            return $actionUtils;        })
        ->rawColumns(['action', 'utils', 'thumbnail_image', 'authors_name', 'status_posts', 'category_name','created_at'])
        ->addIndexColumn()
        ->make(true);
    }

    public function getLatestPosts()
    {
        return $this->postRepository->getLatestPosts();
    }

    public function getPostById($id)
    {
        return $this->postRepository->getPostById($id);
    }

    public function createNewPost($request)
    {
        try {
            $file = $request['thumbnail'];
            $request['thumbnail'] = $file->move('resources/img/post/', Str::limit(Str::slug($request['title']), 50, '') . '-' . strtotime('now') . '.' . $file->getClientOriginalExtension());
            $post = $this->postRepository->createNewPost($request);
            return $post ? ResponseHelper::success($post, 'Data postingan berhasil ditambahkan') : ResponseHelper::error('Gagal saat menambahkan postingan baru');
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage());
        }
    }

    public function updatePost($request, $id)
    {
        $post = $this->postRepository->getPostById($id);

        if ($request->hasFile('thumbnail')) {
            Utils::removeFile($post->thumbnail);
            $file = $request->file('thumbnail');
            $thumbnail = $file->move('resources/img/post/', Str::limit(Str::slug($request->title), 50, '') . '-' . strtotime('now') . '.' . $file->getClientOriginalExtension());
        }

        $updated = $post->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'thumbnail' => !empty($thumbnail) ? $thumbnail : $post->thumbnail,
        ]);

        return $updated ? ResponseHelper::success($post, 'Data postingan berhasil diperbarui') : ResponseHelper::error('Gagal saat memperbarui postingan');
    }

    public function deletePost($id)
    {
        $deleted = $this->postRepository->deletePost($id);
        if(!$deleted) return ResponseHelper::error('Data Postingan tidak ditemukan');
        return ResponseHelper::success($deleted, 'Data Postingan berhasil dihapus');
    }

    public function publishPosts($id)
    {
        $published = $this->postRepository->publishPost($id);
        if(!$published) return ResponseHelper::error('Data Postingan tidak ditemukan');
        return ResponseHelper::success($published, 'Data Postingan berhasil dihapus');
    }

    public function archivePosts($id)
    {
        $published = $this->postRepository->archivePost($id);
        if(!$published) return ResponseHelper::error('Data Postingan tidak ditemukan');
        return ResponseHelper::success($published, 'Data Postingan berhasil dihapus');
    }

    public function getPostInTrash()
    {
        return $this->postRepository->getPostInTrash();
    }

    public function deletePermanentTrashedItem($id)
    {
        $post = $this->postRepository->getPostInTrashById($id);
        
        if(file_exists($post->thumbnail)){
            unlink($post->thumbnail);
        }
        $post->forceDelete();
        return ResponseHelper::success(1, 'Data Postingan berhasil dihapus secara permanen');
    }

    public function deletePermanentAllTrash()
    {
        $post = $this->postRepository->getPostInOnlyTrash();;
        if($post->count() < 1){
            return ResponseHelper::error('Data Postingan Tidak ditemukan');
        }
        
        foreach($post as $article){
            if(file_exists($article->thumbnail)){
                unlink($article->thumbnail);
            }
            $article->forceDelete();
        }
        return ResponseHelper::success('Data semua data Postingan ditempat sampah berhasil dihapus');
    }

    public function restoreAllPostInTrash()
    {
        $restored = $this->postRepository->restoreAllPostInTrash();
        return ($restored < 1) ? ResponseHelper::error('Data Postingan Tidak ditemukan') : ResponseHelper::success($post,'Semua Data Post yang telah terhapus berhasil di-pulihkan');
    }

    public function restorePostInTrashById($id)
    {
        $restored = $this->postRepository->restoreAllPostInTrash();
        return ($restored < 1) ? ResponseHelper::error('Data Postingan Tidak ditemukan') : ResponseHelper::success($post,'Semua Data Post yang telah terhapus berhasil di-pulihkan');
    }
}
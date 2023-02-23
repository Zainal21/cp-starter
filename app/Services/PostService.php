<?php

namespace App\Services;

use DataTables;
use App\Helpers\Utils;
use Illuminate\Support\Str;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Log;
use App\Repositories\PostRepository;

class PostService
{
    private $postRepository; 

    public function __construct()
    {
        $this->postRepository = new PostRepository();
    }
    /**
     * service to get datatables of latest post
     * 
     * @return The service that was find.
     */
    public function getDatatables()
    {
        $posts = $this->postRepository->getLatestPosts();
        return DataTables::of($posts)
        ->addColumn('action', function($row){
            $actionBtn = '-';
            $actionBtn = '<a class="edit btn btn-info btn-sm mx-2" href="'.route('post.edit', $row->id).'">Edit</a>';
            $actionBtn .= '<button onClick="deletePost(`'.$row->id.'`)" class="delete btn btn-danger btn-sm text-white mx-2">Delete</button>';
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
            return $row->thumbnail;
        })
        ->addColumn('created_at', function($row){
            return date('d-m-Y', \strtotime($row->created_at));
        })
        ->addColumn('utils', function($row){
            $actionUtils = '-';
            if($row->status === 'draft' || $row->status === 'archive'){
                $actionUtils = '<button class="btn btn-success btn-sm mx-2" onClick="publishPost(`'.$row->id.'`)">Publish</button>';
            }else{
                $actionUtils .= '<button class="btn btn-primary btn-sm text-white mx-2" onClick="archivePost(`'.$row->id.'`)">Archive</button>';
            }
            return $actionUtils;        })
        ->rawColumns(['action', 'utils', 'thumbnail_image', 'authors_name', 'status_posts', 'category_name','created_at'])
        ->addIndexColumn()
        ->make(true);
    }
    /**
     * service to get datatable post in trash
     * 
     * @return The service that was find.
     */  
    public function getDatatablesPostInTrash()
    {
        $posts = $this->postRepository->getPostInTrash();
        return DataTables::of($posts)
        ->addColumn('action', function($row){
            $actionBtn = '<button onClick="restorePost(`'.$row->id.'`)" class="btn btn-info btn-sm text-white mx-2">Restore</button>';
            $actionBtn .= '<button onClick="deletePermanentPost(`'.$row->id.'`)" class="btn btn-danger btn-sm text-white mx-2">Delete</button>';
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
            return $row->thumbnail;
        })
        ->addColumn('created_at', function($row){
            return date('d-m-Y', \strtotime($row->created_at));
        })
        ->rawColumns(['action', 'thumbnail_image', 'authors_name', 'status_posts', 'category_name','created_at'])
        ->addIndexColumn()
        ->make(true);
    }
    /**
     * service to get latest post
     * 
     * @return The service that was find.
     */
    public function getLatestPosts()
    {
        try {
            return $this->postRepository->getLatestPosts();
        } catch (\Throwable $th) {
            Log::error($th->getMessage() ?? 'Terjadi kesalahan saat memproses data');
            throw abort(500);
        }
    }
    /**
     * service to get post by id
     * 
     * @param Id request The request string
     * 
     * @return The service that was find.
     */
    public function getPostById($id)
    {
        try {
            return $this->postRepository->getPostById($id);
        } catch (\Throwable $th) {
            Log::error($th->getMessage() ?? 'Terjadi kesalahan saat memproses data');
            throw abort(500);
        }
    }
  /**
     * service to create new post
     * 
     * @param Request request The request object
     * 
     * @return The service that was store.
     */
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
    /**
     * service to update post
     * 
     * @param Id request The request string
     * @param Request request The request object
     * 
     * @return The service that was updated.
     */
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
    /**
     * service to delete post
     * 
     * @param Id request The request string
     * 
     * @return The service that was deleted.
     */
    public function deletePost($id)
    {
        $deleted = $this->postRepository->deletePost($id);
        if(!$deleted) return ResponseHelper::error('Data Postingan tidak ditemukan');
        return ResponseHelper::success($deleted, 'Data Postingan berhasil dihapus');
    }
    /**
     * service to publish post
     * 
     * @param Id request The request string
     * 
     * @return The service that was updated.
     */
    public function publishPosts($id)
    {
        try {
            $published = $this->postRepository->publishPost($id);
            if(!$published) return ResponseHelper::error('Data Postingan tidak ditemukan');
            return ResponseHelper::success($published, 'Data Postingan berhasil dihapus');
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage() ?? 'Terjadi kesalahan saat memproses data');
        }
    }
    /**
     * service to archive post
     * 
     * @param Id request The request string
     * 
     * @return The service that was updated.
     */
    public function archivePosts($id)
    {
        try {
            $archived = $this->postRepository->archivePost($id);
            if(!$archived) return ResponseHelper::error('Data Postingan tidak ditemukan');
            return ResponseHelper::success($archived, 'Data Postingan berhasil dihapus');
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage() ?? 'Terjadi kesalahan saat memproses data');
        }
    }
    /**
     * service to get all post in trash
     * 
     * @return The service that was find.
     */
    public function getPostInTrash()
    {
        try {
            return $this->postRepository->getPostInTrash();
        } catch (\Throwable $th) {
            Log::error($th->getMessage() ?? 'Terjadi kesalahan saat memproses data');
            throw abort(500);
        }
    }
    /**
     * service to delete permanent post item in trash by id
     * 
     * @param Id request The request string
     * 
     * @return The service that was deleted.
     */
    public function deletePermanentTrashedItem($id)
    {
        try {
            $post = $this->postRepository->getPostInTrashById($id);
            
            if(file_exists($post->thumbnail)){
                unlink($post->thumbnail);
            }
            $post->forceDelete();
            return ResponseHelper::success(1, 'Data Postingan berhasil dihapus secara permanen');
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage() ?? 'Terjadi kesalahan saat memproses data');
        }
    }
    /**
     * service to permanent all post in trash
     * 
     * @return The service that was deleted.
     */
    public function deletePermanentAllTrash()
    {
        try {
            $post = $this->postRepository->getPostInOnlyTrash();
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
        } catch (\Throwable $th) {
            return ResponseHelper::error($th->getMessage() ?? 'Terjadi kesalahan saat memproses data');
        }
    }
    /**
     * service to restore all post in trash
     * 
     * @return The service that was updated.
     */
    public function restoreAllPostInTrash()
    {
        try {
            $restored = $this->postRepository->restoreAllPostInTrash();
            return ($restored < 1) ? ResponseHelper::error('Data Postingan Tidak ditemukan') : ResponseHelper::success($restored,'Semua Data Post yang telah terhapus berhasil di-pulihkan');
        } catch (\Throwable $th) {
            Log::error($th->getMessage() ?? 'Terjadi kesalahan saat memproses data');
            throw abort(500);
        }
    }
    /**
     * service to restore post in trash by id
     * 
     * @param Id request The request string
     * 
     * @return The service that was store.
     */
    public function restorePostInTrashById($id)
    {
        try {
            $this->postRepository->restorePostInTrashById($id);
            return ResponseHelper::success(1, 'Data Postingan berhasil dipulihkan');
        } catch (\Throwable $th) {
            Log::error($th->getMessage() ?? 'Terjadi kesalahan saat memproses data');
            throw abort(500);
        }
    }
}
<?php

namespace App\Http\Controllers\CP;

use App\Models\Post;
use App\Models\User;
use App\Helpers\Utils;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\PostService;
use App\Services\CategoryService;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\PostUpdateRequest;

class PostController extends Controller
{
    private $postService;
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
      $this->postService = new PostService();
    }
    

    public function postDatatables()
    {
        return $this->postService->getDatatables();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->postService->getLatestPosts();
        return view('cp.post.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = (new CategoryService)->getLatestCategory();
        return view('cp.post.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        return $this->postService->createNewPost($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = $this->postService->getPostById($id);
        $categories = (new CategoryService)->getLatestCategory();
        return view('cp.post.edit', compact('post', 'categories'));
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        return $this->postService->updatePost($request,$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       return $this->postService->deletePost($id);
    }

    public function PublishPost($id)
    {
        return $this->postService->publishPosts($id);
    }

    public function ArchivePost($id)
    {
        return $this->postService->archivePosts($id);
    }

    public function getPostTrash()
    {
        $data = $this->postService->getPostInTrash();
        return view('cp.post.trash', compact('data'));
    }


    public function deletePermanentTrashedItem($id)
    {
        return $this->postService->deletePermanentTrashedItem($id);
    }

    public function deletePermanentAllTrashedItem()
    {
        return $this->postService->deletePermanentAllTrash();
    }

    public function restoreTrashedItem($id)
    {
        return $this->postService->restorePostInTrashById();
    }

    public function restoreAllTrashedItem()
    {
       return $this->postService->restoreAllPostInTrash();
    }
}

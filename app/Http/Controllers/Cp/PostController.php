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
        // initialize service
        $this->postService = new PostService();
        // initialze middleware
        $this->middleware('permission:post-list|post-create|post-edit|post-delete', ['only' => ['index','store']]);
        $this->middleware('permission:post-create', ['only' => ['create','store']]);
        $this->middleware('permission:post-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:post-delete', ['only' => ['destroy']]);
        $this->middleware('permission:publish-post', ['only' => ['publishPost']]);
        $this->middleware('permission:archive-post', ['only' => ['archivePost']]);
        $this->middleware('permission:trash-post', ['only' => ['getPostsTrash','deletePermanentTrashedItem', 'deletePermanentAllTrashedItem','restoreTrashedItem','restoreAllTrashedItem']]);
    }
    

    public function postDatatables()
    {
        return $this->postService->getDatatables();
    }
    
    public function postInTrashDatatables()
    {
        return $this->postService->getDatatablesPostInTrash();
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
    public function update(PostUpdateRequest $request, $id)
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
    /**
     * action to publish post
     * 
     * @param Request request The request object
     * 
     * @return The service that was store.
     */
    public function publishPost($id)
    {
        return $this->postService->publishPosts($id);
    }
    /**
     * action to archive post
     * 
     * @param Request request The request object
     * 
     * @return The service that was store.
     */
    public function archivePost($id)
    {
        return $this->postService->archivePosts($id);
    }
    /**
     * show the post item in trash 
     * 
     * @param Request request The request object
     * 
     * @return The service that was store.
     */
    public function getPostTrash()
    {
        $data = $this->postService->getPostInTrash();
        return view('cp.post.trash', compact('data'));
    }
    /**
     * action to delete permanent trash item by id
     * 
     * @param Id request The request string
     * 
     * @return The service that was store.
     */
    public function deletePermanentTrashedItem($id)
    {
        return $this->postService->deletePermanentTrashedItem($id);
    }
    /**
     * action to delete permanent all trash item
     * 
     * @return The service that was store.
     */
    public function deletePermanentAllTrashedItem()
    {
        return $this->postService->deletePermanentAllTrash();
    }
    /**
     * action to restore post item in trash by id
     * 
     * @param Id request The request string
     * 
     * @return The service that was store.
     */
    public function restoreTrashedItem($id)
    {
        return $this->postService->restorePostInTrashById($id);
    }
    /**
     * action to restore all item in trash
     * 
     * @return The service that was store.
     */
    public function restoreAllTrashedItem()
    {
       return $this->postService->restoreAllPostInTrash();
    }
}

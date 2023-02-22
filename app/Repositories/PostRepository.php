<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;

interface PostContract
{
    public function getLatestPosts();
    public function getPostById($id);
    public function createNewPost($data);
}

class PostRepository implements PostContract
{
    /**
     * Query for get latest post with category authors
     * 
     * @return The service that was find.
     */
    public function getLatestPosts()
    {
        return Post::with(['category', 'authors'])->latest()->get();
    }
    /**
     * Query for store new post into database
     * 
     * @param Request request The request object
     * 
     * @return The service that was store.
     */
    public function createNewPost($data)
    {
        return Post::create([
            'title' => $data['title'],
            'category_id' => $data['category_id'],
            'author' => auth()->user()->id,
            'slug' => Str::slug($data['title']),
            'thumbnail' => $data['thumbnail'],
            'content' => $data['content'],
        ]);
    }
    /**
     * Query for deleted post (move into trash)
     * 
     * @param id request The request string
     * 
     * @return The service that was deleted.
     */
    public function deletePost($id)
    {
        return Post::destroy($id);
    }
    /**
     * Query for get post item by id
     * 
     * @param id request The request string
     * 
     * @return The service that was find.
     */
    public function getPostById($id)
    {
        return Post::findOrfail($id);
    }
    /**
     * Query for change status posts into published post 
     * 
     * @param Request request The request string
     * 
     * @return The service that was updated.
     */
    public function publishPost($id)
    {
        $posts = Post::findOrfail($id);
        return $posts->setPublish();
    }
    /**
     * Query for change status posts into archived post 
     * 
     * @param Request request The request string
     * 
     * @return The service that was updated.
     */
    public function archivePost($id)
    {
        $posts = Post::findOrfail($id);
        return $posts->setArchive();
    }
    /**
     * Query for get all post in trash
     * 
     * @return The service that was find.
     */
    public function getPostInTrash()
    {
        return Post::with(['category', 'authors'])->onlyTrashed()->get();
    }
    /**
     * Query for get posts in trash by id
     * 
     * @param id request The request string
     * 
     * @return The service that was find.
     */
    public function getPostInTrashById($id)
    {
        return Post::onlyTrashed()->where('id',$id)->first();
    }
    /**
     * Query for get posts only in trash
     * 
     * @param Request request The request object
     * 
     * @return The service that was find.
     */
    public function getPostInOnlyTrash()
    {
        return Post::onlyTrashed()->get();
    }
    /**
     * Query for restore post in tras by id
     * 
     * @param id request The request string
     * 
     * @return The service that was restored.
     */
    public function restorePostInTrashById($id)
    {
        return Post::onlyTrashed() ->where('id', $id)->restore();
    }
    /**
     * Query for restore all post in trash
     * 
     * @return The service that was restored.
     */
    public function restoreAllPostInTrash()
    {
        return Post::onlyTrashed()->restore();
    }
}
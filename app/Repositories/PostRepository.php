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
    public function getLatestPosts()
    {
        return Post::with(['category', 'authors'])->latest()->get();
    }

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

    public function deletePost($id)
    {
        return Post::destroy($id);
    }

    public function getPostById($id)
    {
        return Post::findOrfail($id);
    }

    public function publishPost($id)
    {
        $posts = Post::findOrfail($id);
        return $posts->setPublish();
    }

    public function archivePost($id)
    {
        $posts = Post::findOrfail($id);
        return $posts->setArchive();
    }

    public function getPostInTrash()
    {
        return Post::with(['category', 'authors'])->onlyTrashed()->get();
    }

    public function getPostInTrashById($id)
    {
        return Post::onlyTrashed()->where('id',$id)->first();
    }

    public function getPostInOnlyTrash()
    {
        return Post::onlyTrashed()->get();
    }

    public function restorePostInTrashById($id)
    {
        return Post::onlyTrashed() ->where('id', $id)->restore();
    }

    public function restoreAllPostInTrash()
    {
        return Post::onlyTrashed()->restore();
    }
}
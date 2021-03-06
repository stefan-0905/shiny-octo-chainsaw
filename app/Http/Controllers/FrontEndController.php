<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;
use App\Category;
use App\Tag;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    public function index() {
        $posts = Post::with('author', 'category')
                    ->latestFirst()
                    ->published()
                    ->filter(request()->only(['searchTerm', 'year', 'month']))
                    ->simplePaginate(5);
        
        return view('index', ['posts' => $posts]);
    }
    
    /**
     * Injecting Post which we registered in our RouteServiceProvider - Explicit Binding
     */
    public function show(Post $post) {
        $post->view_count++;
        $post->save();
        return view('show', ['post' => $post]);
    }

    /**
     * Here Category is injected by Implicit Binding with customized RouteKeyName 
     * defined in class model
     */
    public function category_search(Category $category) {
        $posts = $category->posts()
                        ->with('author', 'category')
                        ->latestFirst()
                        ->published()
                        ->simplePaginate(4);

        return view('search', ['posts' => $posts, 'search_result' => $category->title]);
    }

    public function author_search(User $author) {
        $posts = $author->posts()
                        ->with('category')
                        ->latestFirst()
                        ->published()
                        ->simplePaginate(4);
                        
        return view('search', ['posts' => $posts, 'search_result' => $author->name]);
    }

    public function tag_search(Tag $tag) {
        $posts = $tag->posts()
                        ->with('author', 'category')
                        ->latestFirst()
                        ->published()
                        ->simplePaginate(4);
                        
        return view('search', ['posts' => $posts, 'search_result' => $tag->name]);
    }
}

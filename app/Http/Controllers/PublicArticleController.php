<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicArticleController extends Controller
{
    public function index()
    {
        $articles = Article::all();
        return Inertia('Public/Article/Index', compact('articles'));
    }


    public function show(int $id)
    {
        return Inertia('Public/Article/Show', compact('id'));
    }


    public function getArticle(Article $article)
    {
        return response()->json($article);
    }
}

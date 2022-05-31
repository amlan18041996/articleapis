<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->limit !== null ? $request->limit : 5;
        return Article::orderBy('id', 'desc')->paginate($limit);
    }

    public function show($id)
    {
        $article = Article::find($id);
        return response()->json($article, 201);
    }

    public function store(Request $request)
    {
        // Retrieve the validated input data...
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $article = Article::create($request->all());
        return response()->json($article, 201);
    }

    public function update($id, Request $request)
    {
        $article = Article::find($id);
        if($article !== null){
            $article->update($request->all());
            return response()->json($article, 200);
        }else{
            return response()->json(["article" => "This Article was not found."], 404);
        }
    }

    public function delete($id)
    {
        $article = Article::find($id);
        if($article !== null){
            $article->delete();
            return response()->json(null, 204);
        }else{
            return response()->json(["article" => "This Article was not found."], 404);
        }
    }
}

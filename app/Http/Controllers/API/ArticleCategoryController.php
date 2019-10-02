<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ArticleCategory;
class ArticleCategoryController extends Controller
{
    
    public function __construct()
    {
        // make an auth: to use the api passport
        $this->middleware('auth:api');
    }

    public function index()
    {
        if(\Gate::allows('isAdminOrUserOrAuthorOrEmployeeOrSupply') ){
            return ArticleCategory::latest()->paginate(5);
        }
    }
    

    public function store(Request $request)
    {
        $this->validate($request, [
            'article' => 'required|string|max:191|unique:article_categories,article', //1
            'account_name' => 'required|string|max:191', //2
            'account_code' => 'required|string|max:191', //3
            
        ]);
        // Insert the data into databse
        return ArticleCategory::create([
            'article' => $request['article'], //1
            'account_name' => $request['account_name'], //1
            'account_code' => $request['account_code'], //1
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'article' => 'required|string|max:191|unique:article_categories,article', //1
            'account_name' => 'required|string|max:191', //2
            'account_code' => 'required|string|max:191', //3
            
        ]);
        $article_category = ArticleCategory::findOrFail($id);
        $article_category->update($request->all());
        return ['message' => 'Updated the Accounts info'];
    }
    public function destroy($id)
    {
        //
        $article_category = ArticleCategory::findOrFail($id);
        $article_category->delete();
        return ['message' => 'Accounts Deleted'];
    }
}

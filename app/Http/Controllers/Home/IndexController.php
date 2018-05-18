<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/5/18
 */
namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;
use App\Repositories\ArticleRepository;
use Chenhua\MarkdownEditor\Facades\MarkdownEditor;

class IndexController extends Controller
{
    public function index()
    {

    }

    public function article(\Request $request, ArticleRepository $articleRepository, $id)
    {
        $article = $articleRepository->find($id, true);
        $article = $article->toArray();
        if ($article['is_md']) {
            $article['content'] =  MarkdownEditor::parse($article['content']['content']);
        };
        return home_view('index.article', $article);
    }
}
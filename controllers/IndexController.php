<?php
namespace Controllers;
use Database\Category;
use Database\Article;
use Exception;

class IndexController extends BaseController
{
    public function indexAction()
    {
        $this->view('index', ['categories' => Category::getCategories()]);
    }
    
    public function categoryAction(int $id)
    {
        if ($page = $this->getQuery('page', FilterTipe::TYPE_INT)) {
            Category::setPage($page);
        }

        if ($data = $this->getQuery('date', FilterTipe::TYPE_DATE)) {
            Category::setDate($data);
        }

        if (($sort = $this->getQuery('sort', SortType::TYPE_ASC)) || ($sort = $this->getQuery('sort', SortType::TYPE_DESC))) {
            Category::setSort($sort);
        }
        
        $this->view('category', ['category' => Category::getCategoryById($id)]);
    }

    public function articleAction(int $id)
    {
        Article::addViewCount($id);
        $this->view('article', ['article' => Article::getArticleById($id)]);
    }

    public function ErrorAction()
    {
        $this->view('404');
    }

}
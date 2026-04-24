<?php
namespace Controllers;
use Database\Category;
use Database\Article;   
class IndexController extends BaseController
{
    public function indexAction()
    {
        $this->view('index', ['categories' => Category::getCategories()]);
    }
    
    public function categoryAction(int $id)
    {
        $this->view('category', ['category' => Category::getCategoryById($id)]);
    }

    public function articleAction(int $id)
    {
        $this->view('article', ['article' => Article::getArticleById($id)]);
    }

    public function ErrorAction()
    {
        $this->view('404');
    }

}
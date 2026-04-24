<?php
namespace Database;

class ArticleCategory extends BaseSql
{
    public int $id;
    public int $category_id;
    public int $article_id;

    public function __construct()
    {
        
    }
}
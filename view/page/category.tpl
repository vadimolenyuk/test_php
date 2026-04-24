<div>
    {$category->title}  
    {$category->description}
    {foreach $category->getArticles() as $article}
        <div>
            <a href="/article/{$article->id}">{$article->title}</a>
        </div>
    {/foreach}
</div>
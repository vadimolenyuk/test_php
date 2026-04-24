<div class="content">
    <h2>{$category->title}</h2>
    <div><h4>Description:</h4></div>  
    <p>{$category->description}</p>
    {foreach $category->getArticles() as $article}
        <div class="article-block">
            <a class="view-botton" href="/article/{$article->id}">{$article->title}</a>
            <div>
                <img src="/images/{$article->image}" alt="{$article->title}" width="100" height="100">
            </div>
        </div>
    {/foreach}
</div>
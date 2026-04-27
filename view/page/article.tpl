<div class="content">
    <h2>{$article->title}</h2>
    <div class="article-description"><h4>Description:</h4>
        <p>{$article->description}</p>
    
        <p>{$article->details}</p>
    </div>
    <div class="article-image">
        <img src="/images/{$article->image}" alt="{$article->title}" width="300" height="300"> 
    </div>

    <div>
    {foreach $article->getLinkArticle() as $article}
        <div class="article-block">
            <a class="view-botton" href="/article/{$article->id}">{$article->title}</a>
            <div>
                <img src="/images/{$article->image}" alt="{$article->title}" width="100" height="100">
            </div>
        </div>
    {/foreach}
    </div>
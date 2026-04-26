<div class="content">
    <h2>Home</h2>
    {foreach from=$categories item=item key=key name=name}
        {$articles = $item->laststArticles()}
        {if $articles|@count > 0}            
        <div class="category">
            <h2> {$item->title}</h2>
                {foreach from=$articles item=article key=key name=name}
                    <div class="article-block">
                        <h4>{$article->title}</h4>
                        <img src="images/{$article->image}" alt="{$article->title}" width="100" height="100">
                    </div>
                {/foreach}
                <a class="view-botton" href="/category/{$item->id}">View Category</a>
        </div>
        {/if}
    {/foreach}
</div>
{foreach from=$categories item=item key=key name=name}
    <div>
        {$item->title}
        <p>{$item->description}</p>
        <div>
            {foreach from=$item->getArticles() item=article key=key name=name}
                <div>
                    {$article->title}
                    <p>{$article->description}</p>
                    <img src="{$article->image}" alt="{$article->title}" width="100" height="100">

                </div>
            {/foreach}
            <a href="/category/{$item->id}">View Category</a>
    </div>
{/foreach}
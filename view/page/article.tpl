<div class="content">
    <h2>{$article->title}</h2>
    <div class="article-description"><h4>Description:</h4>
        <p>{$article->description}</p>
    
        <p>{$article->details}</p>
    </div>
    <div class="article-image">
        <img src="/images/{$article->image}" alt="{$article->title}" width="300" height="300"> 
    </div>
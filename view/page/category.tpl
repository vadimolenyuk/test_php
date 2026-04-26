
<div class="content">
<div class="article-list">
    <h2>{$category->title}</h2>
    <div><h4>Description:</h4></div>  
    <p>{$category->description}</p>
    {$paginationData = $category->paginationArticles()}
    {$page = $paginationData.page|default:1}
    {$urlSort = "{$paginationData.sort ? "&sort={$paginationData.sort}" : ''}"}
    {$urlDate = "{$paginationData.date ? "&date={$paginationData.date}" : ''}"}
    <div class="form-row align-items-end">
        <div class="form-group col-md-4"><label>Sort by show:</label>
            <select id="sort" class="form-control" name="sort" onchange="applyFilters({$page})">
                <option {($paginationData.sort == '') ? 'selected' : ''}>------</option>
                <option {($paginationData.sort == 'asc') ? 'selected' : ''}>asc</option>
                <option {($paginationData.sort == 'desc') ? 'selected' : ''}>desc</option>    
            </select>
        </div> 
        <div class="form-group col-md-4">
            <label >Date publcation:</label>
            <input type="text" id="datepicker" class="form-control" placeholder="specify the date" value="{$paginationData.date}" onchange="applyFilters({1})">
        </div>  
        <div class="form-group col-md-4">
            <button class="btn btn-filter" onclick="window.location.href=window.location.pathname">Clear filter</button>
        </div> 
   </div>

    {foreach $paginationData.items as $article}
        <div class="article-block">
            <a class="view-botton" href="/article/{$article->id}">{$article->title}</a>
            <div>
                <img src="/images/{$article->image}" alt="{$article->title}" width="100" height="100">
            </div>
        </div>
    {/foreach}
</div>

    <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <li class="page-item">
            <a class="page-link {if $page <= 1}disabled{/if}" href="?page={($page - 1 <= 1) ? 1 : $page - 1}{$urlSort}{$urlDate}">Previous</a>
        </li>
        {for $i = 1 to $paginationData.totalPages}
             <li class="page-item {($i == $page) ? 'active' : ''}"><a class="page-link" href="?page={$i}{$urlSort}{$urlDate}"">{$i}</a></li>
        {/for}
   

        <li class="page-item">
        <a class="page-link {if $page <= 1}disabled{/if}" href="?page={($page + 1 > $paginationData.totalPages)? $paginationData.totalPages : $page + 1}{$urlSort}{$urlDate}">Next</a>
        </li>
    </ul>
    </nav>
</div>
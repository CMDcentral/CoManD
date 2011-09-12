<?
foreach ($articles as $article) {
?>
<article class="post">
            <h2 class="entry-title"><a href="/article/view/<?=$article->alias?>.html"><?=$article->title?></a></h2>
            <figure>
                <a href="#"><img class="thumbnail alignleft" alt="Post thumbnail" src="/thumb/index/width/200/height/200?i=/images/news/<?=$article->images?>"></a>
            </figure>
            <div class="entry-content">
               <?=$article->introtext?>
            </div> <!-- .entry-content -->
            <footer class="post-meta">
                <p>
                    In <a rel="category" href="#">Category Name</a>
                    by <span class="author vcard"><a href="#" class="url fn n">Author name</a></span>
                    on <time pubdate="" datetime="2011-05-14">May 14th, 2011</time>
                </p>
                <a class="more-link" href="/article/view/<?=$article->alias?>.html">Read more</a>
            </footer> <!-- .post-meta -->
        </article>
<? } ?>
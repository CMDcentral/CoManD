<h2 class="title">CMDcentral Newsfeed</h2>
<?=activity($newsfeed)?>
<div id="lastPostsLoader"></div>
<br />
<div class="note" style="cursor: pointer;" onClick="lastPostFunc()" id="loadMore"><center>Click here to load older posts.</center></div>
<script>
function lastPostFunc()
{
    $("div#lastPostsLoader").html('<center><img src="/images/loader.gif"/></center>');
    $.post("/activity/get.html?lastID=" + $(".act:last").attr("id"),
    function(data){
        if (data != "") {
        $(".act:last").after(data);
        }
        $("div#lastPostsLoader").empty();
    });                 
}; 
</script>

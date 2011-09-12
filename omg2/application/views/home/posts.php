<?php
//    error_reporting(0);
    define('IN_PHPBB', true);

include_once ('../../forum/config.php');  
$urlPath = "";                //phpBB URL with respect to root
$topicnumber = "";            //Total Post Count to Display
$posttext = "";                //Number of Characters to display in Post Text
$excludedforums = "";        //Forum ids to exclude. Each forum id should be seprated with Comma
$completeurl = "";
$table_prefix = "phpbb_";

    $table_topics = $table_prefix. "topics";    //Usually you don't have to change below 4 variables
    $table_forums = $table_prefix. "forums";
    $table_posts = $table_prefix. "posts";
    $table_users = $table_prefix. "users";

function stripBBCode($text_to_search) {
     $pattern = '|[[\/\!]*?[^\[\]]*?]|si';
     $replace = '';
     return preg_replace($pattern, $replace, $text_to_search);
}

    $link = mysql_connect("localhost", "root", "ryvenapa121") or die("Could not connect");
    mysql_select_db("cmd_phpbb3") or die("Could not select database");
    $sub_query = '';
    if(strlen($excludedforums) > 0) {
        $pieces = explode(",", $excludedforums);
        foreach ($pieces as $exforumid) {
            $sub_query .= " t.forum_id != " . $exforumid . ' AND ';
            }
    }

    $query = "SELECT t.topic_id, t.topic_title, t.topic_last_post_id, t.forum_id, p.post_id, p.poster_id, p.post_time, u.user_id, u.username, f.forum_name, p.post_text, p.bbcode_uid, p.bbcode_bitfield, f.forum_desc_options
    FROM $table_topics t, $table_forums f, $table_posts p, $table_users u
    WHERE t.topic_id = p.topic_id AND
    f.forum_id = t.forum_id AND ";

    if(strlen($sub_query) > 0) {
        $query .=  $sub_query ;
    }

    $query .= " t.topic_status <> 2 AND
    p.post_id = t.topic_last_post_id AND
    p.poster_id = u.user_id
    ORDER BY p.post_id DESC LIMIT 5";
//    echo $query;
    $result = mysql_query($query) or die("Query failed" . mysql_error($link));

    if($topicnumber % 2) {
        $x="even";
    } else {
        $x="odd";
    }
    $y=0;
 while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    ++$y;
    if ($y==$topicnumber) {
        $x= $x .  " dataitemlast";
    }
    ?>
<!--	<b><font size="2px"><?=$row["forum_name"]?></font></b><sub> >  -->
	<sub>
	<a class="tooltip" href="/forum/viewtopic.php?f=<?=$row[forum_id]?>&t=<?=$row[topic_id]?>&p=<?=$row[post_id]?>#p<?=$row[post_id]?>" title="<?=$row["post_text"]?>"><?=$row["topic_title"]?></a><br/>
        Posted by <?=$row[username]?>: <?=date('F j, Y, g:i a', $row["post_time"])?>
	</sub><br/>
<?
 }
    mysql_free_result($result);
  mysql_close($link);
?>
<!-- <script src="http://tab-slide-out.googlecode.com/files/jquery.tabSlideOut.v1.3.js"></script>

    <script type="text/javascript">
    $(function(){
        $('.slide-out-div').tabSlideOut({
            tabHandle: '.handle',                     //class of the element that will become your tab
            pathToTabImage: '/images/help.gif', //path to the image for the tab //Optionally can be set using css
            imageHeight: '122px',                     //height of tab image           //Optionally can be set using css
            imageWidth: '40px',                       //width of tab image            //Optionally can be set using css
            tabLocation: 'left',                      //side of screen where tab lives, top, right, bottom, or left
            speed: 300,                               //speed of animation
            action: 'click',                          //options: 'click' or 'hover', action to trigger animation
            topPos: '200px',                          //position from the top/ use if tabLocation is left or right
            leftPos: '20px',                          //position from left/ use if tabLocation is bottom or top
            fixedPosition: false                      //options: true makes it stick(fixed position) on scroll
        });

    });

    </script> -->

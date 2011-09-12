<?php

function has_no_emailheaders($text)
{
   return preg_match("/(%0A|%0D|\\n+|\\r+)(content-type:|to:|cc:|bcc:)/i", $text) == 0;
}
foreach ($_POST as $field)
if(!has_no_emailheaders($field))
exit("invalid content");

// require('FirePHPCore/fb.php');

//ob_start();

//fb('Hello World');

filter_var($_POST["slide_captions"], FILTER_SANITIZE_STRING);

$first_last_buttons         = filter_var($_POST["first_last_buttons"], FILTER_SANITIZE_STRING);
$first_slide_is_intro       = filter_var($_POST["first_slide_is_intro"], FILTER_SANITIZE_STRING);
$hover_next_prev_buttons    = filter_var($_POST["hover_next_prev_buttons"], FILTER_SANITIZE_STRING);
$next_prev_buttons          = filter_var($_POST["next_prev_buttons"], FILTER_SANITIZE_STRING);
$pause_button               = filter_var($_POST["pause_button"], FILTER_SANITIZE_STRING);
$slide_buttons              = filter_var($_POST["slide_buttons"], FILTER_SANITIZE_STRING);
$slide_directory            = filter_var($_POST["slide_directory"], FILTER_SANITIZE_STRING);
$doctype                    = filter_var($_POST["doctype"], FILTER_SANITIZE_STRING);
$slide_links_list           = filter_var($_POST["slide_links"], FILTER_SANITIZE_STRING);
$slide_number_display       = filter_var($_POST["slide_number_display"], FILTER_SANITIZE_STRING);
$slide_captions             = filter_var($_POST["slide_captions"], FILTER_SANITIZE_STRING);
$water_mark                 = filter_var($_POST["water_mark"], FILTER_SANITIZE_STRING);

echo "<div id='slide_holder_inner'>";

if ($hover_next_prev_buttons == "yes") {
    echo "<div id='hover_prev_button' class='prev_button hover_button'><span>prev</span></div>";
    echo "<div id='hover_next_button' class='next_button hover_button'><span>next</span></div>";
}
if ($water_mark != "no") {
    echo "<div id='water_mark' class='water_mark'><span>". $water_mark ."</span></div>";
}
echo "<div id='row_of_slides'>";

if($doctype == 'html'){
	$close_tag = '>';
} elseif($doctype == 'xhtml'){
	$close_tag = '/>';
} else {
	$close_tag = '>';
}

$slide_links     = (explode(",",$slide_links_list));
$slide_dir       = scandir($slide_directory);
$counter         = 1;

foreach ($slide_dir as $slide_file) {
    if (preg_match('/^.*\.jpe?g$|^.*\.gif$|^.*\.png$/i', $slide_file)) {
        $slide_type = 'image_slide';
    }
    else if (preg_match('/^.*\.htm$|^.*\.html$/i', $slide_file)) {
        $slide_type = 'html_slide';
    }
    else if (preg_match('/^.*\.swf$/i', $slide_file)) {
        $slide_type = 'swf_slide';
    } else {}
    switch ($slide_type) {
        case 'image_slide':
        $curr_index = $counter - 1;
        $link_value = $slide_links[$curr_index];
            if ($first_slide_is_intro == 'yes') {
	        if ($counter == 1) {
     	        echo "<div class='intro' id='intro'>";
            } else {
     	        $counter_w_intro = $counter - 1;
		        echo "<div class='slide' id='slide_$counter_w_intro'>";
            }}  else if ($first_slide_is_intro != 'yes') {
                echo "<div class='slide' id='slide_$counter'>";	} // else if		
			if($slide_links_list != 'no') {
                if($link_value != null){
                    echo "<a href='$link_value'>";
                };
            }
        echo "<img src='$slide_directory/$slide_file'$close_tag";
            if($slide_links_list != 'no') {
                if($link_value != null){
                    echo "</a>\n";
                };
            }
        echo "</div>\r";
        $counter++;
        break;

        case 'html_slide':
        // had to repeat regex to make it work. was accepting .php, .js. why???
            if ((preg_match('/^.*\.htm$|^.*\.html$/i', $slide_file))){
			if ($first_slide_is_intro == 'yes') {
	            if ($counter == 1) {
     	            echo "<div class='intro' id='intro'>";
                } else  {
     	            $counter_w_intro = $counter - 1;
		            echo "<div class='slide' id='slide_$counter_w_intro'>";
            }}  else if ($first_slide_is_intro != 'yes') {   
			echo "<div class='slide' id='slide_$counter'>\n";} // else if
                echo file_get_contents("$slide_directory/$slide_file");
                echo "</div>\r";
                $counter++;
            } //if
        break;

        case 'swf_slide':
            $size = getimagesize("$slide_directory/$slide_file");			
				if ($first_slide_is_intro == 'yes') {
	                
					if ($counter == 1) {
 		            echo "<div class='intro' id='intro'>\n";
     	              	           
                    } else { 
					$counter_w_intro = $counter - 1; 
					echo "<div class='slide' id='slide_$counter_w_intro'>\n"; 
					}
		             
                 } else if ($first_slide_is_intro != 'yes') {   
            echo "<div class='slide' id='slide_$counter'>\n"; } //else if
            
            
            echo "<object type='application/x-shockwave-flash' data='$slide_directory/$slide_file' width='$size[0]' height='$size[1]'>\n";
            echo "<param name='movie' value='$slide_directory/$slide_file'$close_tag<param name='WMode' value='opaque'$close_tag\n</object>\n";
            echo "</div>\r";
            $counter++;
            break;

        default:
        break;
    } // switch
} // foreach

echo "</div><div id='carousel_controls'>";

if($slide_number_display == "yes"){
echo "<div class='slide_number_display' id='slide_number_display'><span></span></div>\n";
}

// make buttons

if($pause_button == "yes") { 
    echo "<div class='pause_button' id='pause_button'><span>pause</span></div>\n";
};
if($slide_buttons == "yes") { 
    echo "<ul id='slide_buttons'>\n";
$button_number = 1;
	if ($first_slide_is_intro != 'yes') {
	
		while ($button_number <= ($counter -1 ) ) {
		    echo "<li class='slide_$button_number'><span>$button_number</span></li>\n";
		    $button_number++;
		} // while
	} // if
	if ($first_slide_is_intro  == 'yes') {
		$button_counter_w_intro = $counter - 1;
		while ($button_number <= ($button_counter_w_intro -1 ) ) {
	    echo "<li class='slide_$button_number'><span>$button_number</span></li>\n";
	    $button_number++;
		} // while
	} // if
echo "</ul>";
};
if ($next_prev_buttons == "yes") {
    echo "<div id='prev_button' class='prev_button'><span>&lt; prev</span></div>";
    echo "<div id='next_button' class='next_button'><span>next &gt;</span></div>";
}
if ($first_last_buttons == "yes") {
    echo "<div id='first_button' class='first_button'><span>first &gt;&gt;</span></div>";
    echo "<div id='last_button' class='first_button'><span>&lt;&lt; last</span></div>";
}
if ($slide_captions != "false") {
    echo "<div id='slide_captions' class='slide_captions'><span></span></div>";
}
echo "</div></div>";

?>
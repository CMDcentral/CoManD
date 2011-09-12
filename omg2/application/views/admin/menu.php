<link type="text/css" href="/css/sf.css" rel="stylesheet" />
<script type="text/javascript" src="/js/superfish.js"></script>

<div id="adminmenu">
<ul class="sf-menu sf-js-enabled sf-shadow" id="sample-menu-1">
					<li class="">
						<a href="#" class="sf-with-ul">Articles<span class="sf-sub-indicator"> »</span></a>
						<ul style="display: none; visibility: hidden;">
							<li><a href="/article/edit/add.html">Add Article</a></li>
							<li><a class="popup" href="/admin/newslist/<?=$this->uri->segment(3)?>.html">Edit Article</a></li>
							<li><a href="/article/view/<?=$this->uri->segment(3)?>.html">View Article</a></li>
						</ul>
					</li>
                                        <li class="">
                                                <a href="#" class="sf-with-ul">Pages<span class="sf-sub-indicator"> ï¿½</span></a>
                                                <ul style="display: none; visibility: hidden;">
                                                        <li><a href="/pages/edit/add.html">Add Page</a></li>
                                                        <li><a href="/pages/edit/<?=$this->uri->segment(3)?>.html">Edit Page</a></li>
                                                        <li><a href="/pages/view/<?=$this->uri->segment(3)?>.html">View Page</a></li>
                                                </ul>
                                        </li>
                                        <li class="">
                                                <a href="#" class="sf-with-ul">Gallery<span class="sf-sub-indicator"> ï¿½</span></a>
                                                <ul style="display: none; visibility: hidden;">
                                                        <li><a href="/admin/addgallery.html">Add Gallery</a></li>
                                                        <li><a href="/admin/editgallery/<?=$this->uri->segment(3)?>.html">Edit Gallery</a></li>
                                                </ul>
                                        </li>
					<li>
						<a href="/admin.html">Admin</a>
					</li>
</ul>
</div>
<script>

    $(document).ready(function() {
        $('ul.sf-menu').superfish({
            delay:       1000,                            // one second delay on mouseout
            animation:   {opacity:'show',height:'show'},  // fade-in and slide-down animation
            speed:       'fast',                          // faster animation speed
            autoArrows:  false,                           // disable generation of arrow mark-up
            dropShadows: false                            // disable drop shadows
        });
    });

</script>

<?
echo $controls;
echo $calendar;
?>
<script type="text/javascript">
$(document).ready(function() {

 $('.control').bind('click',function(event){
                        event.preventDefault();
                    $.get(this.href,{},function(response){
			   $('#cal').html('<p align="center"><img src="/images/ajax-loader-2.gif" width="220" height="19" /></p>');
                           $('#cal').html(response)
                    })
                 })
});

$(document).ready(function() {
        $(".popup").fancybox();
});

</script>

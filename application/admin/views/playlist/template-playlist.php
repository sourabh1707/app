<!DOCTYPE html>
<html>
    <style>body{padding:0;margin:0;}</style>
    <body id="html_body"></body>
    <script type="text/javascript">
        document.body.style.width = $card.getScreenWidth();
        document.body.style.height = $card.getScreenHeight();
        var content = [];
        var timer = [];
        var bgcolor = [];
        var step=0;
        var total = <?php echo count($contents); ?>;
        <?php $i=0; foreach ($contents as $key => $value) { ?>
            content[<?php echo $i; ?>] = '<?php echo $value["data"]; ?>';
            timer[<?php echo $i; ?>] = parseInt(<?php echo $value["time"]; ?>)*1000;
            bgcolor[<?php echo $i; ?>] = '<?php echo $value["bc"]; ?>';
        <?php $i++; } ?>
        function slideit(){
            document.body.style.backgroundColor = bgcolor[step];
            document.getElementById("html_body").innerHTML = content[step];
            var video = document.getElementsByTagName("video")[0];
		if(video){
		    video.height = $card.getScreenHeight();
		    video.width = $card.getScreenWidth();
		}
            setTimeout("slideit()",timer[step]);
	    if(step==total){/*step=0*/location.reload(true);}
	    step++;
        }
        slideit();
    </script>
</html>

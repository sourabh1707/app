<link href="<?php echo base_url('template/admin') ?>/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

<style>
.example1 {
 height: 50px;  
 overflow: hidden;
 position: relative;
}
.example1 > div {
 font-size: 3em;
 position: absolute;
 width: 100%;
 height: 100%;
 margin: 0;
 line-height: 50px;
 text-align: center;
 /* Starting position */
 -moz-transform:translateX(100%);
 -webkit-transform:translateX(100%);    
 transform:translateX(100%);
 /* Apply animation to this element */  
 -moz-animation: example1 15s linear infinite;
 -webkit-animation: example1 15s linear infinite;
 animation: example1 15s linear infinite;
}
/* Move it (define the animation) */
@-moz-keyframes example1 {
 0%   { -moz-transform: translateX(100%); }
 100% { -moz-transform: translateX(-100%); }
}
@-webkit-keyframes example1 {
 0%   { -webkit-transform: translateX(100%); }
 100% { -webkit-transform: translateX(-100%); }
}
@keyframes example1 {
 0%   { 
 -moz-transform: translateX(100%); /* Firefox bug fix */
 -webkit-transform: translateX(100%); /* Firefox bug fix */
 transform: translateX(100%);       
 }
 100% { 
 -moz-transform: translateX(-100%); /* Firefox bug fix */
 -webkit-transform: translateX(-100%); /* Firefox bug fix */
 transform: translateX(-100%); 
 }
}
</style>

<style>
/* Style the buttons */
.btn1 {
  border: none;
  outline: none;
  padding: 10px 16px;
  background-color: #f1f1f1;
  cursor: pointer;
  font-size: 18px;
}

/* Style the active class, and buttons on mouse-over */
.active, .btn:hover {
  background-color: #666;
  color: white;
}

.preview-button{
    display: none;
}
</style>

<div class="main_div">
<button type="button" preview="video" class="preview-button btn btn-primary">Video Preview</button>
<button type="button" preview="image" class="btn preview-button btn-success">Images Preview</button>
<button type="button" preview="html" class="btn preview-button btn-danger">Html Preview</button>
<button type="button" preview="marquee" class="btn preview-button btn-warning">Marquee Preview</button>
<button id="preview" preview="all" type="button" class="preview-button btn btn-secondary">Preview All</button>

<div class="inner_div">
    <?php $playlists = isset($playlist->playlist) && !empty(unserialize($playlist->playlist)) ? unserialize($playlist->playlist) : array();
            if(!empty($playlists)){ $i = 0;
                // foreach ($playlists as $skey => $svalue) {

                //  $i++;

                //  echo "<textarea class='playlist-item'>"; 
                //     echo json_encode( $svalue);
                //        echo "</textarea>"; 
                //        }
                   

$i = 0;
echo "<script>";
echo "var playlistItems=[";
                 foreach ($playlists as $skey => $svalue) {
                 $i++;
                    echo json_encode( $svalue);
                      echo ",";
                       }

echo "];";
                       echo "</script>";

                   }  

    ?>  



</div>

<div class="row" id="mainParent" style="display: none; min-height: 300px; background-color: #fff; border: solid 1px #000; ">
    <div id="htmlContainer" style="display: none; height: 100%">
    </div>

    <div id="marqueeContainer" class="example1" style="display: none; color: #fff; min-height: 300px;  height: 100%">
        <div id="marqueeContainerData">
        </div>
    </div>

    
    <img style="display: none; height: 100%" id="imageContainer">
<video loop  height="300" width="auto" style="display: none;height: 400px" id="videoclip"  poster="images/cover.jpg" title="Video title">
  <source id="videosource" src="media/video.mp4" type="video/mp4"  />
 </video>
</div>


</div>

<script>

    $(document).ready(function(){
       
        function nextItem (){
            currentItemIndex++;
            showItem();  
        }

        function waitForTimeout(){
           var duration = currentItem.tis * 1000;
            console.log("will wait for " + duration);

            if (currentItem.type == "marquee" || currentItem.type == 'html' || currentItem.type == 'video' || currentItem.type == 'image') {
                //dummy timeout
               // duration = 10 * 1000;
                duration;
            }

            setTimeout(function(){
                 $("#videoclip").get(0).pause();
                 nextItem();
            }, duration);  
        }

        $("#imageContainer").load(function(){
             waitForTimeout();
        });

        //  $("#htmlContainer").load(function(){
        //     console.log("html loaded");
        //     waitForTimeout();
        // });

        var videoUrlChanged = false;
         
        $("#videoclip").get(0).onplaying  = function() {
            console.log("Start Playing " + videoUrlChanged);
            if (videoUrlChanged) { 
                videoUrlChanged = false;
                waitForTimeout();
            }
        };

        var currentItemIndex = 0;
        
        // $("#preview").click(function(){
        //     currentItemIndex = 0;
        //     $( '#mainParent' ).show();
        //     showItem();
        // });

        var showingType = undefined;

        $(".preview-button").click(function(){
            var type = $(this).attr('preview');
            console.log(type);
            showingType = type;
            currentItemIndex = 0;

            if (type != 'all'){
              currentItemIndex = -1;

              var i = 0;

              for(i = 0; i<playlistItems.length; i++){
                var dx = playlistItems[i];
                if (dx.type == type) {
                   currentItemIndex = i; 
                   break;
                } 
              }
            }

            if (currentItemIndex > -1){
                 $( '#mainParent' ).show();
                showItem();
            }
            else {
                 $( '#mainParent' ).hide();
                alert("Not Present");
            }


        });

        var currentItem = undefined;
        var container= undefined;
        var lastItem= undefined;

        function showMarquee() {
            container = $("#marqueeContainer");
            container.show();
            $("#marqueeContainerData").html(currentItem.content_text);
            waitForTimeout();
        }

        function showHtml(){
            container = $("#htmlContainer");
            container.show();
            container.html(currentItem.content_text);
            waitForTimeout();
        }

        function showImage(){
            container = $("#imageContainer");
            container.show();
            var imageUrl = currentItem.video;
           // imageUrl = 'https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png';
            container.attr('src', imageUrl);
        }

        function showVideo (){
            container = $("#videoclip");
            var videoUrl = currentItem.video;

            videoUrl ='http://mirrors.standaloneinstaller.com/video-sample/grb_2.m4v';
            videoUrlChanged = true;
            $("#videoclip").show(); 
            $("#videoclip").get(0).pause();
            $('#videosource').attr('src', videoUrl);
            $("#videoclip").get(0).load();
            $("#videoclip").get(0).play();
        }

        function endPreview(){
            container.hide();  
            $( '#mainParent' ).hide();
            lastItem = undefined;
            $(".preview-button").attr('disabled', false);
            alert("Done with preview");  
        }

        function showItem(){
            console.log("Shwing item " + currentItemIndex);
            currentItem =  playlistItems[currentItemIndex];

            $(".preview-button").attr('disabled', true);
            

            if (currentItem === undefined){
              if (lastItem !== undefined){
                endPreview();
                return;
              }  
            }

            if (lastItem !== undefined){
                if (lastItem.type != currentItem.type){
                   container.hide();  

                   if (showingType !== 'all') {
                     endPreview();
                     return;
                   }
                }
            }

            lastItem = currentItem;
            console.log(currentItem);

            $( '#mainParent' ).css( "background-color", currentItem.bc );

            switch(currentItem.type){
                case "video":
                // 
                showVideo();
                break;

                case "image": 
                showImage();
                break;

                case "html":
                showHtml();
                break;

                case "marquee":
                showMarquee();
                break;
            }
        }


        $('.playlist-item').hide();

        // var playlist = [];

        // $( ".playlist-item" ).each(function( index ) {
        //     //playlist.push(JSON.parse($( this ).text()));
        //     var item = $( this ).text();
        //     console.log( index + ' ' + item );
        // });

        // console.log("Convert");

        console.log(playlistItems);
        $(".preview-button").hide();

        var plVideos = [];
        var plHtml = [];
        var plImage = [];
        var plMarquee = [];

       $(playlistItems).each(function(item){
            switch(this.type){
                case "video":
                plVideos.push(this);
                break;

                  case "html":
                plHtml.push(this);
                break;

                case "image":
                plImage.push(this);
                break;


                case "marquee":
                plMarquee.push(this);
                break;

                default:
                console.log(this);

                break;
            }
        });  

        playlistItems= plVideos.concat(plImage, plHtml, plMarquee);
       
        console.log(playlistItems);

        if (plVideos.length > 0) $(".preview-button[preview|='video']").show();
        if (plHtml.length > 0) $(".preview-button[preview|='html']").show();
        if (plImage.length > 0) $(".preview-button[preview|='image']").show();
        if (plMarquee.length > 0) $(".preview-button[preview|='marquee']").show();
        
        if ($('.preview-button:visible').length > 1){
             $(".preview-button[preview|='all']").show();
        }

        //    $( ".playlist-item" ).each(function( index ) {
        //     playlist.push(JSON.parse($( this ).text()));
        //     //var item = $( this ).text();
        //     //console.log( index + ' ' + item );
        // });

        
    });

  var divs = ["Video", "Image", "Html", "Marquee"];
    var visibleDivId = null;
    function divVisibility(divId) {
      if(visibleDivId === divId) {
        visibleDivId = null;
      } else {
        visibleDivId = divId;
      }
      hideNonVisibleDivs();
    }
    function hideNonVisibleDivs() {
      var i, divId, div;
      for(i = 0; i < divs.length; i++) {
        divId = divs[i];
        div = document.getElementById(divId);
        if(visibleDivId === divId) {
          div.style.display = "block";
        } else {
          div.style.display = "none";
        }
      }
    }
</script>
 
<script src="<?php echo base_url('template/admin') ?>/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/pdfmake/build/vfs_fonts.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/switchery/dist/switchery.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/parsleyjs/dist/parsley.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/moment/min/moment.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
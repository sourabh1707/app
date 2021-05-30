<style> .tile_count .tile_stats_count .count { font-size: 25px; }</style>
<div class="" role="tabpanel" data-example-id="togglable-tabs">
    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#vmd" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true"><?php echo translate('VMD'); ?></a>
        </li>
        <li role="presentation" class="">
            <a href="#bill_board" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><?php echo translate('bill_board'); ?></a>
        </li>
        <li role="presentation" class="">
            <a href="#door_status" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><?php echo translate('door_status'); ?></a>
        </li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div role="tabpanel" class="tab-pane fade active in" id="vmd" aria-labelledby="vmd-tab">
            <div class="row tile_count">
                <?php if(isset($terminals) && !empty($terminals)){ ?>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <?php foreach($terminals as $tkey => $tvalue){ ?>
                            <div class="col-md-3 col-sm-3 col-xs-12 tile_stats_count">
                                <span class="count_top status_terminal_<?php echo $tvalue->id; ?>"><i class="fa fa-terminal"></i> <?php echo $tvalue->name; ?></span>
                                <div class="count status_name_<?php echo $tvalue->id; ?>"><?php echo $tvalue->client_alise; ?></div>
                                <span class="count_bottom status_<?php echo $tvalue->id; ?>"><i class="aero">Waiting for Status</i></span>
                               <!--  <span class="count_bottom door_status_<?php echo $tvalue->id; ?>"><i class="aero">Waiting for Status</i></span> -->
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="bill_board" aria-labelledby="bill_board-tab">
            <div class="row tile_count">
                <?php if(isset($boards) && !empty($boards)){ ?>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <?php foreach($boards as $tkey => $tvalue){ ?>
                            <div class="col-md-3 col-sm-3 col-xs-12 tile_stats_count">
                                <span class="count_top status_terminal_<?php echo $tvalue->id; ?>"><i class="fa fa-terminal"></i> <?php echo $tvalue->name; ?></span>
                                <div class="count status_name_<?php echo $tvalue->id; ?>"><?php echo $tvalue->client_alise; ?></div>
                                <span class="count_bottom status_<?php echo $tvalue->id; ?>"><i class="aero">Waiting for Status</i></span>
                                <!--  <span class="count_bottom door_status_<?php echo $tvalue->id; ?>"><i class="aero">Waiting for Status</i></span> -->
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="door_status" aria-labelledby="door_status-tab">
            <div class="row tile_count">
                <?php if(isset($terminals) && !empty($terminals)){ ?>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <?php foreach($terminals as $tkey => $tvalue){ ?>
                            <div class="col-md-3 col-sm-3 col-xs-12 tile_stats_count">
                                <span class="count_top status_terminal_<?php echo $tvalue->id; ?>"><i class="fa fa-terminal"></i> <?php echo $tvalue->name; ?></span>
                                <div class="count status_name_<?php echo $tvalue->id; ?>"><?php echo $tvalue->client_alise; ?></div>
                                <!-- <span class="count_bottom status_<?php echo $tvalue->id; ?>"><i class="aero">Waiting for Status</i></span> -->
                                  <span class="count_bottom door_status_<?php echo $tvalue->id; ?>"><i class="aero">Waiting for Status</i></span>  
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>

    </div>
</div>


<?php if(isset($terminals) && !empty($terminals)){ ?>
    <script>
        $(document).ready(function () {
            <?php foreach($terminals as $tkey => $tvalue){ ?>
                function tstatus<?php echo $tvalue->id; ?>(id, name){
                    $.post("<?php echo site_url('dashboard/get_status'); ?>", {terminal_id: name}, function(details){
                        if(details.status==200){
                            $(".status_terminal_<?php echo $tvalue->id; ?>").removeClass("red");
                            $(".status_name_<?php echo $tvalue->id; ?>").removeClass("red");

                            $(".status_terminal_<?php echo $tvalue->id; ?>").addClass("green");
                            $(".status_name_<?php echo $tvalue->id; ?>").addClass("green");
                            $(".status_<?php echo $tvalue->id; ?>").html('<i class="green">Online</i>');
                        }
                        else{
                            $(".status__terminal_<?php echo $tvalue->id; ?>").removeClass("green");
                            $(".status_name_<?php echo $tvalue->id; ?>").removeClass("green");

                            $(".status_terminal_<?php echo $tvalue->id; ?>").addClass("red");
                            $(".status_name_<?php echo $tvalue->id; ?>").addClass("red");
                            $(".status_<?php echo $tvalue->id; ?>").html('<i class="red">Offline</i>');
                        }
                    });
                    $.post("<?php echo site_url('dashboard/get_door_status'); ?>", {terminal_id: name}, function(details){ 
                        if(details.status==201){
                            $(".door_status_<?php echo $tvalue->id; ?>").html('<i class="red">Open</i>');
                        }
                        else if(details.status==202){
                            $(".door_status_<?php echo $tvalue->id; ?>").html('<i class="green">Close</i>');
                        }else {
                            $(".door_status_<?php echo $tvalue->id; ?>").html('<i class="red">Unknown</i>');
                        }
                    });
                }
                setTimeout(tstatus<?php echo $tvalue->id; ?>(<?php echo $tvalue->id; ?>, "<?php echo $tvalue->name; ?>"),10000);
            <?php } ?>
        });
    </script>
<?php } ?>
<?php if(isset($boards) && !empty($boards)){ ?>
    <script>
        $(document).ready(function () {
            <?php foreach($boards as $tkey => $tvalue){ ?>
                function tstatus<?php echo $tvalue->id; ?>(id, name){
                    $.post("<?php echo site_url('dashboard/get_status'); ?>", {terminal_id: name}, function(details){
                        if(details.status==200){
                            $(".status_terminal_<?php echo $tvalue->id; ?>").removeClass("red");
                            $(".status_name_<?php echo $tvalue->id; ?>").removeClass("red");

                            $(".status_terminal_<?php echo $tvalue->id; ?>").addClass("green");
                            $(".status_name_<?php echo $tvalue->id; ?>").addClass("green");
                            $(".status_<?php echo $tvalue->id; ?>").html('<i class="green">Online</i>');
                         }
                        else{
                            $(".status__terminal_<?php echo $tvalue->id; ?>").removeClass("green");
                            $(".status_name_<?php echo $tvalue->id; ?>").removeClass("green");

                            $(".status_terminal_<?php echo $tvalue->id; ?>").addClass("red");
                            $(".status_name_<?php echo $tvalue->id; ?>").addClass("red");
                            $(".status_<?php echo $tvalue->id; ?>").html('<i class="red">Offline</i>');
                        }
                    });

                    // $.post("<?php echo site_url('dashboard/get_door_status'); ?>", {terminal_id: name}, function(details){
                    //     if(details.status==200){
                    //         $(".door_status_<?php echo $tvalue->id; ?>").html('<i class="green">Closed</i>');
                    //      }
                    //     else{
                    //         $(".door_status_<?php echo $tvalue->id; ?>").html('<i class="red">Opened</i>');
                    //     }
                    // });
                    // setTimeout(tstatus<?php echo $tvalue->id; ?>(<?php echo $tvalue->id; ?>, "<?php echo $tvalue->name; ?>"),5000);
                }
                setTimeout(tstatus<?php echo $tvalue->id; ?>(<?php echo $tvalue->id; ?>, "<?php echo $tvalue->name; ?>"),10000);
            <?php } ?>
        });
    </script>
<?php } ?>

<?php if(isset($terminals) && !empty($terminals)){ ?>
    <script>
        $(document).ready(function () {
            <?php foreach($terminals as $tkey => $tvalue){ ?>
                function tstatus<?php echo $tvalue->id; ?>(id, name){
                    $.post("<?php echo site_url('dashboard/get_door_status'); ?>", {terminal_id: name}, function(details){ 
                        if(details.status==201){
                            $(".door_status_<?php echo $tvalue->id; ?>").html('<i class="green">Open</i>');
                        }
                        else if(details.status==202){
                            $(".door_status_<?php echo $tvalue->id; ?>").html('<i class="red">Close</i>');
                        }else {
                            $(".door_status_<?php echo $tvalue->id; ?>").html('<i class="red">Unknown</i>');
                        }
                    });
                }
                setTimeout(tstatus<?php echo $tvalue->id; ?>(<?php echo $tvalue->id; ?>, "<?php echo $tvalue->name; ?>"),10000);
            <?php } ?>
        });
    </script>
<?php } ?>



<style> .tile_count .tile_stats_count .count { font-size: 25px; }</style>
<div class="row tile_count">
    <?php if(isset($terminals) && !empty($terminals)){ ?>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <?php foreach($terminals as $tkey => $tvalue){ ?>
                <div class="col-md-6 col-sm-6 col-xs-12 tile_stats_count">
                    <span class="count_top status_terminal_<?php echo $tvalue->id; ?>"><i class="fa fa-terminal"></i> <?php echo $tvalue->name; ?></span>
                    <div class="count status_name_<?php echo $tvalue->id; ?>"><?php echo $tvalue->client_alise; ?></div>
                    <span class="count_bottom status_<?php echo $tvalue->id; ?>"><i class="aero">Waiting for Status</i></span>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
    <?php if(isset($boards) && !empty($boards)){ ?>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <?php foreach($boards as $tkey => $tvalue){ ?>
                <div class="col-md-12 col-sm-12 col-xs-12 tile_stats_count">
                    <span class="count_top status_terminal_<?php echo $tvalue->id; ?>"><i class="fa fa-terminal"></i> <?php echo $tvalue->name; ?></span>
                    <div class="count status_name_<?php echo $tvalue->id; ?>"><?php echo $tvalue->client_alise; ?></div>
                    <span class="count_bottom status_<?php echo $tvalue->id; ?>"><i class="aero">Waiting for Status</i></span>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
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
                    //setTimeout(tstatus<?php echo $tvalue->id; ?>(<?php echo $tvalue->id; ?>, "<?php echo $tvalue->name; ?>"),5000);
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
                    //setTimeout(tstatus<?php echo $tvalue->id; ?>(<?php echo $tvalue->id; ?>, "<?php echo $tvalue->name; ?>"),5000);
                }
                setTimeout(tstatus<?php echo $tvalue->id; ?>(<?php echo $tvalue->id; ?>, "<?php echo $tvalue->name; ?>"),10000);
            <?php } ?>
        });
    </script>
<?php } ?>


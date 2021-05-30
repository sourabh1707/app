
<html>
    <head><?php echo $map['js']; ?></head>
    <body><?php echo $map['html']; ?></body>
</html>
<script type="text/javascript">
    setTimeout(function(){
        location.reload();
    },60000);
</script>
<br><br><br>
<style> .tile_count .tile_stats_count .count { font-size: 25px; }</style>
<div class="" role="tabpanel" data-example-id="togglable-tabs">
    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#vmd" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true"><?php echo translate('VMD'); ?></a>
        </li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div role="tabpanel" class="tab-pane fade active in" id="vmd" aria-labelledby="vmd-tab">
            <div class="row tile_count">
                <?php if(isset($terminals) && !empty($terminals)){ ?>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                  <tr>
                                    <th>Id</th>
                                    <th>Terminal Name</th>
                                    <th>Client Alise name</th>
                                    <th>Terminal Status </th>
                                  </tr>
                                </thead>
                                <tbody>
                                <?php $i=1; ?>
                                <?php foreach($terminals as $tkey => $tvalue){ ?>
                                    <tr>
                                        <td class="count_top status_terminal_<?php echo $tvalue->id; ?>">
                                            <?php echo $i; ?>
                                        </td>
                                        <td class="count_top status_terminal_<?php echo $tvalue->id; ?>">
                                            <i class="fa fa-terminal"></i> <?php echo $tvalue->name; ?>
                                        </td>
                                        <td class="count status_name_<?php echo $tvalue->id; ?>"> 
                                            <?php echo $tvalue->client_alise; ?>
                                        </td>
                                        <td class="count_bottom status_<?php echo $tvalue->id; ?>">
                                            <i class="aero">Waiting for Status</i>
                                        </td>
                                    </tr>                                   
                                <?php 
                                $i++;
                                } ?>  
                                </tbody>
                            </table>
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
                    $.post("<?php echo site_url('maper/get_statuss'); ?>", {terminal_id: name}, function(details){
                        if(details.status==200){
                            $(".status_terminal_<?php echo $tvalue->id; ?>").removeClass("red");
                            $(".status_name_<?php echo $tvalue->id; ?>").removeClass("red");
                            $(".status_terminal_<?php echo $tvalue->id; ?>").addClass("green");
                            $(".status_name_<?php echo $tvalue->id; ?>").addClass("green");
                            $(".status_<?php echo $tvalue->id; ?>").html('<i class="green">Online</i>');
                            // $(".door_status_<?php echo $tvalue->id; ?>").html('<i class="green">Door close</i>');
                         }
                        else{
                            $(".status__terminal_<?php echo $tvalue->id; ?>").removeClass("green");
                            $(".status_name_<?php echo $tvalue->id; ?>").removeClass("green");
                            $(".status_terminal_<?php echo $tvalue->id; ?>").addClass("red");
                            $(".status_name_<?php echo $tvalue->id; ?>").addClass("red");
                            $(".status_<?php echo $tvalue->id; ?>").html('<i class="red">Offline</i>');
                            // $(".door_status_<?php echo $tvalue->id; ?>").html('<i class="red">Door open</i>');
                         }
                    });
                }
                setTimeout(tstatus<?php echo $tvalue->id; ?>(<?php echo $tvalue->id; ?>, "<?php echo $tvalue->name; ?>"),10000);
            <?php } ?>
        });
    </script>
<?php } ?>

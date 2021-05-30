<link href="<?php echo base_url('template/admin') ?>/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
<style>
    table.dataTable thead .sorting:after,
table.dataTable thead .sorting:before,
table.dataTable thead .sorting_asc:after,
table.dataTable thead .sorting_asc:before,
table.dataTable thead .sorting_asc_disabled:after,
table.dataTable thead .sorting_asc_disabled:before,
table.dataTable thead .sorting_desc:after,
table.dataTable thead .sorting_desc:before,
table.dataTable thead .sorting_desc_disabled:after,
table.dataTable thead .sorting_desc_disabled:before {
bottom: .5em;
}
</style>
<div class="row">
        <div class="x_panel">
           
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">

    <table id="list" class="table table-striped table-bordered">
                          
        <thead>
            <tr>
                <th>#</th>
                <th>Terminal Name</th>
                <th>Status</th> 
                <th>Open Time</th>
                <th>Close Time</th> 
                <th>Duration</th>          
                <th>Operation</th>                           
               
            </tr>
        </thead>
        <tbody>
            <?php
             $user_id = $this->session->userdata('user_id');
             $playlist = $this->db->query("SELECT * FROM `tbl_alarm_log` WHERE created_by=$user_id");

          //$playlist = $this->db->query("SELECT b.name,a.schedulep_id FROM tbl_schedule_log a JOIN tbl_schedule b ON a.schedulep_id=b.id AND b.is_deleted !=1");
           
            $i = 1;
            if (isset($playlist) && !empty($playlist)) {
                foreach ($playlist->result() as $row) {
                    $id= $row->id;
                    $date1=strtotime($row->closetime);
                    $date2=strtotime($row->opentime);
                  //$hourdiff = round((strtotime($row->opentime) - strtotime($row->closetime))/3600, 1);
                   $delta_T = ($date1 - $date2);
                   //$hourdiff =  round(((($delta_T % 604800) % 86400) % 3600) / 60)."min".abs((((($delta_T % 604800) % 86400) % 3600) % 60))."sec";
                   

                   $hourdiff = round(($delta_T % 604800) / 86400)."days ".round((($delta_T % 604800) % 86400) / 3600)."hours ".round(((($delta_T % 604800) % 86400) % 3600) / 60)."min ".abs((((($delta_T % 604800) % 86400) % 3600) % 60))."sec";
                    ?>
                    <tr>
                    <td><?php echo $i++; ?></td> 
                    <td><?php echo $row->terminal_id?></td> 
                    <td><?php echo $row->status?></td>
                    <td><?php echo $row->opentime?></td> 
                    <td><?php echo $row->closetime?></td> 
                    <?php if($row->status==online){?>
                      <td>-</td>
                    <?php }else{?>
                    <td><?php echo $hourdiff?></td>   
                    <?php } ?>                      
                    <td><a href="<?php echo site_url("alarm_log/pdf/".$row->id);?>" type="button" target="_blank" class="btn btn-primary btn-sm" /><i class="fa fa-file-pdf-o"></i></a> </td>
                
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="5">There is no field.</td>    
                </tr>
            <?php } ?>

        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
</div>


<script>$(document).ready(function () {
$('#list').DataTable({
     "retrieve": true,
"scrollY": "400px",
"scrollCollapse": true,

});
$('.dataTables_length').addClass('bs-select');
});</script>

<script src="<?php echo base_url('template/admin') ?>/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/pdfmake/build/vfs_fonts.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/switchery/dist/switchery.min.js"></script>
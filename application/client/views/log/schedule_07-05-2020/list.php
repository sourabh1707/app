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

  <!--Schedule Playlist-->                
    <table id="list" class="table table-striped table-bordered">
                          
        <thead>
           <h3 style="color: black;">Playlist Schedule</h3>
            <tr>
                <th>#</th>
                <th>Playlist Name</th>
                <th>Playlist Status</th> 
                <th>Schedule On</th>
                <th>Schedule To</th>       
                <th>Operation</th>                           
               
            </tr>
        </thead>
        <tbody>
            <?php
             $user_id = $this->session->userdata('user_id');

              $playlist = $this->db->query("SELECT a.id,b.name,a.schedulep_id, b.schedule_on, b.schedule_to FROM `tbl_schedule_log` a, tbl_schedule b WHERE a.schedulep_id=b.id AND b.is_deleted !=1");

          //$playlist = $this->db->query("SELECT b.name,a.schedulep_id FROM tbl_schedule_log a JOIN tbl_schedule b ON a.schedulep_id=b.id AND b.is_deleted !=1");
           
            $i = 1;
            if (isset($playlist) && !empty($playlist)) {
                foreach ($playlist->result() as $row) {
                    $id= $row->id;
                    $sp_id = $row->schedulep_id;
                    ?>
                    <tr>
                       <td><?php echo $i++; ?></td> 
                         <td><input type="text" name="view" value="<?php echo $row->name;?>" id="<?php echo $sp_id; ?>" class="btn view_data" readonly/></td>
                        <td><?php echo isset($row->is_active) && $row->is_active!=1 ? translate('inactive') : translate('active'); ?></td> 
                       <!-- <td><?php echo $row->tid; ?></td> -->
                        <td><?php echo $row->schedule_on; ?></td>
                        <td><?php echo $row->schedule_to; ?></td>

        <td><a href="<?php echo site_url("schedule_log/pdf/".$row->id);?>" type="button" target="_blank" class="btn btn-primary btn-sm" /><i class="fa fa-file-pdf-o"></i></a> </td>
                   
            
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



<!--Schedule Layout-->
         <table id="list1" class="table table-striped table-bordered">
                          
        <thead>
          <h3 style="color: black;">Layout Schedule</h3>
            <tr>
                <th>#</th>
                <th>Playlist Name</th>
                <th>Playlist Status</th> 
                <th>Schedule On</th>
                <th>Schedule To</th>       
                <th>Operation</th>                           
               
            </tr>
        </thead>
        <tbody>
            <?php
             $user_id = $this->session->userdata('user_id');
              $playlist = $this->db->query("SELECT a.id,b.name,a.schedulel_id, b.schedule_on, b.schedule_to FROM `tbl_schedule_log` a, tbl_schedule_l b WHERE a.schedulel_id=b.id AND b.is_deleted !=1");

          //$playlist = $this->db->query("SELECT b.name,a.schedulep_id FROM tbl_schedule_log a JOIN tbl_schedule b ON a.schedulep_id=b.id AND b.is_deleted !=1");
           
            $i = 1;
            if (isset($playlist) && !empty($playlist)) {
                foreach ($playlist->result() as $row) {
                    $id= $row->id;
                    $sl_id = $row->schedulel_id;

                    ?>
                    <tr>
                       <td><?php echo $i++; ?></td> 
                       <td><input type="text" name="view" value="<?php echo $row->name;?>" id="<?php echo $sl_id; ?>" class="btn view_data1" readonly/></td>
                        <td><?php echo isset($row->is_active) && $row->is_active!=1 ? translate('inactive') : translate('active'); ?></td> 
                       <!-- <td><?php echo $row->tid; ?></td> -->
                        <td><?php echo $row->schedule_on; ?></td>
                        <td><?php echo $row->schedule_to; ?></td>

        <td><a href="<?php echo site_url("schedule_log/pdf/".$row->id);?>" type="button" target="_blank" class="btn btn-primary btn-sm" /><i class="fa fa-file-pdf-o"></i></a> </td>
                   
            
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

<!--Playlist Schedule-->
<div id="dataModal" class="modal fade">  
      <div class="modal-dialog">  
<div class="modal-content" style="width: 880px;">           
    <div class="modal-header" style="color: black;">  
                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
                     <h4 class="modal-title">Playlist Details</h4>  
                </div>  
                <div class="modal-body" id="terminal_detail"> 
                </div>  
                <div class="modal-footer">  
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                </div>  
           </div>  
      </div>  
 </div>

<script>  
 $(document).ready(function(){  
      $('.view_data').click(function(){  
           var id = $(this).attr("id");  
           $.ajax({  
                url:"<?php echo base_url(); ?>Schedule_log/get_playlist_details",  
                method:"post",  
                data:{id:id},  
                success:function(data){  
                     $('#terminal_detail').html(data);  
                     $('#dataModal').modal("show");  
                }  
           });  
      });  
 });  
 </script>


<!--Layout Schedule-->

<div id="dataModal1" class="modal fade">  
      <div class="modal-dialog">  
<div class="modal-content" style="width: 880px;">           
    <div class="modal-header" style="color: black;">  
                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
                     <h4 class="modal-title">Playlist Details</h4>  
                </div>  
                <div class="modal-body" id="terminal_detail1"> 
                </div>  
                <div class="modal-footer">  
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                </div>  
           </div>  
      </div>  
 </div>

<script>  
 $(document).ready(function(){  
      $('.view_data1').click(function(){  
           var id = $(this).attr("id"); 
        //  alert(id); 
           $.ajax({  
                url:"<?php echo base_url(); ?>Schedule_log/get_playlist_details1",  
                method:"post",  
                data:{id:id},  
                success:function(data){  
                     $('#terminal_detail1').html(data);  
                     $('#dataModal1').modal("show");  
                }  
           });  
      });  
 });  
 </script>


<script>$(document).ready(function () {
$('#list').DataTable({
     "retrieve": true,
"scrollY": "200px",
"scrollCollapse": true,

});
$('.dataTables_length').addClass('bs-select');
});</script>

<script>$(document).ready(function () {
$('#list1').DataTable({
     "retrieve": true,
"scrollY": "200px",
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
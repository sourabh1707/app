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
                <th>Playlist Name</th>
                <th>Terminal Name</th>
                <th>Close T1</th> 
                <th>Open T2</th> 
                <th>Time Status</th>
                <th>schedule_to T1</th> 
                <th>schedule_on T2</th>
                <th>Time</th>    
                <th>Operation</th>                           
               
            </tr>
        </thead>
        <tbody>
            <?php
             $i = 1;
             $user_id = $this->session->userdata('user_id');
             $terminal = $this->db->query("SELECT t2.id, t2.name,t1.opentime, t1.closetime, t1.status, t1.id as tid FROM tbl_status_log t1 JOIN tbl_terminal t2 ON t1.terminal_id = t2.name AND t1.created_by=$user_id");
              foreach ($terminal->result() as $row) {
                      $ter_id=$row->id;
                      $name=$row->name;
                      $date1=$row->closetime;
                      $date2=$row->opentime;
                      $status=$row->status;
                      $tid=$row->tid;
                     
                   $delta_T = ($date1 - $date2);

                   // $hourdiff = round((strtotime($date1) - strtotime($date2)));
                  // $hourdiff = round(abs((($delta_T % 604800) % 86400)) / 3600).":".round(abs(((($delta_T % 604800) % 86400) % 3600)) / 60).":".abs((((($delta_T % 604800) % 86400) % 3600) % 60));

                   $hourdiff = floor(($delta_T % 604800) / 86400).":".floor((($delta_T % 604800) % 86400) / 3600).":".floor(((($delta_T % 604800) % 86400) % 3600) / 60).":".floor((((($delta_T % 604800) % 86400) % 3600) % 60));
          
    // print_r($hourdiff);  exit();
             $playlist = $this->db->query("SELECT t2.id, t2.name, t2.is_active, t1.duration, t1.id as tid, t2.is_delete,t1.schedule_on,t1.schedule_to FROM tbl_playlist_log t1 JOIN tbl_playlist t2 ON t2.id = t1.playlist_id AND t1.created_by=$user_id AND t1.terminal_id=$ter_id");

             //echo "SELECT t2.id, t2.name, t2.is_active, t1.duration, t1.id as tid, t2.is_delete FROM tbl_playlist_log t1 JOIN tbl_playlist t2 ON t2.id = t1.playlist_id AND t1.created_by=$user_id AND t1.terminal_id=$ter_id";
             foreach ($playlist->result() as $row1) {
                      $playlist_name=$row1->name;
                      $date3=$row1->schedule_to;
                      $date4=$row1->schedule_on;

                      $delta_T1 = abs($date3 - $date4);
                     
                  //$hourdiff = round((strtotime($row->opentime) - strtotime($row->closetime))/3600, 1);
                 //  $delta_T = ($date1 - $date2);
                  // $hourdiff1 = round(abs((($delta_T % 604800) % 86400)) / 3600).":".round(abs(((($delta_T % 604800) % 86400) % 3600)) / 60).":".abs((((($delta_T % 604800) % 86400) % 3600) % 60));

                 // $hourdiff1 = round((strtotime($date3) - strtotime($date4))/3600, 1);


                   $hourdiff1 = floor(($delta_T1 % 604800) / 86400).":".floor((($delta_T1 % 604800) % 86400) / 3600).":".floor(((($delta_T1 % 604800) % 86400) % 3600) / 60).":".floor((((($delta_T1 % 604800) % 86400) % 3600) % 60));

                  // print_r($hourdiff); 
                  // print_r($hourdiff1); exit();

                  $duration=$hourdiff1-$hourdiff;
                  $hourdiff2 = floor((((($hourdiff1 % 604800) % 86400) % 3600) % 60))-floor((((($hourdiff % 604800) % 86400) % 3600) % 60));;
                  // print_r($duration); exit();
          }   
            ?>
                    <tr> 
                    <td><?php echo $i++; ?></td>
                    <td><input type="text" name="view" value="<?php echo $playlist_name;?>" id="<?php echo $row1->id; ?>" class="btn view_data" readonly/></td> 
                    <td><?php echo $name?></td>
                    <td><?php echo $date1?></td>
                   <td><?php echo $date2?></td>
                   <td><?php echo $hourdiff?></td>
                   <td><?php echo $date3?></td>
                   <td><?php echo $date4?></td>
                    <td><?php echo $hourdiff2?></td> 
                    <td><a href="<?php echo site_url("billing_log/pdf/".$tid);?>" type="button" target="_blank" class="btn btn-primary btn-sm" /><i class="fa fa-file-pdf-o"></i></a> </td>
                
                    </tr>
                  <?php }  ?>
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
           //alert(id);
           $.ajax({  
                url:"<?php echo base_url(); ?>billing_log/get_playlist_details",  
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
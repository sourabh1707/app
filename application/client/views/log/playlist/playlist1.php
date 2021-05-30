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
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
           
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    
    <table id="list" class="table table-striped table-bordered">
                          
        <thead>
            <tr>
                <th>#</th>
                <th>Playlist Name</th>
                <th>Playlist Status</th> 
               <!-- <th>Table ID/th> -->
                <th>Duration(Hours)</th>   
                <th>Terminal List</th>                           
               
            </tr>
        </thead>
        <tbody>
            <?php
             $user_id = $this->session->userdata('user_id');
            // echo $user_id;

           /*  $this->db->where('user_id',$user_id);
       $playlist=$this->db->select('name')
             ->from('tbl_playlist')
             ->get()
             ->result();
             */

          
          $playlist = $this->db->query("SELECT t2.id, t2.name, t2.is_active, t1.duration, t1.id as tid, t2.is_delete FROM tbl_playlist_log t1 JOIN tbl_playlist t2 ON t2.id = t1.playlist_id AND t1.created_by=$user_id");
             //$playlist = $this->db->query("SELECT DISTINCT(t2.id), t2.name, SUM(t1.duration) as duration, t1.id as tid, t2.is_delete FROM tbl_playlist_log t1 JOIN tbl_playlist t2 ON t2.id = t1.playlist_id AND t1.created_by=1 AND t2.is_delete !=1 GROUP BY t2.id");

            // echo "SELECT DISTINCT(t2.id), t2.name, t1.duration,  t1.id as tid, t2.is_delete FROM tbl_playlist_log t1 JOIN tbl_playlist t2 ON t2.id = t1.playlist_id AND t1.created_by=$user_id AND t2.is_delete !=1";

           //  $playlist = $this->db->query("SELECT DISTINCT(b.id),b.name, a.`created_by` FROM `tbl_playlist_log` a,`tbl_playlist` b WHERE a.`playlist_id` = b.id AND a.`created_by`=$user_id");

            $i = 1;
            if (isset($playlist) && !empty($playlist)) {
                foreach ($playlist->result() as $row) {
                    $id= $row->id;
                    ?>
                    <tr>
                       <td><?php echo $i++; ?></td> 
                       <td><input type="text" name="view" value="<?php echo $row->name;?>" id="<?php echo $id; ?>" class="btn view_data" readonly/></td>
                        <td><?php echo isset($row->is_active) && $row->is_active!=1 ? translate('inactive') : translate('active'); ?></td> 
                       <!-- <td><?php echo $row->tid; ?></td> -->
                        <td><?php echo $row->duration; ?></td>

            <!--  <td><a href="<?php echo site_url()?>billing/terminal_list/<?php echo $row->id?>" class="btn btn-info">Terminal</a> </td> -->

           <td>

           <!-- <a href="<?php echo site_url()?>billing/terminal_list/<?php echo $row->id?>" class="btn btn-primary"><i class="fa fa-eye"></i></a>-->
            <a href="<?php echo site_url()?>playlist_log/terminal_list/<?php echo $row->id."/".$row->tid?>" class="btn btn-info btn-sm">Terminal</a> 
            

            <!--<a href="<?php echo site_url()?>billing/terminal_list/<?php echo $row->id."/".$row->tid?>" class="btn btn-info">Terminal</a> 
            -->
                  
             </td>
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
</div>



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
                url:"<?php echo base_url(); ?>playlist_log/get_playlist_details",  
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
<link href="<?php echo base_url('template/admin') ?>/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
<!--
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
-->

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel"> 
          <div class="x_content">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <table class="table table-hover tablesorter table-bordered table-striped">          
              <thead>
                  <tr>
                      <th class="header">#</th>
                      <th class="header">Terminal Name</th> 
                      <th class="header">Operation</th>       
                                        
                     
                  </tr>
              </thead>
              <tbody>
            <?php
             $user_id = $this->session->userdata('admin_id');
            $pid = $this->uri->segment(3);

           $tid = $this->uri->segment(4);
           // print_r($tid);exit();

             $tt1=$this->db->query("SELECT a.`groupt_id` FROM `tbl_admin_playlist_log` a,`tbl_playlist` b, `tbl_group_terminal` c WHERE a.`playlist_id` = b.id AND a.`created_by`=$user_id AND a.groupt_id =c.id AND a.`playlist_id`=$pid AND a.id=$tid");

           //  echo "SELECT a.`groupt_id` FROM `tbl_admin_playlist_log` a,`tbl_playlist` b, `tbl_group_terminal` c WHERE a.`playlist_id` = b.id AND a.`created_by`=1 AND a.groupt_id =c.id AND a.`playlist_id`=$pid AND a.id=$tid";
          
          $i = 1;
          foreach ($tt1->result() as $row) {  
           // print_r($row); exit();
              $pp=$row->groupt_id;
              $pp1=explode(",",$pp);
              $pp2 = implode(',', $pp1);  
     }
        $playlist = $this->db->query("SELECT id as groupt_id FROM `tbl_group_terminal` WHERE id IN($pp2)"); 

        $playlist2 = $this->db->query("SELECT a.`terminal_id` FROM `tbl_admin_playlist_log` a,`tbl_playlist` b, `tbl_terminal` c WHERE a.`playlist_id` = b.id AND a.`created_by`=$user_id AND a.terminal_id =c.id AND a.`playlist_id`=$pid AND a.id=$tid");

         $playlist4 = $this->db->query("SELECT a.id as tid, a.terminal_id, a.groupt_id FROM `tbl_admin_playlist_log` a WHERE a.`playlist_id`=$pid AND a.id=$tid AND a.terminal_id=0 AND a.`created_by`=$user_id AND a.groupt_id=0");
     // echo "SELECT id as groupt_id FROM `tbl_group_terminal` WHERE id IN($pp2)";
      //exit();  
        if (isset($playlist) && !empty($playlist) && $playlist != NULL) {
        foreach ($playlist->result() as $terminal) {

              $grp_terminal=$terminal->groupt_id; 
              $terminal =  $terminal->terminal_id;
    
$playlist1 = $this->db->query("SELECT a.id as tid,c.name, c.id as gid FROM `tbl_admin_playlist_log` a, `tbl_group_terminal` c WHERE a.`playlist_id`=$pid AND a.id=$tid AND c.id IN($grp_terminal) AND a.`created_by`=$user_id"); 

 //echo "SELECT a.id as tid, b.id,c.name, c.id, a.`groupt_id` FROM `tbl_admin_playlist_log` a,`tbl_playlist` b, `tbl_group_terminal` c WHERE a.`playlist_id` = b.id AND a.`created_by`=$user_id AND a.groupt_id =c.id AND b.is_delete !=1 AND a.`playlist_id`=$pid AND a.groupt_id IN($grp_terminal) AND a.id=$tid";
//echo "SELECT a.id as tid,c.name, c.id as gid FROM `tbl_admin_playlist_log` a, `tbl_group_terminal` c WHERE a.`created_by`=1 AND a.`playlist_id`=$pid AND a.id=$tid AND c.id IN($grp_terminal) AND a.`created_by`=$user_id";
                    foreach ($playlist1->result() as $terminal1){
   //print_r($terminal1); exit();
                        $name=$terminal1->name;
                        $id=$terminal1->gid;
                    ?>
                    <tr>
                       <td><?php echo $i++; ?></td> 

                       <!--<td><button id="myBtn" name="view" class="btn btn-info btn-xs view_data"><?php echo $name;?></button> -->
                   <td><input type="button" name="view" value="<?php echo $name;?>" id="<?php echo $id; ?>" class="btn btn-info btn-xs view_data" /></td>

                        </td>

                        <td><a href="<?php echo site_url("admin_playlist_log/pdf/".$terminal1->tid."/$id");?>" type="button" target="_blank" class="btn btn-primary" /><i class="fa fa-file-pdf-o"></i></a> </td>
                   
                    </tr>
                    <?php
     } }  }
     if (isset($playlist2) && !empty($playlist2)) {
          foreach ($playlist2->result() as $terminal2) {                    
          $terminal =  $terminal2->terminal_id;
          $playlist3 = $this->db->query("SELECT a.id as tid,c.name, c.id as gid FROM `tbl_admin_playlist_log` a, `tbl_terminal` c WHERE a.`playlist_id`=$pid AND a.id=$tid AND c.id =$terminal AND a.`created_by`=$user_id");

         foreach ($playlist3->result() as $terminal3){
                        $name=$terminal3->name;
                        $id=$terminal3->gid;     
                    ?>
                    <tr>
                       <td><?php echo $i++; ?></td> 
                   <td><input type="button" name="view" value="<?php echo $name;?>" id="<?php echo $id; ?>" class="btn btn-info btn-xs view_data1" /></td>
                        </td>
                        <td><a href="<?php echo site_url("admin_playlist_log/pdf/".$terminal3->tid."/$id");?>" type="button" target="_blank" class="btn btn-primary" /><i class="fa fa-file-pdf-o"></i></a> </td>
                    </tr>
                    <?php  // terminal=0 And Group Terminal=0     
     } }  }
      if (isset($playlist4) && !empty($playlist4)) {
          foreach ($playlist4->result() as $terminal4) {
         //   $id=$terminal4->terminal_id; 
          // echo $tt=$terminal4->tid; exit();?>                            
                    <tr>
                       <td><?php echo $i++; ?></td> 
                    <td>-</td>
                        <td><a href="<?php echo site_url("admin_playlist_log/pdf/".$tid);?>" type="button" target="_blank" class="btn btn-primary" /><i class="fa fa-file-pdf-o"></i></a> </td>        
                    </tr>
                    <?php       
      }  }else {
                ?>
                <tr>
                    <td colspan="5">There is no field.</td>    
                                    </tr>
            <?php }    ?>

        </tbody>
    </table>
                </div>
            </div>
        </div>
    </div>
</div>


 <div id="dataModal" class="modal fade">  
      <div class="modal-dialog">  
           <div class="modal-content">  
          <div class="modal-header" style="color: black;">  
                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
                     <h4 class="modal-title">Terminal Details</h4>  
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
                url:"<?php echo base_url(); ?>admin.php/admin_playlist_log/get_details",  
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

 <script>  
 $(document).ready(function(){  
      $('.view_data1').click(function(){  
           var id = $(this).attr("id");  
           $.ajax({  
                url:"<?php echo base_url(); ?>admin.php/admin_playlist_log/get_details1",  
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

<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
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

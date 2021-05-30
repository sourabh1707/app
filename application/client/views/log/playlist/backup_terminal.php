<link href="<?php echo base_url('template/admin') ?>/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
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
                                  
               
            </tr>
        </thead>
        <tbody>
            <?php
             $user_id = $this->session->userdata('user_id');

           /*  $this->db->where('is_delete', '1');
			 $playlist=$this->db->select('*')
             ->from('tbl_playlist')
             ->get()
             ->result();*/
             /*$tt=$this->db->query("SELECT * FROM `tbl_playlist`");
             foreach ($tt->result()as $value) {
                $pp =$value->id;
             }
*/
            $pid = $this->uri->segment(3);

             $tt1=$this->db->query("SELECT a.`groupt_id` FROM `tbl_activity_log` a,`tbl_playlist` b, `tbl_group_terminal` c WHERE a.`playlist_id` = b.id AND a.`created_by`=1 AND a.groupt_id =c.id AND b.is_delete !=1 AND a.`playlist_id`=$pid");
          
             foreach ($tt1->result() as $row) {
                //print_r($row->groupt_id);
                $pp1 = explode(', ', $row->groupt_id);
                $pp2 = implode(', ', $pp1);
             /*$id =array();
             $id = $pp2;
             */
            // print_r($pp2);
             //exit();

             }
        
           $playlist = $this->db->query("SELECT b.id, a.`groupt_id` FROM `tbl_activity_log` a,`tbl_playlist` b, `tbl_group_terminal` c WHERE a.`playlist_id` = b.id AND a.`created_by`=$user_id AND a.groupt_id =c.id AND b.is_delete !=1 AND a.`playlist_id`=$pid AND a.groupt_id IN($pp2)");
    
           //echo "SELECT b.id, a.`groupt_id` FROM `tbl_activity_log` a,`tbl_playlist` b, `tbl_group_terminal` c WHERE a.`playlist_id` = b.id AND a.`created_by`=$user_id AND a.groupt_id =c.id AND b.is_delete !=1 AND a.`playlist_id`=$pid AND a.groupt_id IN($pp2)";
     
          $i = 1;
            if (isset($playlist) && !empty($playlist)) {
                foreach ($playlist->result() as $terminal) {
                    $grp_terminal=$terminal->groupt_id;

                    $playlist1 = $this->db->query("SELECT b.id,c.name, a.`groupt_id` FROM `tbl_activity_log` a,`tbl_playlist` b, `tbl_group_terminal` c WHERE a.`playlist_id` = b.id AND a.`created_by`=$user_id AND a.groupt_id =c.id AND b.is_delete !=1 AND a.`playlist_id`=$pid AND a.groupt_id IN($grp_terminal)");

                    foreach ($playlist1->result() as $terminal1){
                    
                    //print_r($terminal->groupt_id);     
                  /* echo '<pre>';
                         print_r($terminal1);    
                         echo '</pre>';exit();
                    */
 
                    ?>
                    <tr>
                    	 <td><?php echo $i++; ?></td> 
                        <td><?php echo $terminal1->name; ?></td>
                        
                    </tr>
                    <?php
                
            }
        
           } } else {
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


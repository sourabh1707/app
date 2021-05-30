<link href="<?php echo base_url('template/admin') ?>/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

 <!-- Datatable Dependency start -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.js"></script>

    <!-- Datatable Dependency end -->

  <style>
  
        body {
            background-color: #F1F4F5;
        }
        
        .card-header {
            padding: 0.2rem 1.25rem;
            /* margin-bottom: 0; */
            background-color: #ffffff;
            border-bottom: 0px;
        }
        
        .card-body {
            padding: 0rem 1.25rem;
        }
        
        p {
            margin-top: 0;
            margin-bottom: 10px;
        }
        
        .card {
            border-radius: 0px;
            padding-top: 15px;
            padding-bottom: 15px;
        }
        
        .flex-wrap {
            margin-bottom: 5px;
        }
        
        div.dataTables_wrapper div.dataTables_paginate {
            margin-top: -25px;
        }
        
        .page-item.active .page-link {
            z-index: 1;
            color: #fff;
            background-color: #5D78FF;
            border-color: #5D78FF;
        }

</style>

  <div class="container-fluid">
    <div class="x_panel">
           <div class="x_content"> 

  <!-- Search filter -->
  <center>
   <form method='post' action='<?php echo site_url(); ?>Alarm_log/fetch_data'>
     Start Date <input type='date' class='dateFilter' name='fromDate' value="" required>
 
     End Date <input type='date' class='dateFilter' name='endDate' value="" required>

     <input type='submit' name='submit' value='Search' class="btn  btn-success btn-sm">
   

    <table class="table table-striped table-bordered" id="table_id">
      
            <?php
            $i = 1;


 if (isset($search_date) && !empty($search_date)) {
  ?>
  <thead>
        <tr>
                <th>#</th>
                <th>Terminal Name</th>
                <th>Online Count(IN Minutes)</th>
                <th>Offline Count(In Minutes)</th>          
         </tr>
      </thead>
       <tbody>
      <?php   

      
 //if($delta_T){
                foreach ($search_date as $key => $element) {
                    //print_r($element);die();
                  $id=$element['terminal_id'];
                  $online = $this->db->query("SELECT count(status) as ontt FROM `tbl_alarm_log` WHERE status='online' and terminal_id='$id'");
                  //echo $this->db->last_query();
          foreach ($online->result() as $row) {
                     $oncount= $row->ontt;
                    }

                    $offline = $this->db->query("SELECT count(status) as offtt FROM `tbl_alarm_log` WHERE status='offline' and terminal_id='$id'");
                  //echo $this->db->last_query();
          foreach ($offline->result() as $row) {
                     $offcount= $row->offtt;
                    }
                    ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $element['terminal_id']; ?></td> 
                        <td><?php echo $oncount; ?></td>
                        <td><?php echo $offcount; ?></td>
                       <!-- <td><?php echo $element['log_created_on'];
                            //echo $date_on=date("Y/m/d",strtotime($d1));
                         ?></td>-->
                    </tr>
                <?php } } ?>
        </tbody>
    </table>
  
  </div>
</div>
</div>

  
  <div id="dataModal" class="modal fade">  
      <div class="modal-dialog">  
<div class="modal-content" style="width: 880px;">           
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

$(document).ready(function() {
    $('#table_id').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                exportOptions: {
                   // columns: ':visible'
                   columns: [ 0, 1, 2, 3, ]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3 ]
                }
            },
           
        ]
    } );
} );
  </script>

  <script>  
 $(document).ready(function(){  
      $('.view_data').click(function(){  
           var id = $(this).attr("id");  
           $.ajax({  
                url:"<?php echo base_url(); ?>Playlist_log/get_playlist_details",  
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

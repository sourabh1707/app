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
           

  <!-- Search filter -->
  <center>
   <form method='post' action='<?php echo site_url(); ?>billing_log/fetch_data'>
     Start Date <input type='date' class='dateFilter' name='fromDate' value="" required>
 
     End Date <input type='date' class='dateFilter' name='endDate' value="" required>

     <input type='submit' name='submit' value='Search' class="btn  btn-success btn-sm
    <div class="x_content">

    <table class="table table-striped table-bordered" id="table_id">
      <thead>
        <tr>
          <th class="header">Sr. No.</th>
          <th class="header">Playlist Name</th>
          <th class="header">Playlist Status</th>
          <th class="header">Duration (Second)</th> 
          <th class="header">Terminal/ Group</th>
          <th class="header">Message</th>
          <th class="header">Date</th>
          <th class="header">Counter (Second)</th>
          <th class="header">Schedule On</th>
          <th class="header">Schedule To</th>
          <th class="header">Cal</th>
          <th class="header">Operation</th>
          <th class="header">Total Amount</th>
          

        </tr>
      </thead>
       <tbody>
            <?php

             $user_id = $this->session->userdata('user_id');
             $billing = $this->db->query("SELECT * FROM `tbl_billing_log` WHERE created_by=$user_id");

            $i = 1;

            if (isset($employeeInfo) && !empty($employeeInfo)) {
                foreach ($employeeInfo as $key => $element) {
                    //print_r($element);die();
                  //print_r($element['playlist']);die();

                    //message
                    $logs=unserialize($element['message']);
                          foreach ($logs as $key => $value) { 
                          

                          switch ($value) {
                          case '0' : $rvalue = 'Success';break;
                          case '1' : $rvalue = 'Fail';break;
                          default : $rvalue = $value;break;
                            }
                       }

                     $playlist_time=unserialize($element['playlist']);
                          foreach ($playlist_time as $key => $value) { 
                           // print_r(count($value)); exit();
                       }  

                    ?>
                    <?php if($rvalue=='send_successfully' || $rvalue=='single_schedule_successfully' || $rvalue=='schedule_successfully'){ ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $element['name']; ?></td>
                        <!--<td><input type="text" name="view" value="<?php echo $element['name'];?>" id="<?php echo $element['playlist_id']; ?>" class="btn btn-link view_data" readonly/></td> -->
                        <td><?php echo isset($row->is_active) && $row->is_active!=1 ? translate('inactive') : translate('active'); ?></td> 
                        <td><?php echo $duartion=$element['duration']; ?></td> 
                         <td><?php if($element['terminal_id']){ echo $this->CRUD->get_data_row(TBL_TERMINAL,array('id'=>$element['terminal_id']))->name;
                         }else if($element['groupt_id']){ echo $this->CRUD->get_data_row(TBL_GROUP_TERMINAL,array('id'=>$element['groupt_id']))->name; } ?></td> 
                         <td><?php echo translate($rvalue);?></td> 
                         
                         <td><?php  $d1=$element['log_created_on'];
                            echo $date_on=date("Y/m/d",strtotime($d1));
                         ?>
                         <input type="hidden" value="<?php echo $d1;?>">
                         </td>
                        

                          <td> <?php if($rvalue=='send_successfully'){ $datecount=$element['log_created_on'];
                         // $mm=date(DB_DATETIME_FORMAT, strtotime($datecount));
                          $countDownDate = date('Y-m-d H:i:s');
                         // $mm1=date(DB_DATETIME_FORMAT, strtotime($countDownDate));

                          // current time- created by time in playlist log terminal
                             echo $tottime = strtotime($countDownDate) - strtotime($datecount);
                          
                          // diff of total time(current time- created by time in playlist log terminal) - duation of playlist
                             $timediff = $tottime * $duartion;
                            // echo $tt = $mm - $mm1;
                           }

                           else if($rvalue=='single_schedule_successfully' || $rvalue=='schedule_successfully'){
                        
                             echo $tottime1 = strtotime($element['schedule_to']) - strtotime($element['schedule_on']);

                             $timediff = $tottime1 * $duartion;
                           }

                            ?>
                              <input type="hidden" value="<?php echo $countDownDate;?>">
                            </td>

                         <td><?php if($rvalue=='single_schedule_successfully' || $rvalue=='schedule_successfully' || $rvalue=='send_successfully'){ echo $element['schedule_on']; } ?></td> 

                         <td><?php if($rvalue=='single_schedule_successfully' || $rvalue=='schedule_successfully'){ echo $element['schedule_to']; } ?></td>
                         <?php if($element['terminal_id']){?>
                         <td><a href="<?php echo site_url("billing_log/cal/".$element['terminal_id']."/".$element['playlist_id']."/".$timediff."/".$element['pid']);?>" type="button" target="_blank" class="btn btn-warning btn-sm" />Bill</a> </td>
                       <?php } else{?>
                        <td><a href="<?php echo site_url("billing_log/cal/".$element['groupt_id']."/".$element['playlist_id']."/".$timediff."/".$element['pid']);?>" type="button" target="_blank" class="btn btn-warning btn-sm" />Bill</a> </td>
                       <?php } ?>

                         <td><input type="button" name="view" value="<?php echo $element['name'];?>" id="<?php echo $element['playlist_id']; ?>" class="btn btn-link view_data" readonly/></td> 

                         <td><?php echo $this->CRUD->get_data_row(tbl_billing_log,array('playlist_log_id'=>$element['pid']))->total; ?></td>

                    </tr>
                  <?php } ?>
                    <?php
                }
            }else if (isset($search_date) && !empty($search_date)) {
                foreach ($search_date as $key => $element) {
                    //print_r($element);die();

                    $logs=unserialize($element['message']);
                          foreach ($logs as $key => $value) { 
                          switch ($value) {
                          case '0' : $rvalue = 'Success';break;
                          case '1' : $rvalue = 'Fail';break;
                          default : $rvalue = $value;break;
                            }
                       }

                    ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $element['name']; ?></td>
                        <!--<td><input type="text" name="view" value="<?php echo $element['name'];?>" id="<?php echo $element['playlist_id']; ?>" class="btn btn-link view_data" readonly/></td> -->
                        <td><?php echo isset($row->is_active) && $row->is_active!=1 ? translate('inactive') : translate('active'); ?></td> 
                        <td><?php echo $duartion=$element['duration']; ?></td> 
                         <td><?php if($element['terminal_id']){ echo $this->CRUD->get_data_row(TBL_TERMINAL,array('id'=>$element['terminal_id']))->name;
                         }else if($element['groupt_id']){ echo $this->CRUD->get_data_row(TBL_GROUP_TERMINAL,array('id'=>$element['groupt_id']))->name; } ?></td> 
                         <td><?php echo translate($rvalue);?></td> 
                         
                         <td><?php  $d1=$element['log_created_on'];
                            echo $date_on=date("Y/m/d",strtotime($d1));
                         ?>
                         <input type="hidden" value="<?php echo $d1;?>">
                         </td>
                        

                          <td> <?php $datecount=$element['log_created_on'];
                         // $mm=date(DB_DATETIME_FORMAT, strtotime($datecount));
                          $countDownDate = date('Y-m-d H:i:s');
                         // $mm1=date(DB_DATETIME_FORMAT, strtotime($countDownDate));

                          // current time- created by time in playlist log terminal
                             echo $tottime = strtotime($countDownDate) - strtotime($datecount);
                          
                          // diff of total time(current time- created by time in playlist log terminal) - duation of playlist
                             $timediff = $tottime - $duartion;


                            // echo $tt = $mm - $mm1;
                            ?>
                              <input type="hidden" value="<?php echo $countDownDate;?>">
                            </td>

                         <td><?php if($rvalue=='single_schedule_successfully' || $rvalue=='schedule_successfully' || $rvalue=='send_successfully'){ echo $element['schedule_on']; } ?></td> 

                         <td><?php if($rvalue=='single_schedule_successfully' || $rvalue=='schedule_successfully'){ echo $element['schedule_to']; } ?></td>
                         <td>-</td>

                         <td><input type="button" name="view" value="<?php echo $element['name'];?>" id="<?php echo $element['playlist_id']; ?>" class="btn btn-link view_data" readonly/></td> 

                         <td><?php echo $this->CRUD->get_data_row(tbl_billing_log,array('playlist_log_id'=>$element['pid']))->total; ?></td>

                    </tr>
                    <?php
                }
            }
             else {
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

//var countDownDate = document.getElementById("time").value;
var countDownDate = localStorage.getItem('startDate');
if (countDownDate) {
    countDownDate = new Date(countDownDate);
} else {
    countDownDate = new Date();
    localStorage.setItem('startDate', countDownDate);
}
// Update the count down every 1 second
var x = setInterval(function() {

    // Get todays date and time
    var now = new Date().getTime();

    // Find the distance between now an the count down date
    var distance = now - countDownDate.getTime();

    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Output the result in an element with id="demo"
    document.getElementById("demo").innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
}, 1000);



/*
$(document).ready(function() {
            $('#table_id').DataTable({

                dom: 'Bfrtip',
                responsive: true,
                pageLength: 10,
                // lengthMenu: [0, 5, 10, 20, 50, 100, 200, 500],
                column: ['1'],

                buttons: [
                  //  'copy', 'csv', 'excel', 'pdf', 'print'
                   'excel', 'pdf'
                ]
            });
        });
        */
        $(document).ready(function() {
    $('#table_id').DataTable( {
        dom: 'Bfrtip',
                responsive: true,
               // pageLength: 12,
        buttons: [
            {
                extend: 'excelHtml5',
                exportOptions: {
                    //columns: ':visible'
                   columns: [ 0, 1, 2, 3, 4, 5, 6, 8, 9, 12]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    //columns: ':visible'
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 8, 9, 12]
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
                url:"<?php echo site_url(); ?>billing_log/get_playlist_details",  
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

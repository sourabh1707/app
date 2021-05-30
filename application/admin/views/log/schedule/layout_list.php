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
   <form method='post' action='<?php echo site_url(); ?>Admin_Schedule_layout_log/fetch_layout_data'>
     Start Date <input type='date' class='dateFilter' name='fromDate' value="" required>
 
     End Date <input type='date' class='dateFilter' name='endDate' value="" required>

     <input type='submit' name='submit' value='Search' class="btn  btn-success btn-sm
    <div class="x_content">

    <table class="table table-striped table-bordered" id="table_id">
      <thead>
        <tr>
          <th class="header">Sr. No.</th>
          <th>Layout Name</th>
          <th>Layout Status</th> 
          <th>Schedule On</th>
          <th>Schedule To</th>
          <th>Date</th>        
          <th>Operation</th> 

        </tr>
      </thead>
       <tbody>
            <?php
            $i = 1;

            if (isset($layoutInfo) && !empty($layoutInfo)) {
                foreach ($layoutInfo as $key => $element) {
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
                          
                          $duration1 = array($value['tis']);
                          $duration = array_sum($duration1);
                          // $duration = sum($duration1);
                         //print_r($duration); die();
                       }  

                    ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $element['name']; ?></td>
                        <!--<td><input type="text" name="view" value="<?php echo $element['name'];?>" id="<?php echo $element['playlist_id']; ?>" class="btn btn-link view_data" readonly/></td> -->
                        <td><?php echo isset($row->is_active) && $row->is_active!=1 ? translate('inactive') : translate('active'); ?></td> 
                        <!--<td><?php echo $duration; ?></td> --> 
                         <td><?php  echo $d1=$element['schedule_on'];
                            //echo $date_on=date("Y/m/d",strtotime($d1));
                         ?></td> 

                         <td><?php  echo $d2=$element['schedule_to'];
                            //echo $date_on=date("Y/m/d",strtotime($d1));
                         ?></td> 

                         <td><?php  $d3=$element['log_created_on'];
                            echo $date_on=date("Y/m/d",strtotime($d3));
                         ?></td>

                    
                         <td><input type="button" name="view" value="<?php echo $element['name'];?>" id="<?php echo $element['layout_id']; ?>" class="btn btn-link view_data" readonly/></td> 

                    </tr>
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
                        <!--<td><?php echo $duration; ?></td> --> 
                         <td><?php  echo $d1=$element['schedule_on'];
                            //echo $date_on=date("Y/m/d",strtotime($d1));
                         ?></td> 

                         <td><?php  echo $d2=$element['schedule_to'];
                            //echo $date_on=date("Y/m/d",strtotime($d1));
                         ?></td> 

                         <td><?php  $d3=$element['log_created_on'];
                            echo $date_on=date("Y/m/d",strtotime($d3));
                         ?></td>
                    
                         <td><input type="button" name="view" value="<?php echo $element['name'];?>" id="<?php echo $element['layout_id']; ?>" class="btn btn-link view_data" readonly/></td> 
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
                     <h4 class="modal-title">Layout Details</h4>  
                </div>  
                <div class="modal-body" id="layout_detail"> 
                </div>  
                <div class="modal-footer">  
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                </div>  
           </div>  
      </div>  
 </div>

  <script>
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
        buttons: [
            {
                extend: 'excelHtml5',
                exportOptions: {
                   // columns: ':visible'
                   columns: [ 0, 1, 2, 3, 4, 5 ]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5 ]
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
           //alert(id);
           $.ajax({  
                url:"<?php echo site_url(); ?>Admin_Schedule_layout_log/get_layout_details",  
                method:"post",  
                data:{id:id},  
                success:function(data){  
                     $('#layout_detail').html(data);  
                     $('#dataModal').modal("show");  
                }  
           });  
      });  
 });  
 </script>

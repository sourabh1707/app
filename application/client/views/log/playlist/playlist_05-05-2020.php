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
   <form method='post' action='<?php echo site_url(); ?>playlist_log/fetch_data'>
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
          <th class="header">Duration(Second)</th>
          <th class="header">Terminal/Group</th>
          <th class="header">Message</th>
          <th class="header">Date</th>
          <th class="header">Schedule On</th>
          <th class="header">Schedule To</th>

        </tr>
      </thead>
       <tbody>
            <?php
            $i = 1;

            if (isset($employeeInfo) && !empty($employeeInfo)) {
                foreach ($employeeInfo as $key => $element) {
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
                        <td><?php echo isset($row->is_active) && $row->is_active!=1 ? translate('inactive') : translate('active'); ?></td> 
                        <td><?php echo $element['duration']; ?></td>
                         <td><?php if($element['terminal_id']){ echo $this->CRUD->get_data_row(TBL_TERMINAL,array('id'=>$element['terminal_id']))->name;
                         }else if($element['groupt_id']){ echo $this->CRUD->get_data_row(TBL_GROUP_TERMINAL,array('id'=>$element['groupt_id']))->name; } ?></td> 
                         <td><?php echo translate($rvalue);?></td> 
                         <td><?php  $d1=$element['created_on'];
                            echo $date_on=date("Y/m/d",strtotime($d1));
                         ?></td>

                         <td><?php if($rvalue=='single_schedule_successfully' || $rvalue=='schedule_successfully' || $rvalue=='send_successfully'){ echo $element['schedule_on']; } ?></td> 

                         <td><?php if($rvalue=='single_schedule_successfully' || $rvalue=='schedule_successfully'){ echo $element['schedule_to']; } ?></td>  

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
                        <td><?php echo isset($row->is_active) && $row->is_active!=1 ? translate('inactive') : translate('active'); ?></td> 
                        <td><?php echo $element['duration']; ?></td>
                         <td><?php if($element['terminal_id']){ echo $this->CRUD->get_data_row(TBL_TERMINAL,array('id'=>$element['terminal_id']))->name;
                         }else if($element['groupt_id']){ echo $this->CRUD->get_data_row(TBL_GROUP_TERMINAL,array('id'=>$element['groupt_id']))->name; } ?></td> 
                         <td><?php echo translate($rvalue);?></td> 
                         <td><?php  $d1=$element['created_on'];
                            echo $date_on=date("Y/m/d",strtotime($d1));
                         ?></td>

                         <td><?php if($rvalue=='single_schedule_successfully' || $rvalue=='schedule_successfully' || $rvalue=='send_successfully'){ echo $element['schedule_on']; } ?></td> 

                         <td><?php if($rvalue=='single_schedule_successfully' || $rvalue=='schedule_successfully'){ echo $element['schedule_to']; } ?></td>  

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
  
  
  <script>

$(document).ready(function() {
            $('#table_id').DataTable({

                dom: 'Bfrtip',
                responsive: true,
                pageLength: 25,
                // lengthMenu: [0, 5, 10, 20, 50, 100, 200, 500],

                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]

            });
        });
  </script>
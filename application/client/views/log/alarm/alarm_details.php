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
   <form method='post' action='<?php echo site_url(); ?>Alarm_log_detail/alarm_data'>
    <div class="x_content">

      <div class="form-group col-lg-6 col-md-6 col-sm-12">
                  <label for="terminal_id">Terminal Name</label>
                  <select class="form-control select2bs4" name="terminal_id" id="terminal_id" style="width: 100%;" required=""> 
                    <option >Select</option>
                    <?php foreach ($employeeInfo as $key => $element) {  ?>
                    <option value="<?php echo $element['terminal_id']; ?>"> <?php echo $element['terminal_id']; ?></option>
                      
                        <?php }  ?>
                  </select>
                </div>

                <div class="form-group col-lg-6 col-md-6 col-sm-12">
                  <label for="status">Status</label>
                  <select class="form-control select2bs4" name="status" id="status" style="width: 100%;" required="">
                    <option >Select</option>
                    <option>Online</option>
                    <option>Offline</option>
                   </select>
                </div>
              

    <div class="form-group col-lg-3 col-md-3 col-sm-12">
</div>
<div class="form-group col-lg-4 col-md-4 col-sm-12">
     <input type='submit' name='submit' value='Search' class="btn  btn-success btn-sm">
   </div>
  </div>
</form>
</div>
</div>  


<!--Date sort-->


<div class="container-fluid">
    <div class="x_panel">         

  <!-- Search filter -->
  <center>
   <form method='post' action='<?php echo site_url(); ?>Alarm_log_detail/alarm_data1'>
    <div class="x_content">

      <div class="form-group col-lg-6 col-md-6 col-sm-12">
                  <label for="terminal_id">Terminal Name</label>
                  <select class="form-control select2bs4" name="terminal_id" id="terminal_id" style="width: 100%;" required=""> 
                    <option >Select</option>
                    <?php foreach ($employeeInfo as $key => $element) {  ?>
                    <option value="<?php echo $element['terminal_id']; ?>"> <?php echo $element['terminal_id']; ?></option>
                      
                        <?php }  ?>
                  </select>
                </div>

                <div class="form-group col-lg-6 col-md-6 col-sm-12">
                  <label for="status">Status</label>
                  <select class="form-control select2bs4" name="status" id="status" style="width: 100%;" required="">
                    <option >Select</option>
                    <option>Online</option>
                    <option>Offline</option>
                   </select>
                </div>

                 <div class="form-group col-lg-5 col-md-5 col-sm-12">
        <label for="site_type">Start Date</label>
          <input type='date' class='dateFilter' name='fromDate' value="">
          <label for="site_type">End Date</label>
          <input type='date' class='dateFilter' name='endDate' value="">
      </div>
              

    <div class="form-group col-lg-3 col-md-3 col-sm-12">
</div>
<div class="form-group col-lg-4 col-md-4 col-sm-12">
     <input type='submit' name='submit1' value='Search' class="btn  btn-success btn-sm">
   </div>
  </div>
</form>
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
                   columns: [ 0, 1, 2, 3 ]
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

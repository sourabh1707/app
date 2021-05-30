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
<form method="POST" action="" name="ofrm">
    <table id="list" class="table table-striped table-bordered">
                          
        <thead>
            <tr>
                <th>#</th>
                <th>Playlist Name</th>
                <th>Terminal Name</th>
                <th>Time Alarm Status</th>
                <th>Time on-to</th>
                <th>Time</th>
               <!-- <th>Calculate Model</th> -->
                <th>Calculate</th>    
                <th>Operation</th>                           
               
            </tr>
        </thead>
        <tbody>
            <?php
             $i = 1;
             $user_id = $this->session->userdata('user_id');
             $terminal = $this->db->query("SELECT t2.id, t2.name,t1.opentime, t1.closetime, t1.status, t1.id as tid FROM tbl_status_log t1 JOIN tbl_terminal t2 ON t1.terminal_id = t2.name AND t1.created_by=$user_id AND t1.status='offline'");

          //   echo "SELECT t2.id, t2.name,t1.opentime, t1.closetime, t1.status, t1.id as tid FROM tbl_status_log t1 JOIN tbl_terminal t2 ON t1.terminal_id = t2.name AND t1.created_by=1 AND t1.status='offline'";
              foreach ($terminal->result() as $row) {
                      $ter_id=$row->id;
                      $name=$row->name;
                      //$date1=$row->closetime;
                      //$date2=$row->opentime;
                      $status=$row->status;
                      $tid=$row->tid;

                      $date1 = strtotime($row->closetime);  
                      $date2 = strtotime($row->opentime);  
                     
                   $diff = abs($date2 - $date1);

                   // $hourdiff = round((strtotime($date1) - strtotime($date2)));
                // To get the year divide the resultant date into 
// total seconds in a year (365*60*60*24) 
$years = floor($diff / (365*60*60*24));  
  
  
// To get the month, subtract it with years and 
// divide the resultant date into 
// total seconds in a month (30*60*60*24) 
$months = floor(($diff - $years * 365*60*60*24) 
                               / (30*60*60*24));  
  
  
// To get the day, subtract it with years and  
// months and divide the resultant date into 
// total seconds in a days (60*60*24) 
$days = floor(($diff - $years * 365*60*60*24 -  
             $months*30*60*60*24)/ (60*60*24)); 
  
  
// To get the hour, subtract it with years,  
// months & seconds and divide the resultant 
// date into total seconds in a hours (60*60) 
$hours = floor(($diff - $years * 365*60*60*24  
       - $months*30*60*60*24 - $days*60*60*24) 
                                   / (60*60));  
  
  
// To get the minutes, subtract it with years, 
// months, seconds and hours and divide the  
// resultant date into total seconds i.e. 60 
$minutes = floor(($diff - $years * 365*60*60*24  
         - $months*30*60*60*24 - $days*60*60*24  
                          - $hours*60*60)/ 60);  
  
  
// To get the minutes, subtract it with years, 
// months, seconds, hours and minutes  
$seconds = floor(($diff - $years * 365*60*60*24  
         - $months*30*60*60*24 - $days*60*60*24 
                - $hours*60*60 - $minutes*60));  

$onoff= "month-".$months.",day-".$days.",hour-".$hours.",minute-".$minutes.",second-".$seconds;
    // print_r($hourdiff);  exit();
             $playlist = $this->db->query("SELECT t2.id, t2.name, t2.is_active, t1.duration, t1.id as tid, t2.is_delete,t1.schedule_on,t1.schedule_to FROM tbl_playlist_log t1 JOIN tbl_playlist t2 ON t2.id = t1.playlist_id AND t1.created_by=$user_id AND t1.terminal_id=$ter_id");

           // echo "SELECT t2.id, t2.name, t2.is_active, t1.duration, t1.id as tid, t2.is_delete,t1.schedule_on,t1.schedule_to FROM tbl_playlist_log t1 JOIN tbl_playlist t2 ON t2.id = t1.playlist_id AND t1.created_by=1 AND t1.terminal_id='y10-219-20021'";  

             //echo "SELECT t2.id, t2.name, t2.is_active, t1.duration, t1.id as tid, t2.is_delete FROM tbl_playlist_log t1 JOIN tbl_playlist t2 ON t2.id = t1.playlist_id AND t1.created_by=$user_id AND t1.terminal_id=$ter_id";
             foreach ($playlist->result() as $row1) {
                      $playlist_name=$row1->name;
                      $playlist_id=$row1->id;
                     // $date33=$row1->schedule_to;
                     // $date44=$row1->schedule_on;

                      $date3 = strtotime($row1->schedule_to);  
                      $date4 = strtotime($row1->schedule_on);  
                     
                   $diff1 = abs($date3 - $date4);

                   // $hourdiff = round((strtotime($date1) - strtotime($date2)));
                // To get the year divide the resultant date into 
                  // total seconds in a year (365*60*60*24) 
                  $years1 = floor($diff1 / (365*60*60*24));  
                    
                    
                  // To get the month, subtract it with years and 
                  // divide the resultant date into 
                  // total seconds in a month (30*60*60*24) 
                  $months1 = floor(($diff1 - $years1 * 365*60*60*24) 
                                                 / (30*60*60*24));  
                    
                    
                  // To get the day, subtract it with years and  
                  // months and divide the resultant date into 
                  // total seconds in a days (60*60*24) 
                  $days1 = floor(($diff1 - $years1 * 365*60*60*24 -  
                               $months1*30*60*60*24)/ (60*60*24)); 
                    
                    
                  // To get the hour, subtract it with years,  
                  // months & seconds and divide the resultant 
                  // date into total seconds in a hours (60*60) 
                  $hours1 = floor(($diff1 - $years1 * 365*60*60*24  
                         - $months1*30*60*60*24 - $days1*60*60*24) 
                                                     / (60*60));  
                    
                    
                  // To get the minutes, subtract it with years, 
                  // months, seconds and hours and divide the  
                  // resultant date into total seconds i.e. 60 
                  $minutes1 = floor(($diff1 - $years1 * 365*60*60*24  
                           - $months1*30*60*60*24 - $days1*60*60*24  
                                            - $hours1*60*60)/ 60);  
                    
                    
                  // To get the minutes, subtract it with years, 
                  // months, seconds, hours and minutes  
                  $seconds1 = floor(($diff1 - $years1 * 365*60*60*24  
                           - $months1*30*60*60*24 - $days1*60*60*24 
                                  - $hours1*60*60 - $minutes1*60));  

              $schedule="month-".$months1.",day-".$days1.",hour-".$hours1.",minute-".$minutes1.",second-".$seconds1; 
          }  
           $m=abs($months1-$months);
           $d=abs($days1-$days);
           $h=abs($hours1-$hours);
           $m=abs($minutes1-$minutes);
           $s=abs($seconds1-$seconds);

          $hourdiff2="day-".$d.",hour-".$h.",minute-".$m.",second-".$s;
          $timediff=(($d*86400)+($h*3600)+($m*60)+($s));
          //$res1=0;
            ?>
                    <tr> 
                    <td><?php echo $i++; ?></td>
                    <td><input type="text" name="view" value="<?php echo $playlist_name;?>" id="<?php echo $playlist_id; ?>" class="btn view_data" readonly/></td> 
                    <td><?php echo $name?></td>
                   <td><?php echo $onoff?></td>
                    <td><?php echo $schedule?></td>
                    <td><?php echo $hourdiff2?></td>
                   
                  <!--  <td><input type="text" name="num1" id="num1" value="" style="width: 45px;"><strong>*</strong><input type="text" name="num2" id="num2" value="" style="width: 45px;"><input type="button" onClick="multiplyBy()" Value="Multiply" name="res" class="btn" />Result:<span id = "result" name="result"></span> 
                      </td>
                    -->

                    <td><button type="button" name="add" id="add" data-toggle="modal" data-target="#createModal" class="btn btn-warning sm">Bill</button></td>

                   <!-- <td><a href="<?php echo site_url("billing_log/cal/".$tid);?>" type="button" target="_blank" class="btn btn-primary btn-sm" /><i class="fa fa-file-pdf-o"></i></a> </td>
                   -->
                      
                    <td><a href="<?php echo site_url("billing_log/pdf/".$tid);?>" type="button" target="_blank" class="btn btn-primary btn-sm" /><i class="fa fa-file-pdf-o"></i></a> </td>
                
                    </tr>
                  <?php }  ?>
                    </tbody>
                    </table>
                    </form>
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



<form id="createForm" action="">
    <!-- Modal -->
    <div class="modal fade" id="createModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Calculate Bill</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body" id="terminal_detail1">

            <input type="hidden" name="tid" id="tid" value="<?php echo $tid;?>">
            <input type="hidden" name="terminal_id" id="terminal_id" value="<?php echo $name;?>">
            <input type="hidden" name="playlist_id" id="playlist_id" value="<?php echo $playlist_id;?>">

            <div class="form-group">
              <label>Duration Details:-</label>
              <input type="text" id = "duration" class="form-control" name="duration" value="<?php echo $hourdiff2;?>" readonly>
           </div>

            <div class="form-group">  
              <label>Convert Days to Second</label>             
              <input type="text" name="num" id="num" value="" style="width: 45px;margin-left: 25px;margin-right: 15px;" onkeyup="multiplyBy1()">Result in Second:<input type="text" id = "result0" name="results" onblur="findTotal()" style="margin-left: 15px;">
            </div>
          

            <div class="form-group">
              <label>Convert Hours to Second</label>
              <input type="text" name="num1" id="num1" value="" style="width: 45px;margin-left: 20px;margin-right: 15px;" onkeyup="multiplyBy2()" >Result in Second:<input type="text" id = "result" name="results" onblur="findTotal()" style="margin-left: 15px;">
           </div>

           <div class="form-group">
              <label>Convert Minutes to Second</label>
              <input type="text" name="num3" id="num3" value="" style="width: 45px;margin-left: 7px;margin-right: 15px;" onkeyup="multiplyBy3()">Result in Second:<input type="text" id = "result1" name="results" onblur="findTotal()" style="margin-left: 15px;">
           </div>

          <div class="form-group">
              <label>Convert Second to Second</label>
              <input type="text" name="num5" id="num5" value="" style="width: 45px;margin-left: 7px;margin-right: 15px;" onkeyup="multiplyBy4()">Result in Second:<input type="text" id = "result2" name="results" onblur="findTotal()" style="margin-left: 15px;">
           </div>

           <div class="form-group">
              <label style="margin-left: 241px;">Total In Second</label>
              <input type="text" id = "result3" name="result3" style="margin-left: 15px;">
           </div>

            
              <div class="form-group">
              <label>Time</label>
              <input type="text" class="form-control" placeholder="Enter Time" name="time" id="time" value="<?php echo $timediff?>" onkeyup="Calculate()" readonly>
           </div>
           <div class="form-group">
              <label>Rate</label>
              <input type="text" class="form-control" placeholder="Enter Rate" name="rate" id="rate" onkeyup="Calculate()" onkeyup="Calculate()" required>
           </div>
           <div class="form-group">
              <label>Total</label>
             <input type="text" class="form-control" name="answer" id="answer" readonly />
           </div>
           
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Close</button>
            <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" />  

          </div>
        </div>
      </div>
    </div>
     </form>  


<script>
 function multiplyBy1()
{
        var num = document.getElementById("num").value;
       // num0 = document.getElementById("num0").value;
        document.getElementById("result0").value = num * 86400;
}

   function multiplyBy2()
{
        var num1 = document.getElementById("num1").value;
       // num2 = document.getElementById("num2").value;
        document.getElementById("result").value = num1 * 3600;
}

 function multiplyBy3()
{
        var num3 = document.getElementById("num3").value;
      //  num4 = document.getElementById("num4").value;
        document.getElementById("result1").value = num3 * 60;
}

 function multiplyBy4()
{
        var num5 = document.getElementById("num5").value;
      //  num4 = document.getElementById("num4").value;
        document.getElementById("result2").value = num5 * 1;
}


function findTotal(){
    var arr = document.getElementsByName('results');
    var tot=0;
    for(var i=0;i<arr.length;i++){
        if(parseInt(arr[i].value))
            tot += parseInt(arr[i].value);
    }
    document.getElementById('result3').value = tot;
}


 </script>

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

<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->


<script>
   function Calculate()
{
       var num1 = document.getElementById("time").value;
       var num2 = document.getElementById("rate").value;
      
        var result = parseInt(num1) * parseInt(num2);
            if (!isNaN(result)) {
                document.getElementById('answer').value = result;
            }
}
 </script>


<script>

  
    $("#createForm").submit(function(event) {
      event.preventDefault();
      $.ajax({
                url: "<?php echo base_url('billing_log/create'); ?>",
                data: $("#createForm").serialize(),
                type: "post",
                async: false,
                dataType: 'json',
                success: function(response){
                  
                    $('#createModal').modal('hide');
                    $('#createForm')[0].reset();
                    alert('Successfully inserted');
                   $('#exampleTable').DataTable().ajax.reload();
                   //dataTable.ajax.reload();  
                  },

               error: function()
               {
                alert("error");
               }
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
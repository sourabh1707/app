<html>
<head>
<link href="<?php echo base_url('template/admin') ?>/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url('template/admin') ?>/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
<style>
  body {
    font-family: Arial;
    color: #333;
    font-size: 0.95em;
    background: silver;
}

.form-head {
    color: #191919;
    font-weight: normal;
    font-weight: 400;
    margin: 0;
    text-align: center;    
    font-size: 1.4em;
}

.error-message {
    padding: 7px 10px;
    background: #fff1f2;
    border: #ffd5da 1px solid;
    color: #d6001c;
    border-radius: 4px;
    margin: 30px 0px 10px 0px;
}

.success-message {
    padding: 7px 10px;
    background: #cae0c4;
    border: #c3d0b5 1px solid;
    color: #027506;
    border-radius: 4px;
    margin: 30px 0px 10px 0px;
}

.demo-table {
    background: #ffffff;
    border-spacing: initial;
    margin: 15px auto;
    word-break: break-word;
    table-layout: auto;
    line-height: 1.8em;
    color: #333;
    border-radius: 4px;
    padding: 20px 40px;
    width: 600px;
    border: 1px solid;
    border-color: #e5e6e9 #dfe0e4 #d0d1d5;
}

.demo-table1 {
    background: #ffffff;
    border-spacing: initial;
    margin: 15px auto;
    word-break: break-word;
    table-layout: auto;
    line-height: 1.8em;
    color: #333;
    border-radius: 4px;
    padding: 20px 40px;
    width: 485px;
    border: 1px solid;
    border-color: #e5e6e9 #dfe0e4 #d0d1d5;
}

.demo-table .label {
    color: #888888;
}

.demo-table .field-column {
    padding: 15px 0px;
}

.demo-table .field-column1 {
    padding: 15px 0px;
    margin-left: 50px;
}


.demo-input-box {
    padding: 7px;
    border: #CCC 1px solid;
    border-radius: 4px;
    width: 20%;
    margin-left: 13px;
    margin-right: 13px;
}

.demo-input-box1 {
    padding: 11px;
    border: #CCC 1px solid;
    border-radius: 4px;
    width:40%;
}

.btnRegister {
    padding: 11px;
    background-color: #5d9cec;
    color: #f5f7fa;
    cursor: pointer;
    border-radius: 30px;
    width: 80%;
    border: #5791da 1px solid;
    font-size: 1.1em;
}

.response-text {
    max-width: 380px;
    font-size: 1.5em;
    text-align: center;
    background: #fff3de;
    padding: 42px;
    border-radius: 3px;
    border: #f5e9d4 1px solid;
    font-family: arial;
    line-height: 34px;
    margin: 15px auto;
}

.terms {
    margin-bottom: 5px;
}</style>
</head>
<body>
    <form name="frmRegistration" method="post" action="">
        <div class="demo-table">
        <div class="form-head">Calculate Bill</div>

         <div class="field-column">  
              <label>Convert Days to Second</label>             
              <input type="text" name="num" id="num" value=""  class="demo-input-box" onkeyup="multiplyBy1()">Result in Second:<input type="text" id = "result0" class="demo-input-box" name="results" onblur="findTotal()">
            </div>
          

            <div class="field-column">
              <label>Convert Hours to Second</label>
              <input type="text" name="num1" id="num1" value="" class="demo-input-box" onkeyup="multiplyBy2()" >Result in Second:<input type="text" id = "result" class="demo-input-box" name="results" onblur="findTotal()">
           </div>

           <div class="field-column">
              <label>Convert Minutes to Second</label>
              <input type="text" name="num3" id="num3" value="" class="demo-input-box" onkeyup="multiplyBy3()">Result in Second:<input type="text" id = "result1" name="results" class="demo-input-box" onblur="findTotal()">
           </div>

          <div class="field-column">
              <label>Convert Second to Second</label>
              <input type="text" name="num5" id="num5" value="" class="demo-input-box" onkeyup="multiplyBy4()">Result in Second:<input type="text" id = "result2" name="results" class="demo-input-box" onblur="findTotal()">
           </div>

           <div class="field-column">
              <label>Total In Second</label>
              <input type="text" id = "result3" name="result3" class="demo-input-box">
           </div>
             <div class="demo-table1">
            <div class="field-column1">
                <label>Time</label>
                <input type="text" class="demo-input-box1" name="time" id="time" onkeyup="Calculate()" required>
                <label>Rate</label>
             
                    <input type="rate" class="demo-input-box1" id="rate" name="rate" onkeyup="Calculate()" onkeyup="Calculate()" required>
                
            </div>
           
           <div class="field-column1">
                <label>Total</label>
                    <input type="text" class="demo-input-box1" name="answer" id="answer" required  />
                
            </div> 
           
                <div class="field-column1">
                    <input type="submit" name="submit" value="submit" class="btnRegister"> 
                </div>
            </div>
        </div>
    </form>
</body>
</html>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


<script>
   function Calculate()
{
       var num1 = document.getElementById("time").value;
       var num2 = document.getElementById("rate").value;
       //var m = num1 * num2;
        //document.getElementById('answer').value= m;
       // document.getElementById('answer').value = parseFloat(num1) * parseFloat(num2);

        var result = parseFloat(num1) * parseFloat(num2);
            if (!isNaN(result)) {

                document.getElementById('answer').value = result;
            }
}
 </script>

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

 <script src="<?php echo base_url('template/admin') ?>/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/pdfmake/build/vfs_fonts.js"></script>
<script src="<?php echo base_url('template/admin') ?>/vendors/switchery/dist/switchery.min.js"></script>
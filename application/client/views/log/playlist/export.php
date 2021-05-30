<div class="content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
               <div class="table-responsive">
    <table class="table table-hover tablesorter">
        <thead>
            <tr>
                <th class="header">Playlist Name</th>
               
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($employeeInfo) && !empty($employeeInfo)) {
                foreach ($employeeInfo as $key => $element) {
                    //print_r($element);die();
                    ?>
                    <tr>
                        <td><?php echo $element['name']; ?></td>   
                       
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
    <a class="pull-right btn btn-primary btn-xs" href="<?php echo site_url()?>export/generateXls"><i class="fa fa-file-excel-o"></i> Export Data</a>
</div> 
            </div>
        </div>
    </div>
</div>
<table border="1" style="padding:5px;" class="table table-striped">
    <tbody>
         <tr>
            <th><?php echo translate('Terminal Name'); ?> </th>
            <td><?php echo $this->CRUD->get_data_row(TBL_TERMINAL,array('id'=>$log->terminal_id))->name; ?></td>
        </tr>

        <tr>
            <th><?php echo translate('Terminal status'); ?> </th>
             <td><?php $aa=$this->CRUD->get_data_row(TBL_TERMINAL,array('id'=>$log->terminal_id)); 
                if($aa->is_active==1){
                    echo "Active";
                }else{
                    echo "Deactive";
                }
             ?>
            </td>
        </tr>

        <tr>
            <th><?php echo translate('Playlist Name'); ?> </th>
            <td><?php echo $this->CRUD->get_data_row(TBL_PLAYLIST,array('id'=>$log->playlist_id))->name; ?></td>
        </tr>

        <tr>
            <th><?php echo translate('user'); ?> </th>
            <td><?php echo $this->CRUD->get_data_row(TBL_USER,array('id'=>$log->created_by))->name; ?></td>
        </tr>
<!--
         <tr>
            <th><?php echo translate('Duration'); ?> </th>
            <td><?php echo $log->duration; ?></td>
        </tr>
-->
        <tr>
            <th colspan="2"><?php echo translate('Bill'); ?> </th>
        </tr>
    
         <tr>
            <th><?php echo translate('Time second'); ?> </th>
            <td><?php echo $log->time; ?></td>
        </tr>

        <tr>
            <th><?php echo translate('Rate'); ?> </th>
            <td>Rs.<?php echo $log->rate; ?></td>
        </tr>

        <tr>
            <th><?php echo translate('Total Amount'); ?> </th>
            <td>Rs.<?php echo $log->total; ?></td>
        </tr>
   <!--
                <tr>
                            <th>#</th>
                            <th class="text-center"><?php echo translate('type'); ?> </th>
                            <th class="text-center"><?php echo translate('content'); ?> </th>
                            <th class="text-center"><?php echo translate('time_in_seconds'); ?> </th>
                        </tr>


                    <?php 
                            if(!empty($log)){ $i = 0;
                                foreach ($log as $skey => $svalue) { $i++;
                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i; ?></td>
                                            <td class="text-center"><?php echo $svalue['time']; ?></td>
                                            <td class="text-center"><?php echo $svalue['rate']; ?></td>
                                            <td class="text-center"><?php echo $svalue['total']; ?></td>
                                        </tr>
                        <?php } }else{ ?>
                            <tr>
                                <td class="text-center" colspan="3"><?php echo translate('no_data_found'); ?></td>
                            </tr>
                        <?php } ?>
                    -->

    </tbody>
</table>

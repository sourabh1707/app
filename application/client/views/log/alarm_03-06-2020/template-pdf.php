<table border="1" style="padding:5px;">
    <tbody>
         <tr>
            <th><?php echo translate('Terminal Name'); ?> </th>
            <td><?php echo $this->CRUD->get_data_row(TBL_TERMINAL,array('name'=>$log->terminal_id))->name; ?></td>
        </tr>

        <tr>
            <th><?php echo translate('user'); ?> </th>
            <td><?php echo $this->CRUD->get_data_row(TBL_USER,array('id'=>$log->created_by))->name; ?></td>
        </tr>

         <tr>
            <th><?php echo translate('Door Status'); ?> </th>
            <td><?php echo $log->door_status; ?></td>
        </tr>

         <tr>
             <th colspan="2"><?php echo translate('OnOff Time details'); ?> </th>
        </tr>

        <tr>
            <th><?php echo translate('Online time'); ?> </th>
            <td><?php $new_date1 = date('d-m-y H:i:s', strtotime($log->opentime)); 
            echo $new_date1; ?></td>
        </tr>

          <tr>
            <th><?php echo translate('Offline time'); ?> </th>
            <?php if($log->status==online){?>
                <td>-</td>
            <?php }else{?>
            <td><?php $new_date = date('d-m-y H:i:s', strtotime($log->closetime)); 
            echo $new_date; ?></td>
        <?php } ?>
        </tr>

        <tr>
            <th><?php echo translate('Status'); ?> </th>
            <td><?php echo $log->status; ?></td>
        </tr>

         <tr>
            <th><?php echo translate('Duration'); ?> </th>
            <?php if($log->status==online){?>
                <td>-</td>
            <?php }else{?>
            <td><?php 
                $date1=strtotime($log->closetime);
                $date2=strtotime($log->opentime);

                     
                  //$hourdiff = round((strtotime($row->opentime) - strtotime($row->closetime))/3600, 1);
                   $delta_T = ($date1 - $date2);
                   $hourdiff = round(($delta_T % 604800) / 86400)."days ".round((($delta_T % 604800) % 86400) / 3600)."hours ".round(((($delta_T % 604800) % 86400) % 3600) / 60)."min ".abs((((($delta_T % 604800) % 86400) % 3600) % 60))."sec";

            echo $hourdiff; ?></td>
        <?php } ?>
        </tr>

    </tbody>
</table>

<?php //echo '<pre>';print_r($schedule->schedular);echo '</pre>'; ?>
<table class="table table-striped">
    <tbody>
        <tr>
            <th><?php echo translate('name'); ?> </th>
            <td><?php echo isset($schedule->name) && $schedule->name!='' ? $schedule->name : ''; ?></td>
        </tr>
        <tr>
            <th><?php echo translate('schedular'); ?> </th>
            <td>
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th>#</th>
                            <th class="text-center"><?php echo translate('type'); ?> </th>
                            <th class="text-center"><?php echo translate('content'); ?> </th>
                            <th class="text-center"><?php echo translate('background_color'); ?> </th>
                            <th class="text-center"><?php echo translate('time_in_seconds'); ?> </th>
                        </tr>
                        <?php 
                            $schedules = isset($schedule->layout) && !empty(unserialize($schedule->layout)) ? unserialize($schedule->layout) : array();
                            if(!empty($schedules)){ $i = 0;
                                foreach ($schedules as $skey => $svalue) { $i++;
                            ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i; ?></td>
                                            <td class="text-center"><?php echo $svalue['type']; ?></td>
                                            <td class="text-center">
                                                <?php
                                                    switch ($svalue['type']) {
                                                        case 'image':
                                                            echo '<img src="'.$svalue['image'].'" width="100px">';
                                                            break;
                                                        case 'video':
                                                            echo '<video width="320" height="240" controls> <source src="'.$svalue['video'].'" type="video/mp4">Your browser does not support the video tag. </video>';
                                                            break;
                                                        default:
                                                            echo $svalue['content_text'];
                                                            break;
                                                    }
                                                ?>
                                            </td>
                                            <td class="text-center"><?php echo $svalue['bc']; ?></td>
                                            <td class="text-center"><?php echo $svalue['tis']; ?></td>
                                        </tr>
                        <?php } }else{ ?>
                            <tr>
                                <td class="text-center" colspan="3"><?php echo translate('no_data_found'); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                
            </td>
        </tr>
        <tr>
            <th><?php echo translate('status'); ?></th>
            <td><?php echo isset($schedule->is_active) && $schedule->is_active!=1 ? translate('inactive') : translate('active'); ?></td>
        </tr>
        <tr>
            <th><?php echo translate('created_on'); ?></th>
            <td><?php echo $schedule->created_on; ?></td>
        </tr>
        <tr>
            <th><?php echo translate('updated_on'); ?></th>
            <td><?php echo $schedule->updated_on; ?></td>
        </tr>
    </tbody>
</table>

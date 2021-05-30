<?php //echo '<pre>';print_r($layout);echo '</pre>'; ?>
<table class="table table-striped">
    <tbody>
        <tr>
            <th><?php echo translate('name'); ?> </th>
            <td><?php echo isset($layout->name) && $layout->name!='' ? $layout->name : ''; ?></td>
        </tr>

        <tr>
            <th><?php echo translate('layout'); ?> </th>
            <td>
            
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th>#</th>
                            <th class="text-center"><?php echo translate('type'); ?> </th>
                            <th class="text-center"><?php echo translate('content'); ?> </th>
                            <th class="text-center"><?php echo translate('height'); ?> </th>
                            <th class="text-center"><?php echo translate('width'); ?> </th>
                            <th class="text-center"><?php echo translate('margin top'); ?> </th>
                            <th class="text-center"><?php echo translate('margin left'); ?> </th>
                        </tr>
                        <?php 
                            $layouts = isset($layout->layout) && !empty(unserialize($layout->layout)) ? unserialize($layout->layout) : array();
                            if(!empty($layouts)){ $i = 0;
                                foreach ($layouts as $skey => $svalue) { $i++;
                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i; ?></td>
                                            <td class="text-center"><?php echo $svalue['type']; ?></td>
                                            <td class="text-center">
                                                <?php
                                                    switch ($svalue['type']) {
                                                        case 'image':
                                                            echo $svalue['image'];
                                                            break;
                                                        case 'video':
                                                            echo $svalue['video'];
                                                            break;
                                                        default:
                                                            echo $svalue['content_text'];
                                                            break;
                                                    }
                                                ?>
                                            
                                                <?php /*echo $svalue['type']=='image' ? '<img src="'.$svalue['image'].'" width="100px">' : $svalue['type']=='video' ? '<video width="320" height="240" controls> <source src="'.$svalue['video'].'" type="video/mp4">Your browser does not support the video tag. </video>' : $svalue['content_text'];*/ ?>
                                            </td>
                                            <td class="text-center"><?php echo $svalue['hit']; ?></td>
                                            <td class="text-center"><?php echo $svalue['wid']; ?></td>
                                            <td class="text-center"><?php echo $svalue['tm']; ?></td>
                                            <td class="text-center"><?php echo $svalue['lm']; ?></td>
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
            <td><?php echo isset($layout->is_active) && $layout->is_active!=1 ? translate('inactive') : translate('active'); ?></td>
        </tr>
        <tr>
            <th><?php echo translate('created_on'); ?></th>
            <td><?php echo $layout->created_on; ?></td>
        </tr>
        <tr>
            <th><?php echo translate('updated_on'); ?></th>
            <td><?php echo $layout->updated_on; ?></td>
        </tr>
    </tbody>
</table>

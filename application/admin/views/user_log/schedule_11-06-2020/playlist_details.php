<?php //echo '<pre>';print_r($playlist);echo '</pre>';
if(!empty($playlist->id)){
 ?>
<table class="table table-striped">
    <tbody>
        <tr>
            <th><?php echo translate('name'); ?> </th>
            <td><?php echo isset($playlist->name) && $playlist->name!='' ? $playlist->name : ''; ?></td>
        </tr>

        <tr>
            <th><?php echo translate('playlist'); ?> </th>
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
                            $playlists = isset($playlist->playlist) && !empty(unserialize($playlist->playlist)) ? unserialize($playlist->playlist) : array();
                            if(!empty($playlists)){ $i = 0;
                                foreach ($playlists as $skey => $svalue) { $i++;
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
            <td><?php echo isset($playlist->is_active) && $playlist->is_active!=1 ? translate('inactive') : translate('active'); ?></td>
        </tr>
        <tr>
            <th><?php echo translate('created_on'); ?></th>
            <td><?php echo $playlist->created_on; ?></td>
        </tr>
        <tr>
            <th><?php echo translate('updated_on'); ?></th>
            <td><?php echo $playlist->updated_on; ?></td>
        </tr>
    </tbody>
</table>
<?php }else if(!empty($playlist1->id)){
 ?>
<table class="table table-striped">
    <tbody>
        <tr>
            <th><?php echo translate('name'); ?> </th>
            <td><?php echo isset($playlist1->name) && $playlist1->name!='' ? $playlist1->name : ''; ?></td>
        </tr>

        <tr>
            <th><?php echo translate('playlist'); ?> </th>
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
                            $playlists = isset($playlist1->layout) && !empty(unserialize($playlist1->layout)) ? unserialize($playlist1->layout) : array();
                            if(!empty($playlists)){ $i = 0;
                                foreach ($playlists as $skey => $svalue) { $i++;
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
            <td><?php echo isset($playlist1->is_active) && $playlist1->is_active!=1 ? translate('inactive') : translate('active'); ?></td>
        </tr>
        <tr>
            <th><?php echo translate('created_on'); ?></th>
            <td><?php echo $playlist1->created_on; ?></td>
        </tr>
        <tr>
            <th><?php echo translate('updated_on'); ?></th>
            <td><?php echo $playlist1->updated_on; ?></td>
        </tr>
    </tbody>
</table>
<?php } ?>
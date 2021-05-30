<table class="table table-striped">
    <tbody>
        <tr>
            <td colspan="2" style="text-align: center;">
                <?php
                    $flag = base_url('uploads/flag').'/default.png';
                    if(isset($language->flag) && $language->flag!=''){
                        $language_flag = base_url('uploads/flag').'/'.$language->flag;
                        if(file_exists(str_replace(base_url(),FCPATH,$language_flag))){
                            $flag = $language_flag;
                        }
                    }
                ?>
                <img src="<?php echo $flag; ?>" alt="<?php echo isset($language->name) && $language->name!='' ? $language->name : ''; ?>" style="width: 20%;margin-left: 0%;">
            </td>
        </tr>
        <tr>
            <th><?php echo translate('Name'); ?> </th>
            <td><?php echo isset($language->name) && $language->name!='' ? $language->name : ''; ?></td>
        </tr>
        <tr>
            <th><?php echo translate('Status'); ?></th>
            <td><?php echo isset($language->is_active) && $language->is_active!=1 ? translate('Inactive') : translate('Active'); ?></td>
        </tr>
        <tr>
            <th><?php echo translate('Created On'); ?></th>
            <td><?php echo display_datetime($language->created_on); ?></td>
        </tr>
        <tr>
            <th><?php echo translate('Updated On'); ?></th>
            <td><?php echo display_datetime($language->updated_on); ?></td>
        </tr>
    </tbody>
</table>

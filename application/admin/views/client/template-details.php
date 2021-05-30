<?php $keys = array('default_currency'); $setting = $this->CRUD->get_setting_row($keys); ?>
<table class="table table-striped">
    <tbody>
        <tr>
            <td colspan="2" style="text-align: center;">
                <?php
                    $client_path = base_url('uploads/client').'/default.png';
                    if(isset($client->logo) && $client->logo!=''){
                        $client_image = base_url('uploads/client').'/'.$client->logo;
                        if(file_exists(str_replace(base_url(),FCPATH,$client_image))){
                            $client_path = $client_image;
                        }
                    }
                ?>
                <img src="<?php echo $client_path; ?>" alt="<?php echo isset($client->name) && $client->name!='' ? $client->name : ''; ?>" class="img-circle profile_img" style="width: 20%;margin-left: 0%;">
            </td>
        </tr>
        <tr>
            <th><?php echo translate('name'); ?> </th>
            <td><?php echo isset($client->name) && $client->name!='' ? $client->name : ''; ?></td>
        </tr>
        <tr>
            <th><?php echo translate('address'); ?> </th>
            <td><?php echo isset($client->address) && $client->address!='' ? $client->address : ''; ?></td>
        </tr>
        
        <tr>
            <th><?php echo translate('created_on'); ?></th>
            <td><?php echo display_datetime($client->created_on); ?></td>
        </tr>
        <tr>
            <th><?php echo translate('updated_on'); ?></th>
            <td><?php echo display_datetime($client->updated_on); ?></td>
        </tr>
    </tbody>
</table>
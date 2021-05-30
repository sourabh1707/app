<table class="table table-striped">
    <tbody>
        <tr>
            <td colspan="2" style="text-align: center;">
                <?php
                    $profile = base_url('uploads/profile').'/default.png';
                    if(isset($staff->profile_image) && $staff->profile_image!=''){
                        $user_profile = base_url('uploads/profile').$staff->profile_image;
                        if(file_exists(str_replace(base_url(),FCPATH,$user_profile))){
                            $profile = $user_profile;
                        }
                    }
                ?>
                <img src="<?php echo $profile; ?>" alt="<?php echo isset($staff->name) && $staff->name!='' ? $staff->name : ''; ?>" class="img-circle profile_img" style="width: 20%;margin-left: 0%;">
            </td>
        </tr>
        <tr>
            <th><?php echo translate('name'); ?> </th>
            <td><?php echo isset($staff->name) && $staff->name!='' ? $staff->name : ''; ?></td>
        </tr>
        <tr>
            <th><?php echo translate('username'); ?> </th>
            <td><?php echo isset($staff->username) && $staff->username!='' ? $staff->username : ''; ?></td>
        </tr>
        <tr>
            <th><?php echo translate('email'); ?> </th>
            <td><?php echo isset($staff->user_email) && $staff->user_email!='' ? $staff->user_email : ''; ?></td>
        </tr>
        <tr>
            <th><?php echo translate('mobile_number'); ?></th>
            <td><?php echo isset($staff->mobile_no) && $staff->mobile_no!='' ? $staff->mobile_no : ''; ?></td>
        </tr>
        <tr>
            <th><?php echo translate('last_login_on'); ?></th>
            <td><?php echo isset($staff->last_login_on) && $staff->last_login_on!='' ? display_datetime($staff->last_login_on) : translate('never'); ?></td>
        </tr>
        <tr>
            <th><?php echo translate('status'); ?></th>
            <td><?php echo isset($staff->is_active) && $staff->is_active!=1 ? translate('inactive') : translate('active'); ?></td>
        </tr>
        <tr>
            <th><?php echo translate('created_on'); ?></th>
            <td><?php echo display_datetime($staff->created_on); ?></td>
        </tr>
        <tr>
            <th><?php echo translate('updated_on'); ?></th>
            <td><?php echo display_datetime($staff->updated_on); ?></td>
        </tr>
    </tbody>
</table>
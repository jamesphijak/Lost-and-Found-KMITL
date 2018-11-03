<div class="row">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header text-left bg-primary text-white text-center"><i class="fas fa-user-circle"></i> <?= $title ?></h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-10">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm table-striped table-bordered">
                                <tbody>
                                    <tr class="d-flex">
                                        <td class="col-4" align="right">อีเมล</td>
                                        <td class="col-8"><?= $user->email ?></td>
                                    </tr>
                                    <tr class="d-flex">
                                        <td class="col-4" align="right">เบอร์โทรศัพท์</td>
                                        <td class="col-8"><?= $user->mobile ?></td>
                                    </tr>
                                    <tr class="d-flex">
                                        <td class="col-4" align="right">ประเภทสมาชิก</td>
                                        <td class="col-8"><?= $user->user_type ?></td>
                                    </tr>
                                    <tr class="d-flex">
                                        <td class="col-4" align="right">Facebook ID</td>
                                        <td class="col-8"><?= (!empty($user->facebook_id))? $user->facebook_id.'<br><a href="'.base_url('/user/unsetFacebook').'">ยกเลิกการเชื่อมต่อกับ Facebook</a>':'ยังไม่ได้เชื่อมต่อกับ Facebook<br><a href="'.base_url('/auth/facebook').'">เชื่อมต่อกับ Facebook</a>' ?></td>
                                    </tr>
                                    <tr class="d-flex">
                                        <td class="col-4" align="right">เป็นสมาชิกตั้งแต่</td>
                                        <td class="col-8"><?= $this->template->normalDatetime($user->created) ?></td>
                                    </tr>
                                    <tr class="d-flex">
                                        <td class="col-4" align="right">แก้ไขข้อมูล่าสุด</td>
                                        <td class="col-8"><?= $this->template->normalDatetime($user->updated) ?></td>
                                    </tr>
                                </tbody> 
                            </table>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <a href="<?= base_url('user/editProfile') ?>" class="btn btn-outline-success btn-block"><i class="fas fa-edit"></i> แก้ไขข้อมูล</a>
                        <a href="<?= base_url('user/editPassword') ?>" class="btn btn-outline-primary btn-block"><i class="fas fa-edit"></i> แก้ไขรหัสผ่าน</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<br>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header text-left bg-primary text-white text-center">รายการประกาศของฉัน</h5>
            <div class="card-body">
                <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header text-left bg-primary text-white text-center"><i class="fas fa-edit"></i> <?= $title ?></h5>
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <!-- Message -->
                    <?php if(isset($_SESSION['success'])){ ?>
                        <div class="alert alert-success col-md-6" role="alert"><?= $_SESSION['success'] ?></div>
                    <?php } ?>
                    <?php if(isset($_SESSION['error'])){ ?>
                        <div class="alert alert-danger col-md-6" role="alert"><?= $_SESSION['error'] ?></div>
                    <?php } ?>
                </div>
                <form method="post" class="form-group row justify-content-center">
                <!-- Form input -->
                    <div class='form-group col-md-6'>
                        <!-- <?= validation_errors('<div class="alert alert-danger" role="alert">','  </div>')?> -->
                        <div class='form-group col-md-12'>
                            <label class='col-form-label'>อีเมล</label>
                            <input readonly type='text' name='email' value="<?= set_value('email',$user->email) ?>" class='form-control' placeholder='โปรดกรอกอีเมล' />
                            <small class="text-danger"><b><?= form_error('email')?></b></small>
                        </div>
                        <div class='form-group col-md-12'>
                            <label class='col-form-label'>เบอร์โทรศัพท์</label>
                            <input type='text' name='mobile' value="<?= set_value('mobile',$user->mobile) ?>" class='form-control' placeholder='โปรดกรอกเบอร์โทรศัพท์' />
                            <small class="text-danger"><b><?= form_error('mobile')?></b></small>
                        </div>
                        <!-- <div class='form-group col-md-12'>
                            <label class='col-form-label'>รหัสผ่านใหม่</label>
                            <input type='password' name='password' value="<?= set_value('password') ?>" class='form-control' placeholder='โปรดกรอกรหัสผ่านใหม่' />
                            <small class="text-danger"><b><?= form_error('password')?></b></small>
                        </div>
                        <div class='form-group col-md-12'>
                            <label class='col-form-label'>ยืนยันรหัสผ่าน</label>
                            <input type='password' name='confirm_password' value="<?= set_value('confirm_password') ?>" class='form-control' placeholder='โปรดกรอกรหัสผ่านใหม่เพื่อยืนยัน' />
                            <small class="text-danger"><b><?= form_error('confirm_password')?></b></small>
                        </div> -->
                        
                        <button class="btn btn-success btn-block" type="submit" name="edit"><i class="fas fa-edit"></i> แก้ไขข้อมูล</button>
                        <a href="<?= base_url('user/profile') ?>" class="btn btn-primary btn-block text-white"><i class="fas fa-chevron-circle-left"></i> กลับ</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

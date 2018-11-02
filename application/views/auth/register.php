

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header text-left bg-primary text-white text-center"><?= $title ?></h5>
            <div class="card-body">
                <?php if(isset($_SESSION['success'])){ ?>
                    <div class="alert alert-success" role="alert"><?= $_SESSION['success'] ?></div>
                <?php } ?>
                <?php if(isset($_SESSION['error'])){ ?>
                    <div class="alert alert-danger" role="alert"><?= $_SESSION['error'] ?></div>
                <?php } ?>
                <form method="post" class="form-group row justify-content-center">
                    <div class='form-group col-md-6'>
                        <!-- <?= validation_errors('<div class="alert alert-danger" role="alert">','  </div>')?> -->
                        <div class='form-group col-md-12'>
                            <label class='col-form-label'>อีเมล</label>
                            <input type='text' name='email' value="<?= set_value('email') ?>" class='form-control' placeholder='โปรดกรอกอีเมล' />
                            <small class="text-danger"><b><?= form_error('email')?></b></small>
                        </div>
                        <div class='form-group col-md-12'>
                            <label class='col-form-label'>รหัสผ่าน</label>
                            <input type='password' name='password' value="<?= set_value('password') ?>" class='form-control' placeholder='โปรดกรอกรหัสผ่าน' />
                            <small class="text-danger"><b><?= form_error('password')?></b></small>
                        </div>
                        <div class='form-group col-md-12'>
                            <label class='col-form-label'>ยืนยันรหัสผ่าน</label>
                            <input type='password' name='confirm_password' value="<?= set_value('confirm_password') ?>" class='form-control' placeholder='โปรดกรอกรหัสผ่านเพื่อยืนยัน' />
                            <small class="text-danger"><b><?= form_error('confirm_password')?></b></small>
                        </div>
                        <div class='form-group col-md-12'>
                            <label class='col-form-label'>เบอร์โทรศัพท์</label>
                            <input type='text' name='mobile' value="<?= set_value('mobile') ?>" class='form-control' placeholder='โปรดกรอกเบอร์โทรศัพท์' />
                            <small class="text-danger"><b><?= form_error('mobile')?></b></small>
                        </div>
                        <button class="btn btn-success btn-block" type="submit" name="register"><i class="fas fa-user-plus"></i> สมัครสมาชิก</button>
                        <a href="<?= base_url('auth/login') ?>" class="btn btn-primary btn-block text-white"><i class="fas fa-sign-in-alt"></i> เข้าสู่ระบบ</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

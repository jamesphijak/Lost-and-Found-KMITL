<link href="<?= base_url('assets/css/login.css')?>" rel="stylesheet">

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

                    <form class="form-signin" method="POST">
                        <h4 class="form-signin-heading text-center">โปรดกรอกข้อมูลเพื่อเข้าสู่ระบบ</h4>

                        <input type='text' name='input[email]' class='form-control' placeholder='อีเมล'>
                        <input type='password' name='input[password]' class='form-control' placeholder='รหัสผ่าน'>

                        <button class="btn btn-success btn-block" type="submit" name="login"><i class="fas fa-sign-in-alt"></i> เข้าสู่ระบบ</button>
                        <a href="<?= base_url('auth/facebook') ?>" class="btn btn-warning btn-block text-white"><i class="fab fa-facebook"></i> เข้าสู่ระบบผ่าน Facebook</a>
                        <a href="<?= base_url('auth/register') ?>" class="btn btn-primary btn-block text-white"><i class="fas fa-user-plus"></i> สมัครสมาชิก</a>
                    </form>
                </div>
        </div>
    </div>
</div>

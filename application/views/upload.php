<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Codeignitor Upload single file example</title>
    <?php $font = "Sukhumvit";?>

    <!-- CSS loader section -->
    <link href="<?= base_url('/')?>assets/css/bootstrap.css" rel="stylesheet">
    <link href="<?= base_url('/')?>assets/font/sukhumvit/sukhumvit.css" rel="stylesheet">
    <link href="<?= base_url('/')?>assets/font/maledpan/maledpan.css" rel="stylesheet">
    <link href="<?= base_url('/')?>assets/font/material-icons/material-icons.css" rel="stylesheet">
    <!-- Javascript loader section -->
    <script src="<?= base_url('/')?>assets/js/jquery-3.3.1.js"></script>
    <script src="<?= base_url('/')?>assets/js/bootstrap.js"></script>
    <script src="<?= base_url('/')?>assets/js/jquery.min.js"></script>

    <style type="text/css">
        html, body{
            font-family: "<?= $font; ?>"; // Maledpan
        }
        .container{
            margin-top:10px; // Top margin
        }
        .no-border td{
            border:none;
        }
    </style>

</head>
<body>
<div class="row">
    <div class="col-md-12">
        <div class="container">
            <div class="card">
                <h5 class="card-header">Codeignitor Upload single file example</h5>
                <div class="card-body">
                    <form action="<?= base_url('post/uploadFile') ?>" method="post" enctype="multipart/form-data">
                        <label class="col-form-label">รูปภาพ</label>
                        <input type="file" accept="image/*"  class="form-control"  name="image1" id="image1" />

                <label class="col-form-label">รูปภาพ2</label>
                <input type="file" accept="image/*"  class="form-control"  name="image2" id="image2" />
                        <br>
                        <input type="submit" value="อัพโหลดรูปภาพ" class="btn btn-success">
                    </form>


                </div>
                <div class="card-footer">
                    Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
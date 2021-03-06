<style rel="stylesheet">
    img {
        object-fit: contain;
    }

</style>

<div class="row">
    <div class="col-md-4 order-md-2 mb-4" id="txtHint">
        <?php
        $searh_title = ($type == 'lost') ? 'ถูกพบ' : 'หาย';
        ?>

        <h5 class="d-flex border-bottom border-gray pb-2 mb-0">ไม่พบประกาศของที่<?= $searh_title ?></h5>

    </div>
    <div class="col-md-8 order-md-1">
        <h4 class="mb-0"><?= $title ?></h4>
        <hr class="mb-4">
        <!-- Message -->
        <?php if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-success" role="alert"><?= $_SESSION['success'] ?></div>
        <?php } ?>
        <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger" role="alert"><?= $_SESSION['error'] ?></div>
        <?php } ?>

        <form class="form-group" method="post" enctype="multipart/form-data">
            <?php $select = "" ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="country">หมวดหมู่</label>
                    <select class="custom-select d-block w-100" id="categoryOfItem" name="category">
                        <option value="">เลือกหมวดหมู่...</option>
                        <?php foreach ($categories as $row) :
                            if (set_value('category') != null) {
                                if (set_value('category') == $row->category_id) {
                                    $select = "selected";
                                } else {
                                    $select = "";
                                }
                            }
                            ?>

                            <option <?= $select ?>
                                    value="<?= $row->category_id ?>"><?= $row->category_name ?></option>
                        <?php endforeach; ?>

                    </select>
                    <small class="text-danger"><b><?= form_error('category') ?> </b></small>

                </div>
                <div class="col-md-6 mb-3">
                    <label for="state">สี</label>
                    <select class="custom-select d-block w-100" id="colorOfItem" name="color">
                        <option value="">เลือกสี...</option>
                        <?php foreach ($colors as $row) :
                            if (set_value('color') != null) {
                                if (set_value('color') == $row->color_id) {
                                    $select = "selected";
                                } else {
                                    $select = "";
                                }
                            }

                            ?>
                            <option <?= $select ?>
                                    value="<?= $row->color_id ?>"><?= $row->color_name ?></option>
                        <?php endforeach; ?>
                    </select>
                    <small class="text-danger"><b><?= form_error('color') ?></b></small>

                </div>
            </div>
            <hr class="mb-4">

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="name" id="count_name">ชื่อ</label>
                    <input type="text" id="name" class="form-control" placeholder="ใส่ชื่อ" value="<?= set_value('name') ?>"
                           name="name">
                    <small id="nameError" class="text-danger"><b><?= form_error('name') ?></b></small>
                </div>
            </div>

            <div class="mb-3">
                <label for="description" id="count_description">รายละเอียดเกี่ยวกับของ</label>
                <textarea type="text" class="form-control" rows="5" name="description" id="description"
                          placeholder="ใส่รายละเอียดของ"><?= set_value('description') ?></textarea>
                <small class="text-danger"><b><?= form_error('description') ?></b></small>
            </div>

            <hr class="mb-4">

            <h4 class="mb-3">รูปภาพปก <small class="text-danger">*จำเป็น</small></h4>
            <div class="form-group">
                <label class="btn btn-primary" style="margin-bottom:0px;">
                    เลือกรูปภาพ
                    <input id="image1" name="image1" onchange="show_image1.innerText = this.value.split(/(\\|\/)/g).pop();" type="file" accept=".jpg,.jpeg,.png" hidden>
                </label>
                <span id="show_image1" class="text-muted"></span>
                <small class="text-danger"><b><?= form_error('image1') ?></b></small>
             </div>

            <hr class="mb-4">

            <h4 class="mb-3">รูปภาพเพิ่มเติม <small>(ถ้ามี)</small></h4>
            <div class="form-group">
                <label class="btn btn-outline-primary" style="margin-bottom:0px;">
                    เลือกรูปภาพ
                    <input id="image2" name="image2" onchange="show_image2.innerText = this.value.split(/(\\|\/)/g).pop();" type="file" accept=".jpg,.jpeg,.png" hidden>
                </label>
                <span id="show_image2" class="text-muted"></span>
                <small class="text-danger"><b><?= form_error('image2') ?></b></small>
            </div>

            <hr class="mb-4">
            <button class="btn btn-success btn-block" type="submit">ยืนยันการลงประกาศ</button>
            <a href="<?= base_url('post/all') ?>" class="btn btn-danger btn-block">ยกเลิก</a>
        </form>
    </div>
</div>

<script>

    function find(str) {
        if (window.XMLHttpRequest) {
            // Code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {  // Code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        }
        xmlhttp.open("GET", "<?= base_url('post/loadPost/' . $type)?>?search=" + str, true);
        xmlhttp.send();
    }

    $(document).ready(function () {

        var count_name = 0;
        var check =  /^[a-zA-Z0-9ก-๛เ ]*$/;
        document.getElementById('name').onkeyup = function () {
            count_name = 50 - this.value.length;
            if(count_name < 0){
                document.getElementById('count_name').innerHTML = "ชื่อ คุณพิมพ์เกิน 50 ตัวอักษรแล้ว";
            }else {
                document.getElementById('count_name').innerHTML = "ชื่อ จำนวนตัวอักษร " + this.value.length + "/50";
            }

            if(!check.test(this.value)){
                document.getElementById('nameError').innerHTML = "<b>ห้ามมีอักขระพิเศษ</b>";
            }else{
                document.getElementById('nameError').innerHTML = "";
            }
        };

        var count_description = 0;
        document.getElementById('description').onkeyup = function () {
            count_description = 200 - this.value.length;
            if(count_description < 0){
                document.getElementById('count_description').innerHTML = "รายละเอียดเกี่ยวกับของ  คุณพิมพ์เกิน 200 ตัวอักษรแล้ว";
            }else {
                document.getElementById('count_description').innerHTML = "รายละเอียดเกี่ยวกับของ จำนวนตัวอักษร " + this.value.length + "/200";
            }
        };

        var inp = {category: "", color: ""};
        var str;

        $('#categoryOfItem').change(function () {
            inp['category'] = $(this).val();
            // showUser($(this).val());
            str = JSON.stringify(inp);
            find(str);
        });


        $('#colorOfItem').change(function () {
            inp['color'] = $(this).val();
            // showUser($(this).val());
            str = JSON.stringify(inp);
            find(str);
        });
    });
</script>
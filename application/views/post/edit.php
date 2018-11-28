<style rel="stylesheet">
    img {
        object-fit: contain;
    }

</style>

<div class="row">
    <div class="col-md-12">
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
                            }else{
                                if ($post->post_category_id == $row->category_id) {
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
                            }else{
                                if ($post->post_color_id == $row->color_id) {
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
                    <label for="count_name" id="count_name">ชื่อ</label>
                    <input id="name" type="text" class="form-control" placeholder="ใส่ชื่อ" value="<?= set_value('name',$post->post_name) ?>"
                           name="name">
                    <small class="text-danger"><b><?= form_error('name') ?></b></small>
                </div>
            </div>

            <div class="mb-3">
                <label for="address" id="count_description">รายละเอียดเกี่ยวกับของ</label>
                <?php
                $breaks = array("<br />","<br>","<br/>");
                $desc = str_ireplace($breaks, "", $post->post_description);
                ?>
                <textarea id="description" type="text" class="form-control" rows="5" name="description"
                          placeholder="ใส่รายละเอียดของ"><?= set_value('description',$desc) ?></textarea>
                <small class="text-danger"><b><?= form_error('description') ?></b></small>
            </div>


            <hr class="mb-4">
            <button class="btn btn-success btn-block" onclick="return confirm('การแก้ไขประกาศจะต้องให้ผู้ดูแลระบบตรวจสอบอีกครั้ง?');" type="submit">แก้ไขประกาศ</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        var count_name = 0;
        document.getElementById('name').onkeyup = function () {
            count_name = 50 - this.value.length;
            if (count_name < 0) {
                document.getElementById('count_name').innerHTML = "ชื่อ คุณพิมพ์เกิน 50 ตัวอักษรแล้ว";
            } else {
                document.getElementById('count_name').innerHTML = "ชื่อ จำนวนตัวอักษร " + this.value.length + "/50";
            }
        };

        var count_description = 0;
        document.getElementById('description').onkeyup = function () {
            count_description = 200 - this.value.length;
            if (count_description < 0) {
                document.getElementById('count_description').innerHTML = "รายละเอียดเกี่ยวกับของ  คุณพิมพ์เกิน 200 ตัวอักษรแล้ว";
            } else {
                document.getElementById('count_description').innerHTML = "รายละเอียดเกี่ยวกับของ จำนวนตัวอักษร " + this.value.length + "/200";
            }
        };
    });
</script>

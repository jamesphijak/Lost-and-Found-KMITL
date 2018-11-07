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
                    <label for="firstName">ชื่อ</label>
                    <input type="text" class="form-control" placeholder="ใส่ชื่อ" value="<?= set_value('name',$post->post_name) ?>"
                           name="name">
                    <small class="text-danger"><b><?= form_error('name') ?></b></small>
                </div>
            </div>

            <div class="mb-3">
                <label for="address">รายละเอียดเกี่ยวกับของ</label>
                <textarea type="text" class="form-control" rows="5" name="description"
                          placeholder="ใส่รายละเอียดของ"><?= set_value('description',$post->post_description) ?></textarea>
                <small class="text-danger"><b><?= form_error('description') ?></b></small>
            </div>

<!--            <hr class="mb-4">-->
<!---->
<!--            <h4 class="mb-3">รูปภาพปก</h4>-->
<!--            <div class="form-group">-->
<!--                <label class="btn btn-primary" style="margin-bottom:0px;">-->
<!--                    เลือกรูปภาพ-->
<!--                    <input id="image1" name="image1" onchange="show_image1.innerText = this.value.split(/(\\|\/)/g).pop();" type="file" accept=".jpg,.jpeg,.png" hidden>-->
<!--                </label>-->
<!--                <span id="show_image1" class="text-muted"></span>-->
<!--                <small class="text-danger"><b>--><?//= form_error('image1') ?><!--</b></small>-->
<!--            </div>-->
<!---->
<!--            <hr class="mb-4">-->
<!---->
<!--            <h4 class="mb-3">รูปภาพเพิ่มเติม</h4>-->
<!--            <div class="form-group">-->
<!--                <label class="btn btn-outline-primary" style="margin-bottom:0px;">-->
<!--                    เลือกรูปภาพ-->
<!--                    <input id="image2" name="image2" onchange="show_image2.innerText = this.value.split(/(\\|\/)/g).pop();" type="file" accept=".jpg,.jpeg,.png" hidden>-->
<!--                </label>-->
<!--                <span id="show_image2" class="text-muted"></span>-->
<!--                <small class="text-danger"><b>--><?//= form_error('image2') ?><!--</b></small>-->
<!--            </div>-->

            <hr class="mb-4">
            <button class="btn btn-success btn-block" type="submit">แก้ไขประกาศ</button>
        </form>
    </div>
</div>

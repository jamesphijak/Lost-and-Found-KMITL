<style rel="stylesheet">
    img {
        object-fit: contain;
    }

</style>

<div class="row">
    <div class="col-md-12 text-center">
        <h4>ประกาศของหาย</h4>
        <hr>
    </div>
    <?php if(count($posts_lost) == 0){ ?>
        <div class="col-md-12 text-center">
            <h5 class="text-danger">ไม่พบรายการประกาศของหาย</h5>
            <hr>
        </div>
    <?php }else{ ?>

    <?php foreach ($posts_lost as $row) : ?>
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <h5 class="card-header text-left bg-primary text-white text-center"><?= $row->post_name ?></h5>
                <?php
                if ($row->post_imgurl1 == "") {
                    $image = "image-not-found.jpg";
                } else {
                    $image = $row->post_imgurl1;
                }
                ?>
                <a href="<?= base_url('post/view/' . $row->post_id) ?>"><img class="card-img-bottom"
                                    style="height: 225px; width: 100%; display: block; padding:20px;"
                                    src="<?= base_url("uploads/") . $image ?>" data-holder-rendered="true"></a>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            <a href="<?= base_url('post/all/color/' . $row->post_color_id) ?>" class="btn btn-sm btn-primary">สี<?= $row->color_name ?></a>
                            <a href="<?= base_url('post/all/category/' . $row->post_category_id) ?>" class="btn btn-sm btn-outline-primary"><?= $row->category_name ?></a>
                        </div>
                        <small class="text-muted"><?= $this->template->thaiNormalDatetime($row->post_created) ?></small>
                    </div>
                </div>

            </div>
        </div>
    <?php endforeach; ?>
    <?php } ?>

    <div class="col-md-12">
        <a href="<?= base_url('post/all/lost') ?>" class="btn btn-success btn-block"><i class="far fa-caret-square-down"></i> ดูรายการประกาศของหายทั้งหมด</a><br>
    </div>

    <div class="col-md-12 text-center">
        <h4>ประกาศพบของหาย</h4>
        <hr>
    </div>

    <?php if(count($posts_found) == 0){ ?>
        <div class="col-md-12 text-center">
            <h5 class="text-danger">ไม่พบรายการประกาศพบของหาย</h5>
            <hr>
        </div>
    <?php }else{ ?>

    <?php foreach ($posts_found as $row) : ?>

        <div class="col-md-4">

            <div class="card mb-4 shadow-sm">
                <h5 class="card-header text-left bg-primary text-white text-center"><?= $row->post_name ?></h5>
                <?php
                if ($row->post_imgurl1 == "") {
                    $image = "image-not-found.jpg";
                } else {
                    $image = $row->post_imgurl1;
                }
                ?>
                <a href="<?= base_url('post/view/' . $row->post_id) ?>"><img class="card-img-bottom"
                                    style="height: 225px; width: 100%; display: block; padding:20px;"
                                    src="<?= base_url("uploads/") . $image ?>" data-holder-rendered="true"></a>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            <a href="<?= base_url('post/all/color/' . $row->post_color_id) ?>" class="btn btn-sm btn-primary">สี<?= $row->color_name ?></a>
                            <a href="<?= base_url('post/all/category/' . $row->post_category_id) ?>" class="btn btn-sm btn-outline-primary"><?= $row->category_name ?></a>
                        </div>
                        <small class="text-muted"><?= $this->template->thaiNormalDatetime($row->post_created) ?></small>
                    </div>
                </div>

            </div>
        </div>

    <?php endforeach; ?>
    <?php } ?>

    <div class="col-md-12">
        <a href="<?= base_url('post/all/found') ?>" class="btn btn-success btn-block"><i class="far fa-caret-square-down"></i> ดูรายการประกาศพบของหายทั้งหมด</a>
    </div>


</div>

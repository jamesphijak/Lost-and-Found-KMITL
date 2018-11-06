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
                <a href="test"><img class="card-img-bottom"
                                    style="height: 225px; width: 100%; display: block; padding:20px;"
                                    src="<?= base_url("uploads/") . $image ?>" data-holder-rendered="true"></a>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-outline-secondary">Color</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Categorie</button>
                        </div>
                        <small class="text-muted"><?= $this->template->normalDatetime($row->post_created) ?></small>
                    </div>
                </div>

            </div>
        </div>
    <?php endforeach; ?>


    <div class="col-md-12">
        <a href="#" class="btn btn-success btn-block"><i class="far fa-caret-square-down"></i> ดูรายการทั้งหมด</a><br>
    </div>

    <div class="col-md-12 text-center">
        <h4>ประกาศพบของหาย</h4>
        <hr>
    </div>

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
                <a href="test"><img class="card-img-bottom"
                                    style="height: 225px; width: 100%; display: block; padding:20px;"
                                    src="<?= base_url("uploads/") . $image ?>" data-holder-rendered="true"></a>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-outline-secondary">Color</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Categorie</button>
                        </div>
                        <small class="text-muted"><?= $this->template->normalDatetime($row->post_created) ?></small>
                    </div>
                </div>

            </div>
        </div>

    <?php endforeach; ?>


    <div class="col-md-12">
        <a href="#" class="btn btn-success btn-block"><i class="far fa-caret-square-down"></i> ดูรายการทั้งหมด</a>
    </div>


</div>

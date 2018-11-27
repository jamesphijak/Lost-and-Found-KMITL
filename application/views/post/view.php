<style rel="stylesheet">
    img {
        object-fit: contain;
    }

</style>

<div class="row">
    <div class="col-md-12">
        <?php
            if($post->post_approve != "Approve"){
        ?>
        <div class="alert alert-danger" role="alert">ประกาศนี้อยู่ระหว่างรอการอนุมัติจากผู้ดูแลระบบ</div>
        <?php } ?>

        <?php
        if($post->post_status != "Wait"){
            ?>
            <div class="alert alert-danger" role="alert">ประกาศนี้ถูกปิดแล้ว</div>
        <?php } ?>

        <?php
        if($post->post_is_expire != 0){
            ?>
            <div class="alert alert-danger" role="alert">ประกาศนี้หมดอายุแล้ว</div>
        <?php } ?>
    <h3 class="text-center"><?= $post->post_name ?></h3><hr>
    </div>
    <div class="col-md-4">
        <?php
        if ($post->post_imgurl1 == "") {
            $image = "image-not-found.jpg";
        } else {
            $image = $post->post_imgurl1;
        }

        if ($post->post_imgurl2 != "") {
            $image2 = $post->post_imgurl2;
        }else{

        }
        ?>

<!--        <img src="--><?//= base_url("uploads/") . $image ?><!--" alt="" class="img-thumbnail">-->

        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <?php
            if ($post->post_imgurl2 != "") {
            ?>
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <?php
                if ($post->post_imgurl2 != "") {
                ?>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <?php } ?>
            </ol>
            <?php }?>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block img-thumbnail" src="<?= base_url("uploads/") . $image ?>" alt="First slide">
                </div>
                <?php
                if ($post->post_imgurl2 != "") {
                ?>
                <div class="carousel-item">
                    <img class="d-block img-thumbnail" src="<?= base_url("uploads/") . $post->post_imgurl2 ?>" alt="Second slide">
                </div>
                <?php } ?>
            </div>
            <?php
            if ($post->post_imgurl2 != "") {
            ?>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">ก่อนหน้า</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">ถัดไป</span>
            </a>
            <?php } ?>
        </div>

    </div>
    <div class="col-md-8">
        <br>
        <h5>ประเภท : <?= ($post->post_type == 'lost')? 'ตามหาของหาย':'พบของหาย' ?></h5>
        <h5>หมวดหมู่ : <?= $post->category_name ?></h5>
        <h5>สี : <?= $post->color_name ?></h5>
        <h5>รายละเอียด :</h5>
        <h5><?= $post->post_description ?></h5>


    </div>

    <div class="col-md-12">
        <hr>
        <h4 class="text-center"><i class="fas fa-comments"></i> ความคิดเห็น</h4>
        <hr>
    </div>
    <div class="col-md-12">
        <?php if($page_login == true && $post->post_approve == "Approve" && $post->post_status == "Wait"){ ?>
        <span id="comment_message"></span>
        <form method="POST" id="comment_form">
            <div class="form-group">
<!--                <input type="hidden" name="user_id" id="user_id" class="form-control" value="--><?//= $_SESSION['user_id'] ?><!--" />-->
<!--                <input type="hidden" name="post_id" id="post_id" class="form-control" value="--><?//= $page_post_id ?><!--" />-->
                <label id="count" for="comment_content"></label>
                <textarea name="comment_content" id="comment_content" class="form-control" placeholder="ข้อมูลความคิดเห็น" rows="2"></textarea>
            </div>
            <div class="form-group">
                <input type="hidden" name="comment_id" id="comment_id" value="0" />
                <button type="submit" name="submit" id="submit" class="btn btn-success"><i class="fas fa-comment"></i> แสดงความคิดเห็น</button>
                <a class="btn btn-danger" href="<?= base_url('post/view/'.$post->post_id) ?>"><i class="fas fa-ban"></i> ยกเลิก</a>
            </div>
        </form>
        <?php }else{?>
            <?php if($post->post_approve != "Approve"){ ?>
                <h6 class="text-center text-danger">ต้องรอการอนุมัติจากผู้ดูแลระบบก่อน</h6>
            <?php }elseif($post->post_status != "Wait"){ ?>
                <h6 class="text-center text-danger">ประกาศถูกปิดแล้ว</h6>
            <?php }else{ ?>
                <h6 class="text-center text-danger">กรุณาเข้าสู่ระบบเพื่อแสดงความคิดเห็น <br><a style="margin-top:10px;" href="<?= base_url('auth/login') ?>" class="btn btn-primary btn-sm">เข้าสู่ระบบ</a></a> </h6>
            <?php } ?>
        <?php } ?>


        <div class="my-3 p-3 bg-white rounded shadow-sm" id="display_comment">
        </div>
    </div>
</div>

<script>


    $(document).ready(function(){
        var count_comment = 0;
        document.getElementById('comment_content').onkeyup = function () {
            count_comment = 250 - this.value.length;
            if(count_comment < 0){
                document.getElementById('count').innerHTML = "คุณพิมพ์เกิน 250 ตัวอักษรแล้ว";
            }else {
                document.getElementById('count').innerHTML = "เหลือจำนวนตัวอักษรที่พิมพ์ได้: " + count_comment;
            }
        };

        startRefresh();

        function startRefresh() {
            setTimeout(startRefresh,3000);
            $.get('<?= base_url('post/fetch_comment/'.$page_post_id) ?>', function(data) {
                $('#display_comment').html(data);
            });
        }

        $('#comment_form').on('submit', function(event){
            event.preventDefault();
            var form_data = $(this).serialize();
            $.ajax({
                url:"<?= base_url('post/add_comment/'.$page_post_id.'/'.$_SESSION['user_id']) ?>",
                method:"POST",
                data:form_data,
                dataType:"JSON",
                success:function(data)
                {
                    if(data.error != '')
                    {
                        $('#comment_form')[0].reset();
                        $('#comment_message').html(data.message);
                        $('#comment_id').val('0');

                        document.getElementById('count').innerHTML = "";
                        count_comment = 0;

                        load_comment();
                    }
                }
            })
        });

          load_comment();

        function load_comment()
        {
            $.ajax({
                url:"<?= base_url('post/fetch_comment/'.$page_post_id) ?>",
                method:"POST",
                success:function(data)
                {
                    $('#display_comment').html(data);
                }
            })
        }

        $(document).on('click', '.remove', function(){
            var comment_id = $(this).attr("id");
            $.ajax({
                type: 'POST',
                url: '<?= base_url('post/remove_comment/')?>'.concat(comment_id),
                beforeSend:function(){
                    return confirm("คุณต้องการลบใช่มั้ย?");
                },
                success: function(data) {
                    // alert(data);
                    // $("p").text(data);
                    load_comment();
                }
            });
        });



        $(document).on('click', '.reply', function(){
            var comment_id = $(this).attr("id");
            var comment_to = $(this).attr("comment_to");
            $('#comment_id').val(comment_id);
            $('#comment_content').focus();
            //alert("ขณะนี้ท่านกำลังตอบกลับความคิดเห็น กรุณาพิมพ์ชื่อและรายละเอียดแล้วกด ' โพสต์ '"); // แจ้งเตือนว่ากำลังตอบกลับความคิดเห็น
            $('#comment_message').html('<div class="alert alert-warning">ขณะนี้ท่านกำลังตอบกลับความคิดเห็นของ '.concat(comment_to).concat('</div>'));
        });

    });
</script>
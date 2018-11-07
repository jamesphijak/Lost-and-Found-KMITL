<style rel="stylesheet">
    img {
        object-fit: contain;
    }

</style>

<div class="row">
    <div class="col-md-12">
    <h3 class="text-center"><?= $post->post_name ?></h3><hr>
    </div>
    <div class="col-md-4">
        <?php
        if ($post->post_imgurl1 == "") {
            $image = "image-not-found.jpg";
        } else {
            $image = $post->post_imgurl1;
        }
        ?>
        <img src="<?= base_url("uploads/") . $image ?>" alt="" class="img-thumbnail">
    </div>
    <div class="col-md-8">
        <br>
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
        <span id="comment_message"></span>
        <form method="POST" id="comment_form">
            <div class="form-group">
<!--                <input type="hidden" name="user_id" id="user_id" class="form-control" value="--><?//= $_SESSION['user_id'] ?><!--" />-->
<!--                <input type="hidden" name="post_id" id="post_id" class="form-control" value="--><?//= $page_post_id ?><!--" />-->
                <textarea name="comment_content" id="comment_content" class="form-control" placeholder="ข้อมูลความคิดเห็น" rows="5"></textarea>
            </div>
            <div class="form-group">
                <input type="hidden" name="comment_id" id="comment_id" value="0" />
                <button type="submit" name="submit" id="submit" class="btn btn-success"><i class="fas fa-comment"></i> แสดงความคิดเห็น</button>
                <a class="btn btn-danger" href="<?= base_url('post/view/'.$post->post_id) ?>"><i class="fas fa-ban"></i> ยกเลิก</a>
            </div>
        </form>


        <div class="my-3 p-3 bg-white rounded shadow-sm" id="display_comment">
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){

        startRefresh();

        function startRefresh() {
            setTimeout(startRefresh,1000);
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
                        // load_comment();
                    }
                }
            })
        });

        // load_comment();
        //
        //function load_comment()
        //{
        //    $.ajax({
        //        url:"<?//= base_url('post/fetch_comment/'.$page_post_id) ?>//",
        //        method:"POST",
        //        success:function(data)
        //        {
        //            $('#display_comment').html(data);
        //        }
        //    })
        //}

        $(document).on('click', '.remove', function(){
            var comment_id = $(this).attr("id");
            $.ajax({
                type: 'POST',
                url: '<?= base_url('post/remove_comment/')?>'.concat(comment_id),
                beforeSend:function(){
                    return confirm("คุณต้องการลบใช่มั้ย?");
                }
                // success: function(data) {
                //     alert(data);
                //     $("p").text(data);
                //
                // }
            });
        });

        $(document).on('click', '.reply', function(){
            var comment_id = $(this).attr("id");
            $('#comment_id').val(comment_id);
            $('#comment_content').focus();
            //alert("ขณะนี้ท่านกำลังตอบกลับความคิดเห็น กรุณาพิมพ์ชื่อและรายละเอียดแล้วกด ' โพสต์ '"); // แจ้งเตือนว่ากำลังตอบกลับความคิดเห็น
        });

    });
</script>
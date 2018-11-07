<style rel="stylesheet">
    img {
        object-fit: contain;
    }

</style>

<div class="col-md-12">
        <h5 class="text-center"><?= $title ?></h5>

            <table id="data" class="table table-striped table-bordered" >
                <thead>
                <tr class="text-center">
                    <th>รูป</th>
                    <th>ชื่อ</th>
                    <th>หมวดหมู่</th>
                    <th>สี</th>
                    <th>เมื่อ</th>
                    <th>โดย</th>

                </tr>
                </thead>
                <tbody>
                <?php foreach ($posts as $row) : ?>
                    <tr class="text-center" onclick="window.location='<?= base_url('post/view/'.$row->post_id)?>';">
                        <td>
                            <img class="rounded" src=' <?= base_url("uploads/") . $row->post_imgurl1 ?>' data-holder-rendered='true' style='width: 50px; height: 50px;'>
                        </td>
                        <td><?= $row->post_name ?></td>
                        <td><?= $row->category_name ?></td>
                        <td><?= $row->color_name ?></td>
                        <td><?= $this->template->normalDatetime($row->post_created) ?></td>
                        <td><?= $row->user_email ?></td>

                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#data').DataTable({
            <?= (count($posts) == 0)?"\"searching\": false,\"paging\": false,\"info\": false,":'' ?>
            // columnDefs: [{"orderable": false, "targets": 5}],
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "ทั้งหมด"]],
            order: [[ 2, "desc" ]],
            language: {
                search: "ค้นหา",
                paginate: {
                    first: "หน้าแรก",
                    previous: "ก่อนหน้า",
                    next: "ถัดไป",
                    last: "สุดท้าย"
                },
                info: "แสดงหน้า _PAGE_ จากทั้งหมด _PAGES_",
                lengthMenu: "แสดง _MENU_ รายการ",
                zeroRecords: "ไม่พบข้อมูล",
            }
        });

    });

</script>
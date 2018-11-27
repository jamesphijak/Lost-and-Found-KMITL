<div class="col-md-9">
    <div class="card">
        <h5 class="card-header bg-primary text-white">รายการประกาศที่ยังไม่ได้อนุมัติ</h5>
        <div class="card-body">

            <table id="data" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>ชื่อ</th>
                    <th>สร้างเมื่อ</th>
                    <th>สร้างโดย</th>
                    <th>สี</th>
                    <th>เปลี่ยนสถานะ</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($posts_not_approve as $row) : ?>
                    <tr>
                        <td><?= $row->post_id ?></td>
                        <td><?= $row->post_name ?></td>
                        <td><?= $row->post_created ?></td>
                        <td><?= $row->user_email ?></td>
                        <td><?= $row->color_name ?></td>
                        <td>
                            <a href="<?= base_url('admin/postApprove/' . $row->post_id) ?>"
                               class="btn btn-sm btn-primary"><i class="fas fa-check-circle"></i> อนุมติ</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <br>
    <div class="card">
        <h5 class="card-header bg-primary text-white">รายการประกาศที่อนุมัติแล้ว</h5>
        <div class="card-body">

            <table id="data2" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>ชื่อ</th>
                    <th>สร้างเมื่อ</th>
                    <th>สร้างโดย</th>
                    <th>สี</th>
                    <th>เปลี่ยนสถานะ</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($posts_approved as $row) : ?>
                    <tr>
                        <td><?= $row->post_id ?></td>
                        <td><?= $row->post_name ?></td>
                        <td><?= $row->post_created ?></td>
                        <td><?= $row->user_email ?></td>
                        <td><?= $row->color_name ?></td>
                        <td>
                            <a href="<?= base_url('admin/postUnapprove/' . $row->post_id) ?>"
                               class="btn btn-sm btn-danger"><i class="fas fa-ban"></i> เลิกอนุมติ</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
</div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#data').DataTable({
            columnDefs: [{"orderable": false, "targets": 5}],
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

        $('#data2').DataTable({
            columnDefs: [{"orderable": false, "targets": 5}],
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
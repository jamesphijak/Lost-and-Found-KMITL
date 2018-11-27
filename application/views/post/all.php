<div class="col-md-12">
    <div class="card">
        <h5 class="card-header bg-primary text-white">รายการประกาศที่ยังไม่ได้อนุมัติ</h5>
        <div class="card-body">

            <table id="data" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>ชื่อ</th>
                    <th>เมื่อ</th>
                    <th>โดย</th>
                    <th>สี</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($posts_not_approve as $row) : ?>
                    <tr>
                        <td><?= $row->post_id ?></td>
                        <td><?= $row->post_name ?></td>
                        <td><?= $this->template->normalDatetime($row->post_created) ?></td>
                        <td><?= $row->user_email ?></td>
                        <td><?= $row->color_name ?></td>
                        <td>
                            <a href="<?= base_url('admin/post/approve/' . $row->post_id) ?>"
                               class="btn btn-sm btn-primary"><i class="fas fa-check-circle"></i> อนุมติ</a>
                            <a target="_blank" href="<?= base_url('post/view/' . $row->post_id) ?>"
                               class="btn btn-sm btn-secondary"><i class="fas fa-eye"></i></a>
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
            <?= (count($posts_not_approve) == 0)?"\"searching\": false,\"paging\": false,\"info\": false,":'' ?>
            columnDefs: [{"orderable": false, "targets": 5}],
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
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header text-left bg-primary text-white text-center"><i class="fas fa-user-circle"></i> <?= $title ?></h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-10">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm table-bordered">
                                <tbody>
                                    <tr class="d-flex">
                                        <td class="col-4" align="right">อีเมล</td>
                                        <td class="col-8"><?= $user->user_email ?></td>
                                    </tr>
                                    <tr class="d-flex">
                                        <td class="col-4" align="right">เบอร์โทรศัพท์</td>
                                        <td class="col-8"><?= empty($user->user_mobile)? 'ยังไม่ได้เพิ่มเบอร์โทรศัพท์':$user->user_mobile ?></td>
                                    </tr>
                                    <tr class="d-flex">
                                        <td class="col-4" align="right">ประเภทสมาชิก</td>
                                        <td class="col-8"><?= $user->user_type ?></td>
                                    </tr>
                                    <tr class="d-flex">
                                        <td class="col-4" align="right">วันที่เป็นสมาชิก</td>
                                        <td class="col-8"><?= $this->template->thaiNormalDatetime($user->user_created) ?></td>
                                    </tr>
<!--                                    <tr class="d-flex">-->
<!--                                        <td class="col-4" align="right">แก้ไขข้อมูล่าสุด</td>-->
<!--                                        <td class="col-8">--><?//= $this->template->normalDatetime($user->user_updated) ?><!--</td>-->
<!--                                    </tr>-->
                                </tbody> 
                            </table>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <a href="<?= base_url('user/editProfile') ?>" class="btn btn-outline-success btn-block"><i class="fas fa-edit"></i> แก้ไขข้อมูล</a>
                        <a href="<?= base_url('user/editPassword') ?>" class="btn btn-outline-primary btn-block"><i class="fas fa-edit"></i> แก้ไขรหัสผ่าน</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<br>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header text-left bg-primary text-white text-center">รายการประกาศของฉัน</h5>
            <div class="card-body">
                <style rel="stylesheet">
                    img {
                        object-fit: contain;
                    }

                </style>

                <div class="col-md-12">
                    <?php if(count($posts) == 0){ ?>
                        <div class="col-md-12 text-center">
                            <h6 class="text-danger">ยังไม่มีรายการประกาศ</h6>
                        </div>
                    <?php }else{ ?>
                    <table id="data" class="table table-striped table-bordered" >
                        <thead>
                        <tr class="text-center">
                            <th>ลบ</th>
                            <th>รูป</th>
                            <th>ชื่อ</th>
                            <th>ประเภท</th>
                            <th>วันหมดอายุ</th>
                            <th>สถานะ</th>
                            <th>แก้ไข</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($posts as $row) : ?>
                            <tr class="text-center" >
                                <td>
                                    <a onclick="return confirm('คุณต้องการลบใช่มั้ย?');" href="<?= base_url("admin/deleteCategory/{$row->category_id}")?>" class="btn btn-danger btn-block btn-sm"><i class="fas fa-trash-alt"></i></a>
                                </td>
                                <td>
                                    <img class="rounded" src=' <?= base_url("uploads/") . $row->post_imgurl1 ?>' data-holder-rendered='true' style='width: 50px; height: 50px;'>
                                </td>
                                <td><?= $row->post_name ?></td>
                                <td><?= ($row->post_type == 'lost')? 'ของหาย':'พบของหาย'; ?></td>
                                <td><?= $this->template->thaiNormalDate($row->post_expire) .' ('.$this->template->dayLeft($row->post_expire).')' ?></td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-secondary btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <?= $row->post_status ?>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <h6 class="dropdown-header">สถานะประกาศ</h6>
                                            <?php if ($row->user_type == 'Admin'){?>
                                                <a class="dropdown-item" href="<?= base_url('admin/user/member/' . $row->user_id) ?>">Member</a>
                                            <?php }else{ ?>
                                                <a class="dropdown-item"  href="<?= base_url('admin/user/admin/' . $row->user_id) ?>">Admin</a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </td>
                                <td><a href="<?= base_url("admin/category/{$row->category_id}")?>" class="btn btn-success btn-block btn-sm">แก้ไข</a></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#data').DataTable({
            <?= (count($posts) == 0)?"\"searching\": false,\"paging\": false,\"info\": false,":'' ?>
            columnDefs: [{"orderable": false, "targets": [0,1,5,6]}],
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "ทั้งหมด"]],
            order: [[ 3, "desc" ]],
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

    <div class="col-md-9">
      <div class="card">
  <h5 class="card-header bg-primary text-white"><?= $title ?></h5>
  <div class="card-body">
    

<table id="user" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>อีเมล</th>
                <th>เบอร์โทรศัพท์</th>
                <th>ประเภท</th>
                <th>วันที่สมัคร</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users as $row) : ?>
            <tr>
                <td><?= $row->user_id ?></td>
                <td><?= $row->user_email ?></td>
                <td><?= $row->user_mobile ?></td>
                <td>
                    <div class="dropdown">
                        <a class="btn btn-secondary btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?= $row->user_type ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <?php if ($row->user_type == 'Admin'){?>
                            <a class="dropdown-item" href="<?= base_url('admin/user/member/' . $row->user_id) ?>">Member</a>
                            <?php }else{ ?>
                            <a class="dropdown-item"  href="<?= base_url('admin/user/admin/' . $row->user_id) ?>">Admin</a>
                            <?php } ?>
                        </div>
                    </div>
                </td>
                <td><?= $this->template->normalDatetime($row->user_created) ?></td>
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
  $(document).ready(function() {
    $('#user').DataTable({
      <?= (count($users) == 0)?"\"searching\": false,\"paging\": false,\"info\": false,":'' ?>
      language: {
        search: "ค้นหา",
        paginate: {
            first:      "หน้าแรก",
            previous:   "ก่อนหน้า",
            next:       "ถัดไป",
            last:       "สุดท้าย"
        },
        info: "แสดงหน้า _PAGE_ จากทั้งหมด _PAGES_",
        lengthMenu:    "แสดง _MENU_ รายการ",
        zeroRecords: "ไม่พบข้อมูล",
        }
    });
} );
</script>
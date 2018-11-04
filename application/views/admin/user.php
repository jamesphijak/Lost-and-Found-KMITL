
    <div class="col-md-9">
      <div class="card">
  <h5 class="card-header bg-primary text-white"><?= $title ?></h5>
  <div class="card-body">
    

<table id="example" class="table table-striped table-bordered" style="width:100%">
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
                <td><?= $row->id ?></td>
                <td><?= $row->email ?></td>
                <td><?= $row->mobile ?></td>
                <td><?= $row->user_type ?></td>
                <td><?= $this->template->normalDatetime($row->created) ?></td>
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
    $('#example').DataTable({
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
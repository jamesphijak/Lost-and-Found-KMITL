
    <div class="col-md-9">
      <div class="card">
  <h5 class="card-header bg-primary text-white"><?= $title ?></h5>
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
            <?php foreach($posts as $row) : ?>
            <tr>
                <td><?= $row->id ?></td>
                <td><?= $row->name ?></td>
                <td><?= $row->created ?></td>
                <td><?= $row->email ?></td>
                <td><?= $row->color_name ?></td>
                <td>Change</td>
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
    $('#data').DataTable({
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
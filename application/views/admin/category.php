
    <div class="col-md-9">
      <div class="card">
  <h5 class="card-header bg-primary text-white"><?= $title .' / มีข้อมูลทั้งหมด ( '. count($categories) .' รายการ )'?></h5>
  <div class="card-body">
    

    <table class="table" style="width:100%">
        <thead>
                <tr class="no-border">
                    <form method="post">
                        <td width="120"><input type="text" value="<?= isset($category->id)? $category->id : '' ?>" name="id" readonly class="form-control"></td>
                        <td>
                            <input type="text" placeholder="ใส่ชื่อหมวดหมู่" name="name" value="<?= set_value('name',isset($category->name)? $category->name : '') ?>" class="form-control">
                            <small class="text-danger" ><b><?=form_error('name')?></b></small>
                        </td>
                        
                        <td>
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary btn-block">บันทึก</button>
                            </div>
                            <div class="col">
                                <a href="<?= base_url('admin/category')?>" class="btn btn-secondary btn-block">ยกเลิก</a>
                            </div>
                        </div>
                        </td>
                    </form>
                </tr>


<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
               
            <tr>
                <th>#</th>
                <th>สี</th>
                <th>ดำเนินการ</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($categories as $row) : ?>
            <tr>
                    <th><?= $row->id ?></th>
                    <td><?= $row->name ?></td>
                    <td>
                        <div class="row">
                            <div class="col">
                                <a href="<?= base_url("admin/category/{$row->id}")?>" class="btn btn-success btn-block btn-sm">แก้ไข</a>
                            </div>
                            <div class="col">
                                <a onclick="return confirm('คุณต้องการลบใช่มั้ย?');" href="<?= base_url("admin/deleteCategory/{$row->id}")?>" class="btn btn-danger btn-block btn-sm">ลบ</a>
                            </div>
                        </div>
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
  $(document).ready(function() {
    $('#example').DataTable({
      
      order: [[ 0, "desc" ]],
      columnDefs: [{ "orderable": false, "targets": 2 }],
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
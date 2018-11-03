<div class="row">
        <div class="col-md-4 order-md-2 mb-4">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span>ของที่คล้ายกัน</span>
            <span class="badge badge-primary badge-pill">3</span>
          </h4>
          <ul class="list-group mb-3">
            <li class="list-group-item d-flex justify-content-between">
            <span class="pull-left ">
             <img src="<?= base_url("assets/upload_images/")."test.png" ?>" width="80px" style="margin-top:10px;" class="img-reponsive img-rounded" />
            </span>
                <div class="text-left" style="margin-right:90px;"> กระเป๋าตังค์<br>หมวดหมู่ : กระเป๋า <br>สี : ดำ</div>
            </li>
          </ul>


          
        </div>
        <div class="col-md-8 order-md-1">
        <h4 class="mb-3">ลงประกาศของหาย</h4>
        <hr class="mb-4">
          <form class="needs-validation" novalidate="">

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="country">หมวดหมู่</label>
                <select class="custom-select d-block w-100" id="country" required="">
                  <option value="">เลือกหมวดหมู่...</option>
                  <option>United States</option>
                </select>
                <div class="invalid-feedback">
                  Please select a valid country.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="state">สี</label>
                <select class="custom-select d-block w-100" id="state" required="">
                  <option value="">เลือกสี...</option>
                  <option>California</option>
                </select>
                <div class="invalid-feedback">
                  Please provide a valid state.
                </div>
              </div>
            </div>
            <hr class="mb-4">

            <div class="row">
              <div class="col-md-12 mb-3">
                <label for="firstName">ชื่อ</label>
                <input type="text" class="form-control" id="firstName" placeholder="" value="">
                <div class="invalid-feedback">
                  Valid first name is required.
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="address">รายละเอียดเกี่ยวกับของ</label>
              <textarea type="text" class="form-control" rows="3" ></textarea>
              <div class="invalid-feedback">
                Please enter your shipping address.
              </div>
            </div>

            <h4 class="mb-3">รูปภาพ</h4>
            <hr class="mb-4">
            
            <hr class="mb-4">
            <button class="btn btn-success btn-lg btn-block" type="submit">ยืนยันการลงประกาศ</button>
          </form>
        </div>
      </div>
<div class="row">
        <div class="col-md-4 order-md-2 mb-4" id="txtHint">
        <h5 class="d-flex border-bottom border-gray pb-2 mb-0">ไม่พบประกาศของที่ถูกพบ</h5>
        
        </div>
        <div class="col-md-8 order-md-1">
        <h4 class="mb-0">ลงประกาศของหาย</h4>
        <hr class="mb-4">
          <form class="needs-validation" novalidate="">

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="country">หมวดหมู่</label>
                <select class="custom-select d-block w-100" id="categoryOfItem" >
                  <option value="">เลือกหมวดหมู่...</option>
                   <?php foreach($categories as $row) : ?>
                   <option value="<?= $row->id ?>"><?= $row->name.' ('.$row->id.')' ?></option>
                   <?php endforeach; ?>
                   

                </select>
                <div class="invalid-feedback">
                  Please select a valid country.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="state">สี</label>
                <select class="custom-select d-block w-100" id="colorOfItem" >
                  <option value="">เลือกสี...</option>
                  <?php foreach($colors as $row) : ?>
                   <option value="<?= $row->id ?>"><?= $row->name.' ('.$row->id.')' ?></option>
                   <?php endforeach; ?>
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
                <input type="text" class="form-control" placeholder="" value="">
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


      <script>

          function clickableRow(){
            $(".clickable-row").click(function() {
                window.location = $(this).data("href");
            });
          }

          function find(str) {
            if (window.XMLHttpRequest) {
              // Code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp=new XMLHttpRequest();
            } else {  // Code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function() {
              if (this.readyState==4 && this.status==200) {
                document.getElementById("txtHint").innerHTML=this.responseText;
                clickableRow();
              }
            }
            xmlhttp.open("GET","<?= base_url('post/loadLost')?>?search="+str,true);
            xmlhttp.send();
          }

          $(document).ready(function(){
              var inp = {category:"",color:""};
              var str;
          
              $('#categoryOfItem').change(function(){
                inp['category'] = $(this).val();
                // showUser($(this).val());
                str = JSON.stringify(inp);
                find(str);
              });
                 
              $('#colorOfItem').change(function(){
                inp['color'] = $(this).val();
                // showUser($(this).val());
                str = JSON.stringify(inp);
                find(str);
              });
        });
        </script>
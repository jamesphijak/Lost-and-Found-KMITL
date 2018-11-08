<div class="row">
        <div class="col-md-4 order-md-2 mb-4" id="txtHint">
        <h5 class="d-flex border-bottom border-gray pb-2 mb-0">ไม่พบประกาศของที่ถูกพบ</h5>
        
        </div>
        <div class="col-md-8 order-md-1">
        <h4 class="mb-0"><?= $title ?></h4>
        <hr class="mb-4">
           <!-- Message -->
           <?php if(isset($_SESSION['success'])){ ?>
                    <div class="alert alert-success" role="alert"><?= $_SESSION['success'] ?></div>
                <?php } ?>
                <?php if(isset($_SESSION['error'])){ ?>
                    <div class="alert alert-danger" role="alert"><?= $_SESSION['error'] ?></div>
                <?php } ?>
                
          <form class="form-group" method="post">
            <?php $select = "" ?>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="country">หมวดหมู่</label>
                <select class="custom-select d-block w-100" id="categoryOfItem" name="category">
                  <option value="">เลือกหมวดหมู่...</option>
                   <?php foreach($categories as $row) : 
                    if(set_value('category') != null){
                      if(set_value('category') == $row->id){
                        $select = "selected";
                      }else{
                        $select = "";
                      }
                    }
                    ?>

                   <option <?= $select ?> value="<?= $row->id ?>"><?= $row->category_name.' ('.$row->id.')' ?></option>
                   <?php endforeach; ?>
                      
                </select>
                <small class="text-danger"><b><?= form_error('category')?> </b></small>

              </div>
              <div class="col-md-6 mb-3">
                <label for="state">สี</label>
                <select class="custom-select d-block w-100" id="colorOfItem" name="color">
                  <option value="">เลือกสี...</option>
                  <?php foreach($colors as $row) : 
                  if(set_value('color') != null){
                    if(set_value('color') == $row->id){
                      $select = "selected";
                    }else{
                      $select = "";
                    }
                  }  
                    
                  ?>
                   <option <?= $select ?> value="<?= $row->id ?>"><?= $row->color_name.' ('.$row->id.')' ?></option>
                   <?php endforeach; ?>
                </select>
                <small class="text-danger"><b><?= form_error('color')?></b></small>

              </div>
            </div>
            <hr class="mb-4">

            <div class="row">
              <div class="col-md-12 mb-3">
                <label for="firstName">ชื่อ</label>
                <input type="text" class="form-control" placeholder="ใส่ชื่อ" value="<?= set_value('name') ?>" name="name">
                <small class="text-danger"><b><?= form_error('name')?></b></small>
              </div>
            </div>

            <div class="mb-3">
              <label for="address">รายละเอียดเกี่ยวกับของ</label>
              <textarea type="text" class="form-control" rows="5" name="description" placeholder="ใส่รายละเอียดของ" ><?= set_value('description') ?></textarea>
              <small class="text-danger"><b><?= form_error('description')?></b></small>
            </div>

            <h4 class="mb-3">รูปภาพ</h4>
            <hr class="mb-4">
            
            <hr class="mb-4">
            <button class="btn btn-success btn-lg btn-block" type="submit">ยืนยันการลงประกาศ</button>
          </form>
        </div>
      </div>


      <script>

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
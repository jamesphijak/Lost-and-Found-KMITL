
    <div class="col-md-9">
      <div class="card">
  <h5 class="card-header bg-primary text-white"><?= $title ?></h5>
  <div class="card-body">
      <div id="chartContainer" style="height: 370px; width: 100%;"></div>
  </div>
</div>
    </div>
  </div>
</div>

    <?php

    $data = array(
        array("y" => $count_member, "label" => "Member" ),
        array("y" => $count_admin, "label" => "Admin" ),
        array("y" => $count_lost, "label" => "Lost" ),
        array("y" => $count_found, "label" => "Found" ),
    );


    ?>

    <script>

        window.onload = function() {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",

                data: [{
                    type: "column",
                    dataPoints: <?php echo json_encode($data, JSON_NUMERIC_CHECK); ?>
                }]
            });


            chart.render();

        }

    </script>

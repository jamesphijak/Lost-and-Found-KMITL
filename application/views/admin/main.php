
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

    $dataPoints = array(
        array("y" => 3373.64, "label" => "Member" ),
        array("y" => 2435.94, "label" => "Admin" ),
        array("y" => 1842.55, "label" => "Lost" ),
        array("y" => 1828.55, "label" => "Found" ),
    );

    ?>

    <script>

        window.onload = function() {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",

                data: [{
                    type: "column",
                    yValueFormatString: "#,##0.## tonnes",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();

        }

    </script>

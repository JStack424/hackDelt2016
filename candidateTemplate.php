<!-- includes basic html info, meta info, link to bootstrap css, link to custom css -->
<?php include 'head.php'; ?>
  </head>
  <body>
<?php include 'nav.php'; ?>
      <?php
      $name = $_GET["name"];

      include 'config.php';
    //$row = array();
    $sql = "SELECT `Id`, `Name`, `Age`, `Ethnicity`, `Religion`, `Gender`, `Education`, `Political Experience` FROM `Demographics` WHERE Name='" . $name . "'";
    if ($result = mysqli_query($conn, $sql)) {
        $row = mysqli_fetch_assoc($result);
    }
      ?>
      <div class="container mainInfo">

        <h1 class='nameOfCandidate'> <?php echo $row['Name']; ?> </h1>

        <div class='demographicInfo'>
            <h3> Demographics</h3>
            <ul class='demographicsList'>
                <?php
                foreach ($row as $key => $i) {
                    echo '<li><b>' . $key . ":</b> " . $i . '</li>';
                }

                ?>
            </ul>
        </div>

        <div class='searchBox'>
            <div class='resultsFromSearch'>
            </div>
        </div>

        <div class='endorsements'>

        </div>

        <div class='money'>

            <canvas id="myChart" width="400" height="400"></canvas>
        </div>

    </div><!-- /.container -->

    <!-- includes footer and bootsrap js and jquery-->
    <?php include'footer.php'; ?>
                  <script>
            // For a pie chart
            var myPieChart = new Chart(ctx[0]).Pie(data,options);
                var data = [
                    {
                        value: 300,
                        color:"#F7464A",
                        highlight: "#FF5A5E",
                        label: "Red"
                    },
                    {
                        value: 50,
                        color: "#46BFBD",
                        highlight: "#5AD3D1",
                        label: "Green"
                    },
                    {
                        value: 100,
                        color: "#FDB45C",
                        highlight: "#FFC870",
                        label: "Yellow"
                    }
                ]
            </script>

</body>
</html>

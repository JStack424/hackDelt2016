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

        </div>

        <div class='searchBox'>
            <div class='resultsFromSearch'>
            </div>
        </div>

        <div class='endorsements'>

        </div>

        <div class='money'>
        </div>

    </div><!-- /.container -->

    <!-- includes footer and bootsrap js and jquery-->
    <?php include'footer.php'; ?>

</body>
</html>

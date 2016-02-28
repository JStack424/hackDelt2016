<?php
    $potentialIssues = array('Abortion','Marriage','Planned Parenthood','Guns','Privacy','Drugs','Social Security','Obamacare','Wage','Taxes','Immigration','Education','Wealth Inequality','Terrorism','Isis','Global Warming');
    $name = $_GET["name"];
    ?>
<!-- includes basic html info, meta info, link to bootstrap css, link to custom css -->
<?php include 'head.php'; ?>
</head>
<body>
<?php include 'nav.php'; ?>
<?php
    include 'config.php';
    //$row = array();
    $sql = "SELECT `Name`, `Age`, `Ethnicity`, `Religion`, `Gender`, `Education`, `Political Experience` FROM `Demographics` WHERE Name='" . $name . "'";
    if ($result = mysqli_query($conn, $sql)) {
        $row = mysqli_fetch_assoc($result);
    }
    ?>
<div class="container mainInfo candidateBg">
<img src= <?php echo "css/" . substr($name, 0, 3) . ".png"; ?> style="width: 20%; height: auto; margin-left: 40%;"/>
<h1 class='nameOfCandidate'><strong> <?php echo $row['Name']; ?></strong> </h1>

<div class='demographicInfo col-md-6'>
<h3 class='text-centered'> <u>Demographics</u> </h3>
<ul class='demographicsList'>
<?php
    foreach ($row as $key => $i) {
        echo '<li><b>' . $key . ":</b> " . $i . '</li>';
    }
    ?>
</ul>
</div>

<div class='money col-md-6'>
<h3 class='text-centered'> <u>Financial Contributions</u> </h3>
<canvas id="myChart" width="450" height="300" style='display:block;margin: 15px auto;'></canvas>
</div>

<div class='searchBox col-md-12' style="margin-left: auto;">
<h4 style="text-align: center;"> Use the box below to search twitter for recent keywords involving <?php echo $name;?> </h4>
<form id='form'>
<?php
    /*for ($k = 0; $k < 3;$k++) {
     echo "<div class='col-md-4' style='padding-left: 5px;padding-right:5px;text-align:center;'>";
     for ($i=(count($potentialIssues)/3 * $k);$i < (((count($potentialIssues)/3) * ($k+1))-1);$i++) {
     echo "<div class='col-md-4' style='margin: 0;'> <label style='font-weight:300;margin: 0 auto;'> <input type='checkbox' value='" . str_replace(" ", "", $potentialIssues[$i]) . "' name='" . str_replace(" ", "", $potentialIssues[$i]) . "'> " . $potentialIssues[$i] . "</label> </div>";
     }
     echo '</div>';
     }*/
    ?>
    <button class='form-control' id='stuff' name='form' style="width: 20%; height: 30px; float: left; margin-left: 15%;"> Search Twitter </button>
<?php
    echo "<input id='text type='text' name='text' style='width: 50%; height: 30px; float: left; margin-bottom: 10px;'>";
    echo "<input id='".$name."' type='hidden' name='name' value='".$name."'/>"
    ?>

</form>


<div class='resultsFromSearch'>
<div class="col-md-4" style="border-right: dotted 1px black;">  <!--first column -->
<h2 id='candidate' style="text-align: center;"> Candidate Account </h2>
</div>

<div class="col-md-4">
<h2 id='press' style="text-align: center;">Press Coverage</h2>
</div>

<div class="col-md-4" style="border-left: dotted 1px black;">
<h2 id='people' style="text-align: center;"> Buzz Among People </h2>
</div>
</div>
</div>

<div class='endorsements'>

</div>

</div><!-- /.container -->

<!-- includes footer and bootsrap js and jquery-->
<?php include'footer.php'; ?>
<script>
// For a pie chart
// Get the context of the canvas element we want to select
// Get context with jQuery - using jQuery's .get() method.
var ctx = $("#myChart").get(0).getContext("2d");
// This will get the first returned node in the jQuery collection.
var myNewChart = new Chart(ctx);
<?php
    $sqlFin = "SELECT `Id`, `Name`, `ind_over200`, `ind_under200`, `ind_tot_contributions`, `OtherCommitteeContribution`, `Personal_Contributions`, `Total_Contributions` FROM `Financials` WHERE Name='" . $name . "'";
    if ($resultFin = mysqli_query($conn, $sqlFin)) {
        $rowFin = mysqli_fetch_assoc($resultFin);
    }
    echo "var data = [
    {
    value: " . $rowFin["ind_over200"] .",
    color:'#F7464A',
    highlight: '#FF5A5E',
    label: 'Individual Contributions Over $200'
    },
    {
    value: " . $rowFin["ind_under200"] . ",
    color: '#2EFE2E',
    highlight: '#00FF00',
    label: 'Individual Contributions Under $200'
    },
    {
    value: " . $rowFin["OtherCommitteeContribution"] . ",
    color: '#46BFBD',
    highlight: '#5AD3D1',
    label: 'Other Contributions (Super PACs)'
    },
    {
    value: " . $rowFin["Personal_Contributions"] . ",
    color: '#FDB45C',
    highlight: '#FFC870',
    label: 'Personal Contributions'
    }
    ];";
    echo 'var myPieChart = new Chart(ctx).Pie(data);
    ';
    ?>
</script>

<script>
$('#stuff').click(function(e) {
                  e.preventDefault();
                  // Call the getData function
                  getData();
                  
                  // The function that makes the request to our PHP script
                  function getData()
                  {
                  // Ajax call
                  $.ajax({
                         type: "POST",
                         url: "twitter/TwitterQuery.php",
                         dataType: "json",
                         data: $('#form').serialize(),
                         success: response
                         });
                  }
                  
                  // This function runs once we get our data from PHP
                  function response(json)
                  {
                  console.log(json);
                  $("#candidate").append(json[0]).fadeIn(1000);
                  $("#press").append(json[1]).fadeIn(1000);
                  $("#people").append(json[2]).fadeIn(1000);
                  $.getScript("http://platform.twitter.com/widgets.js", function () {});
                  }
                  });
</script>

</body>
</html>
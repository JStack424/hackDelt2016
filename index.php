<!-- includes basic html info, meta info, link to bootstrap css, link to custom css -->
<?php include 'head.php'; ?>
  </head>
  <body>
<?php
    include 'nav.php';
?>

    <div class="container mainInfo">
        <div class='col-md-12 topHome'>
            <h1 style='text-align:center;margin-top:15px;'> Election Overview </h1>
            <div id='currentStanding'>
                <div id="tickerDiv">
                    <div id="ticker" class="stockTicker">
                        <span class="quote">Stock Quotes: </span>
                        <?php
                            include 'dataFunctions.php';
                            $candidates = retrieveElectionData();
                            formatTickerData($candidates);
                        ?>
                    </div>
                </div>
            </div>
            <div id='trendingTopics' class='col-md-6'>
                <h2 style='text-align:center;margin-top:10px;'> Trending Topics On The Election </h2>
                
            </div>

            <div id='upcomingEvents' class='col-md-6'>
                <h2 style='text-align:center;margin-top:10px;'> Upcoming Primary Dates </h2>
                <?php
                    printUpcomingCaucus(10);
                ?>
            </div>
        </div>

        <div id='leftHome' class='col-sm-6 partyDiv'>
            <img src='http://img.photobucket.com/albums/v53/mike_kwiatkowski/DemocratDonkey1.png' class='partyImg'>
            <ul class='Candidates left'>
                <a href='candidateTemplate.php?name=Hillary%20Clinton'> <li>
                    Hillary Clinton
                </li> </a>
                <a href='candidateTemplate.php?name=Bernie%20Sanders'> <li>
                    Bernie Sanders
                </li> </a>
            </ul>
        </div>

        <div id='rightHome' class='col-md-6 partyDiv'>
            <img src='https://upload.wikimedia.org/wikipedia/commons/thumb/9/9b/Republicanlogo.svg/2000px-Republicanlogo.svg.png' class='partyImg'>
            <ul class='Candidates right'>
                <a href='candidateTemplate.php?name=Donald%20Trump'> <li>
                    Donald Trump
                </li> </a>
                <a href='candidateTemplate.php?name=Marco%20Rubio'> <li>
                    Marco Rubio
                </li> </a>
                <a href='candidateTemplate.php?name=Ted%20Cruz'> <li>
                    Ted Cruz
                </li> </a>
                <a href='candidateTemplate.php?name=John%20Kasich'> <li>
                    John Kasich
                </li> </a>
             </ul>
        </div>

        <div id='compareCandidates'>
        </div>

    </div><!-- /.container -->

      <!-- includes footer-->
      <?php include'footer.php'; ?>

    <script src='stockTicker.js'> </script>
    <script type="text/javascript">
        $(function() {
            $("#ticker").jStockTicker({interval: 40});
        });
    </script>


</body>
</html>

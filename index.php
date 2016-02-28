<!-- includes basic html info, meta info, link to bootstrap css, link to custom css -->
<?php include 'head.php'; ?>
  </head>
  <body>
<?php
    include 'nav.php';
?>

    <div class="container mainInfo">
<<<<<<< HEAD
        <div class='col-md-12 topHome'> 
=======
        <div class='col-md-12 topHome'>
>>>>>>> 376dcef01cc091c18751efadad6f4f534358ca38
            <div id='currentStanding'>
                <div id="tickerDiv">
                    <div id="ticker" class="stockTicker">
                        <span class="quote">Stock Quotes: </span>
                        <span class="up"><span class="quote">ABC</span> 1.543 0.2%</span>
                        <span class="down"><span class="quote">SDF</span> 12.543 -0.74%</span>
                        <span class="up"><span class="quote">JDF</span> 34.543 5.2%</span>
                        <span class="up"><span class="quote">ERA</span> 123.234 1.2%</span>
                        <span class="down"><span class="quote">DFF</span> 20.543 -5.2%</span>
                        <span class="eq"><span class="quote">CBX</span> 523.234 0.0%</span>
                        <span class="down"><span class="quote">IZF</span> 89.65 -3.4%</span>
                        <span class="up"><span class="quote">KJG</span> 456.64 0.318%</span>
                        <span class="up"><span class="quote">QWE</span> 6413.123 0.012%</span>
                        <span class="eq"><span class="quote">CVN</span> 6.3 0.0%</span>
                        <span class="down"><span class="quote">UIT</span> 74.543 -0.321%</span>
                    </div>
                </div>
            </div>
            <div id='trendingTopics' class='col-md-6'>
                <h2 style='text-align:center;margin-top:10px;'> Trending Topics On The Election </h2>
<<<<<<< HEAD
                
=======

>>>>>>> 376dcef01cc091c18751efadad6f4f534358ca38
            </div>

            <div id='upcomingEvents' class='col-md-6'>
                <h2 style='text-align:center;margin-top:10px;'> Upcoming Primary Dates </h2>
                <?php
<<<<<<< HEAD
                    include 'dataFunctions.php';
                    printUpcomingCaucus(10);
=======
                    include 'electiondates.php';
>>>>>>> 376dcef01cc091c18751efadad6f4f534358ca38
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
            $("#ticker").jStockTicker({interval: 65});
        });
    </script>


</body>
</html>

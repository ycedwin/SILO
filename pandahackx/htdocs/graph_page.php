<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Page introduction
		 This is a graph page help users to get the information they want plot out.-->
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
	<title>SILO</title>

	<!-- CSS  -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
	<link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>

	<style>
		 table, th, td {border: 2px solid gray; border-collapse: collapse;}
		 th, td {width: auto;}
	</style>

	<?php
		//Set up the default information that will be displayed
	    $startdate = '20140101';
        $enddate = '20150102';
        $id = $_SERVER['QUERY_STRING'];
        $stat = $_GET['id'];
				$startYear = $_GET['startyear'];
				$endYear = $_GET['endyear'];
        $station = '1018';
				$dmy = 'daily';

				for ($i=0;$i<count($_POST['var']);$i++)
				{
						 $item[$i]=$_POST['var'][$i];
				}
				$itemJson = json_encode($item);

				$dmyPrev = $_POST['dmy'];
				$dmy = json_encode($dmyPrev);

        // get the submitted information from search page
        if(isset($_POST['submit'])){
			$startdate = $_POST['start-date'];
            $enddate = $_POST['end-date'];
            $station = $stat;
            $title = "Station ".$station." - ".$startdate." - ".$enddate;

						for ($i=0;$i<count($_POST['var']);$i++)
						{
								 $item[$i]=$_POST['var'][$i];
						}
						$itemJson = json_encode($item);

						$dmyPrev = $_POST['dmy'];
						$dmy = json_encode($dmyPrev);
        }

        $sd = explode(" ",$startdate);

		if (strlen($sd[0]) == 1){
			$sd[0]="0".$sd[0];
		}
		$sd[1] = monthchange(rtrim($sd[1],","));
		$ed = explode(" ",$enddate);

		if (strlen($ed[0]) == 1){
			$ed[0]="0".$ed[0];
		}
		$ed[1] = monthchange(rtrim($ed[1],","));
		// modify the month display
		function monthchange($mon){
			if ($mon == "January"){
				return "01";
			} else if ($mon == "February"){
				return "02";
			} else if ($mon == "March"){
				return "03";
			} else if ($mon == "April"){
				return "04";
			} else if ($mon == "May"){
				return "05";
			} else if ($mon == "June"){
				return "06";
			} else if ($mon == "July"){
				return "07";
			} else if ($mon == "August"){
				return "08";
			} else if ($mon == "September"){
				return "09";
			} else if ($mon == "October"){
				return "10";
			} else if ($mon == "November"){
				return "11";
			} else if ($mon == "Desember"){
				return "12";
			}
		}
		//setting up the parameters and send them to require climate information from t he api
		$startdate = $sd[2].$sd[1].$sd[0];
		$enddate = $ed[2].$ed[1].$ed[0];

        $url = "https://siloapi.longpaddock.qld.gov.au/pointdata?apikey=jHJWUsOmEWBG7oDZNyliMAM8ySy9b7Bsx7NcVSM8&start=$startdate&finish=$enddate&station=$station&format=json&variables=max_temp,min_temp,rh_tmax,rh_tmin,daily_rain,evap_pan,vp,radiation";
        $urlJson = file_get_contents($url);
    ?>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.bundle.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
	<script>
		//prepare for title
		var siloText = <?php echo $urlJson;?>;
		var stationName={
			current: siloText.station.name
		};

				console.log(stationName.current);
	</script>
	  <script type="text/javascript" src="js/silodata.js"></script>
    <script>
    		// download the graph contains the climate information that the user have selected
            window.onload = function(){
                document.getElementById('downloadBtn').addEventListener('click', function() {
                    var d = new Date();
                    var filename = "silo_chart_" + d.getFullYear() + "_" + (d.getMonth()+1) + "_" + d.getDate() + "_" + Math.floor((Math.random() * 1000) + 1) + ".png"
                    downloadCanvas(this, 'dataChart', filename);
                }, true);




                var item_json = <?php echo $itemJson;?>;
								var dmy = <?php echo $dmy;?>;
				//move siloText upward, testing
								console.log(item_json);
                console.log(siloText.data[0].date);
								console.log(siloText.data[siloText.data.length-1].date)
								console.log(dmy);
                drawChart(siloText, item_json, dmy);
            }

    </script>
</head>
<body>
  <div class="container outside">

	<nav class="nav-extended grey lighten-4">

	    <div class="nav-wrapper">

	      	<a href="#" class="brand-logo">
		    	<img src="images/logo.png" width="40px">
				<span class="logo-text">
					<strong>Queensland</strong> Government
				</span>
			</a>

	    </div>

	    <div class="nav-content blue darken-2">
		    <div class="row">
			    <div class="col s12">
				    <span class="nav-title">Science Information for Land Owner</span>
			    </div>
				<div class="col s12 light-blue darken-4 navi">

					<ul>
						<li><a href="index.php">Home</a></li>
						<li><a href="about.php">About</a></li>
						<li><a href="search.php">Request Data</a></li>
						<li><a href="api.php">API</a></li>
						<li><a href="faq.php">FAQ</a></li>
						<li><a href="graph_page.php">Visualise Data</a></li>
						<li><a href="contact_us.php">Contact Us</a></li>
					</ul>
				</div>
		    </div>

	    </div>
	</nav>

	<div class="section row">
		<div class="col s12 l3 card setting">
			<div class="col m12">

						<form action="graph_page.php?id=<?php echo $stat;?>&startyear=<?php echo $startYear;?>&endyear=<?php echo $endYear;?>&variables=<?php echo $itemJson;?>&dmy=<?php echo $dmy;?>" method="post">
							<div class="col s12">
								<label class="label"> Start Date </label>
							</div>

							<div class="col s12">
								<div class="input-field col s12">
						            <input type="date" class="datepicker" name="start-date">
								</div>
							</div>

							<div class="col s12">
								<label class="label"> End Date </label>
							</div>

							<div class="col s12">
								<div class="input-field col s12">
						            <input type="date" class="datepicker" name="end-date">
								</div>
							</div>

				<div class="col s12">
				            <label class="label"> Show Data </label>
				</div>

				<div class="col s12">
                			<div class="input-field col s12">
                			<select name="dmy">
                			        <option value=daily selected="selected">Daily</option>
                			        <option value=monthly>Monthly</option>
                			        <option value=yearly>Yearly</option>
                			</select>
				</div>
				</div>

              <div class="col s12">
								<label class="label"> Pick Data Types </label>
							</div>

							<div class="col s12">
								<div class="input-field col s12">
						            <select name="var[]", size=8, multiple="multiple">
						                <option value='T.Max'>T.Max</option>
						                <option value='T.Min'>T.Min</option>
						                <option value='RHmaxT'>RHmaxT</option>
						                <option value='RHminT'>RHminT</option>
						                <option value='Rain'>Rain</option>
						                <option value='Evap'>Evap</option>
						                <option value='Radn'>Radn</option>
						                <option value='VP'>VP</option>
						            </select>
								</div>
							</div>

				            <div class="col s12 button">

					            <button class="btn waves-effect waves-light" name="submit" type="submit">Update Graph</button>

				            </div>
                            <div class="col s12 button">
                                <p id="error_pane" style="margin-top: 20px; color: red;"></p>
				            </div>
				        </form>
					</div>

		</div>
		<div class="col s12 l9">
			<canvas id="dataChart" style="height: 500px"></canvas>
            <form>
            <a class="btn waves-effect waves-light" id="downloadBtn">Download This Graph</a>
            </form>
		</div>


		<div>
		</div>
		<div>
		</div>


	</div>

	<footer class="page-footer blue darken-2">

		<div class="row blue darken-2">
			<div class="col s2 offset-s10 share">
				<strong>Share: </strong>
				<img class="share-pic" src="images/fb-logo.png" height="30px">
				<img class="share-pic" src="images/twit-logo.png" height="30px"> </div>
		</div>

		<div class="col s12 light-blue darken-4">
		    <div class="container">
		      <div class="row">
		        <div class="col l6 s12">
		          <h5 class="white-text">Company Bio</h5>
		          <p class="grey-text text-lighten-4">We are a team of college students working on this project like it's our full time job. Any amount would help support and continue development on this project and is greatly appreciated.</p>


		        </div>
		        <div class="col l3 s12">
		          <h5 class="white-text">Settings</h5>
		          <ul>
		            <li><a class="white-text" href="#!">Link 1</a></li>
		            <li><a class="white-text" href="#!">Link 2</a></li>
		            <li><a class="white-text" href="#!">Link 3</a></li>
		            <li><a class="white-text" href="#!">Link 4</a></li>
		          </ul>
		        </div>
		        <div class="col l3 s12">
		          <h5 class="white-text">Connect</h5>
		          <ul>
		            <li><a class="white-text" href="#!">Link 1</a></li>
		            <li><a class="white-text" href="#!">Link 2</a></li>
		            <li><a class="white-text" href="#!">Link 3</a></li>
		            <li><a class="white-text" href="#!">Link 4</a></li>
		          </ul>
		        </div>
		      </div>
		    </div>
		</div>


	</footer>

  </div>

  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>

  </body>
</html>

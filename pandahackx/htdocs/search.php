<!DOCTYPE html>
<!-- get remote json file of climate stations -->
<?php
$json =file_get_contents("https://siloapi.longpaddock.qld.gov.au/stations");
?>
<html lang="en">
<head>
	<!-- Page introduction
		 This is a search page contains a search bar and search map that helps user to navigate to the stations they are heading for.-->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>SILO</title>
    <!-- Basic CSS  -->   
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>  
    <link href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.2/semantic.min.css">
	<link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
	<!--map-->
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" integrity="sha512-07I2e+7D8p6he1SIM+1twR5TIrhUQn9+I6yjqD53JQjFiMf8EtC93ty0/5vJTZGF8aAocvHYNEDJajGdNx1IsQ==" crossorigin="" />
	<link rel="stylesheet" href="css/MarkerCluster.css" />
	<link rel="stylesheet" href="css/MarkerCluster.Default.css" />
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
			
			<div id="wrap">
				<div class="ui search">
				  <div class="ui icon input">
					<input id="searchform" class="prompt submit" type="text" placeholder="Search by Station name or ID">
					<i class="search icon"></i>
				  </div>
				  <div class="results"></div>
				</div>
					<button onclick="fGO()" type="submit" class="ui button">GO!</button>
			</div>

			<div id="progress"><div id="progress-bar"></div></div>
			<div id="map"></div>

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
		
		<!-- Map -->
		<script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet-src.js" integrity="sha512-WXoSHqw/t26DszhdMhOXOkI7qCiv5QWXhH9R7CgvgZMHz1ImlkVQ3uNsiQKu5wwbbxtPzFXd1hK4tzno2VqhpA==" crossorigin=""></script>
	    <script src="js/leaflet.markercluster-src.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		
		<script src="js/materialize.js"></script>
		<script src="js/init.js"></script>
		<script>

		</script>
		<script>
            var data1 = <?php echo $json?>;
        </script>
		<script type="text/javascript">
		//script for map search
				var tiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
						maxZoom: 18,
						attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Points &copy 2012 LINZ'
					}),
					latlng = L.latLng(-22, 148);
				//create a map
				var map = L.map('map', { center: latlng, zoom: 5, layers: [tiles] });
				var progress = document.getElementById('progress');
				var progressBar = document.getElementById('progress-bar');
				function updateProgressBar(processed, total, elapsed, layersArray) {
					if (elapsed > 1000) {
						// if it takes more than a second to load, display the progress bar:
						progress.style.display = 'block';
						progressBar.style.width = Math.round(processed/total*100) + '%';
					}

					if (processed === total) {
						// all markers processed - hide the progress bar:
						progress.style.display = 'none';
					}
				}				
				var markers = L.markerClusterGroup({ chunkedLoading: true, chunkProgress: updateProgressBar });
				var markerList = [];

				//search bar content
				var content=[];

				//add a popup and a button for each mark
				for (var i = 0; i < data1.data.length; i++) {
					var title = data1.data[i].name;
					var number=data1.data[i].number;
					var supplier=data1.data[i].supplier;
					var startyear=data1.data[i].start_year;
					var endyear=data1.data[i].end_year;
					var elevation=data1.data[i].elevation;
					// add into search bar content
					var inside = {};
					inside['title']=title+" ("+number+")";
					content.push(inside);
					
					//creat a container for each marker and save station's detail to container
					var container = L.DomUtil.create('div');
					container.innerHTML ='Station Name: '+title +'<br />Number: '+number
					+'<br />Data are available from '+startyear+' to '+endyear+'<br />Supplier: '+supplier+'<br />Elevation: '+elevation+'<br/>';
					//creat a button inside of container
					var btn = L.DomUtil.create('button', 'popup', container);
					btn.setAttribute('type', 'button');
					btn.setAttribute('value','id='+data1.data[i].number+'&'+'startyear='+startyear+'&endyear='+endyear+'&name='+title);
					btn.onclick= function(){myFunction()};
					btn.innerHTML = 'Double Click to Start A Search!';			
					var marker = L.marker(L.latLng(data1.data[i].latitude, data1.data[i].longitude), { title: title });
					//add container to poppup of marks
					marker.bindPopup(container);
					markerList.push(marker);				
				}

				//click a button on a popoup to open a graph page
				function myFunction() {
				  $('button.popup').click(function() {
					window.location.assign('graph_page.php?'+$(this).attr('value'));
				});				
				}
				// add all marks to map
				markers.addLayers(markerList);
				map.addLayer(markers);
						
		</script>
		<!-- Search Bar -->
		<!-- Include javascript of semantic-ui and javascript variable content for build of search bar -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.2/semantic.min.js"></script>
		
		<script type="text/javascript">		
			/*Once click the GO! button, get the text of search result, splite it out to get the id of station.
			Then use the local variable data1(json format) to get the startYear and endYear of the record
			*/ 
			 
			function fGO(){
				var query = $('#searchform').val()
				var id = query.split(")")[0].split("(")[1]
				for (var i = 0; i < data1.data.length; i++) {
					var number=data1.data[i].number;
					if(number==id){
							var startYear=data1.data[i].start_year;
							var endYear=data1.data[i].end_year;
						}
				}
				 window.location = 'graph_page.php?id='+id+'&'+'startyear='+startYear+'&endyear='+endYear
			}
			
			//While use search function, use var content as source to find suitable result
			$('.ui.search')
			  .search({
				source: content
			  })
		</script>
</body>
</html>
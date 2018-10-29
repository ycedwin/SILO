<!DOCTYPE html>
<html lang="en">


<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SILO- Climate Data Visulization Tool</title>
	
  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/one-page-wonder.css" rel="stylesheet">
  <script src="https://apis.google.com/js/platform.js" async defer>
    {
      parsetags: 'explicit'
    }
	    <!--  Scripts-->
  </script>
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.bundle.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
  <script type="text/javascript" src="chart.js"></script>
<script> 
<?php
$dbms='mysql';    
$host='localhost'; 
$dbName='product_web';    
$user='deco3801';      
$pass='ufeJZAecHvpShg2d';          
$dsn="$dbms:host=$host;dbname=$dbName";
$dbh = new PDO($dsn, $user, $pass);

		$st = $dbh->prepare('SELECT count(*) from user_survey WHERE gender="male"');
		$st->execute();   
		$male = $st->fetchAll();		
	
		$stf = $dbh->prepare('SELECT count(*) from user_survey WHERE gender="female"');
		$stf->execute();   
		$female = $stf->fetchAll();
		$maleJson = json_encode($male);
		$femaleJson = json_encode($female);
			
		$std = $dbh->prepare('SELECT day, count(ip) from visit GROUP BY day');
		$std->execute();
		$dailyIp = $std->fetchAll();
		$dailyJson = json_encode($dailyIp);
		
		$sta = $dbh->prepare('SELECT age, count(age) from user_survey GROUP BY age');
		$sta->execute();
		$ageGroup = $sta->fetchAll();
		$ageJson = json_encode($ageGroup);
		
		$stj = $dbh->prepare('SELECT job, count(job) from user_survey GROUP BY job');
		$stj->execute();
		$jobGroup = $stj->fetchAll();
		$jobJson = json_encode($jobGroup);
?>		
		var count = -1;
		var counta = -1;
		var countj = -1;
		var data = [];
		var date = [];
		var ip = [];
		var job = [];
		var age = [];
		var maleJson = <?php echo $maleJson ?>;
		var male = maleJson["0"]["0"];
		var femaleJson = <?php echo $femaleJson ?>;
		var female = femaleJson["0"]["0"];
		data.push(male);
		data.push(female);
		
		var dailyJson = <?php echo $dailyJson ?>;
		console.log(dailyJson);
		for(var js in dailyJson){
			count++;
			date.push(dailyJson[count]['0']);
			ip.push(dailyJson[count]['1']);
		}
		
		var ageJson = <?php echo $ageJson ?>;
		var jobJson = <?php echo $jobJson ?>;
		for(var jsa in ageJson){
			counta++;
			age.push(ageJson[counta]['1']);
		}
		for(var jsj in jobJson){
			countj++;
			job.push(jobJson[countj]['1']);
		}
		
		console.log(job);
		console.log(age);
		//drawChart(data);
		
		
		

</script>
</head>	

<body onload="drawChart(data, date, ip, age, job)">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="/product_web/index.php">SILO</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item ">
            <a class="nav-link" href="/product_web/index.php">Home
                <span class="sr-only">(current)</span>
              </a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="/product_web/statistics.php">Statistic</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <header class="masthead">
    
    <div class="overlay">
      <div class="container">
        <h1 class="display-1 text-white">SILO</h1>
        <h2 class="display-4 text-white">Searching Climate Data is Easier</h2>
      </div>
	  
	  <div class="container share-links">
    <h4 class="display-12 text-white">Share statistic page</h4>
        <ul class="social-network social-circle">
        <iframe src="https://www.facebook.com/plugins/share_button.php?href=https%3A%2F%2Fdeco3801-pandahackx.uqcloud.net%2Fproduct_web%2Fstatistics.php&layout=button_count&size=small&mobile_iframe=true&width=69&height=20&appId" width="69" height="20" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe> <script src="//platform.linkedin.com/in.js" type="text/javascript">
            lang: en_US
          </script>
          <script type="IN/Share" data-url="https://deco3801-pandahackx.uqcloud.net/product_web/statistics.php" data-counter="right"></script>
          <a href="https://twitter.com/share" class="twitter-share-button" data-show-count="true" data-url="https://deco3801-pandahackx.uqcloud.net/product_web/statistics.php">Tweet #LoveTwitter</a>
          <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
        </ul>
      </div>

      <div class="container ">
        <p><a class="btn btn-primary btn-lg Beta-btn" href="/product_web/purchase.html" role="button">Signup for Beta</a></p>
      </div>
	  
    </div>
  </header>
  
  <section>
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 order-2">
          <div class="p-4">
            <canvas id="pie-chart"></canvas>
          </div>
        </div>
        <div class="col-md-6 order-1">
          <div class="p-5">
            <h2>Gender of the users</h2>
            <p></p>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  <section>
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 order-2">
          <div class="p-4">
            <canvas id="age-chart" ></canvas>
          </div>
        </div>
        <div class="col-md-6 order-1">
          <div class="p-5">
            <h2>Age distribution of users</h2>
            <p></p>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  <section>
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 order-2">
          <div class="p-4">
            <canvas id="job-chart" ></canvas>
          </div>
        </div>
        <div class="col-md-6 order-1">
          <div class="p-5">
            <h2>Occupation of the users</h2>
            <p></p>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  <section>
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 order-2">
          <div class="p-1">
            <canvas id="bar-chart" ></canvas>
          </div>
        </div>
        <div class="col-md-6 order-1">
          <div class="p-5">
            <h2>Daily visitors</h2>
            <p></p>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  
  
  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; Panda Hack X</p>
    </div>
    <!-- /.container -->
  </footer>
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/popper/popper.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

</body>

  
</html>

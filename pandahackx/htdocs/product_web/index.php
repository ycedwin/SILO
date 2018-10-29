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
  </script>
<?php 
	$dbms='mysql';    
	$host='localhost'; 
	$dbName='product_web';    
	$user='deco3801';      
	$pass='ufeJZAecHvpShg2d';          
	$dsn="$dbms:host=$host;dbname=$dbName";
	$dbh = new PDO($dsn, $user, $pass);
	
	$st = $dbh->prepare("INSERT INTO visit (ip, day) VALUES (:ip, :day)");
	$st->bindParam(':ip', $ip);
	$st->bindParam(':day', $day);
	
	$ip = $_SERVER['REMOTE_ADDR'];
	$day = date('Y-m-d');
    
	$st->execute();         
?>
</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="/product_web/index.php">SILO</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="/product_web/index.php">Home
                <span class="sr-only">(current)</span>
              </a>
          </li>
          <li class="nav-item">
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
       <h4 class="display-12 text-white">Share the signup page</h4>
       <ul class="social-network social-circle">
        <iframe src="https://www.facebook.com/plugins/share_button.php?href=https%3A%2F%2Fdeco3801-pandahackx.uqcloud.net%2Fproduct_web%2Fpurchase.html&layout=button_count&size=small&mobile_iframe=true&width=69&height=20&appId" width="69" height="20" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
         <script src="//platform.linkedin.com/in.js" type="text/javascript">
            lang: en_US
          </script>
          <script type="IN/Share" data-url="https://deco3801-pandahackx.uqcloud.net/product_web/purchase.html" data-counter="right"></script>
         
          <a href="https://twitter.com/share" class="twitter-share-button" data-show-count="true" data-url="https://deco3801-pandahackx.uqcloud.net/product_web/purchase.html">Tweet #LoveTwitter</a>
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
          <div class="p-5">
            <img class="img-fluid rounded-circle" src="img/img1.jpg" alt="">
          </div>
        </div>
        <div class="col-md-6 order-1">
          <div class="p-5">
            <h2 class="display-4">Target Users</h2>
            <p>SILO climate data visualisation tool is a web application developed by our team for Queensland Department of Science, Information Technology, and Innovation. It is designed and developed for climate experts like scientists and researchers
              as well as normal users. It provides climate data visualisation and data aggregation functionalities.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="p-5">
            <img class="img-fluid" src="img/img2.png" alt="">
          </div>
        </div>
        <div class="col-md-6">
          <div class="p-5">
            <h2 class="display-4">Reliable Data Resources</h2>
            <p>All data are collected from climate stations among Australia and retrieved from SILO API which provides a range of climate variables such as maximum temperature,
              minimum temperature, daily rainfall, radiation and to name some. Users could select a climate station and learn the specific climate features on the chosen day range for their research needs.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 order-2">
          <div class="p-5">
            <img class="img-fluid" src="img/img3.png" alt="">
          </div>
        </div>
        <div class="col-md-6 order-1">
          <div class="p-5">
            <h2 class="display-4">Visualization Tool</h2>
            <p>SILO provides an online visualisation tool for showing the graph of the queried climate data and the aggregation result. This way, users have a better intuition of the retrieved data.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-7">
          <div class="p-5">
            <iframe width="100%" height="300" src="https://www.youtube.com/embed/ZvWm0NC0ixo"></iframe>
          </div>
        </div>
        <div class="col-md-5">
          <div class="p-5">
            <h2 class="display-4">Minimum Viable Product Video</h2>
            <p>Showcase the minimum viable product that implemented just those core features and introduce how to use this web application.</p>
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

<?php
    
    require 'dbinfo.php';
    require 'includes/functions.php';
    require __DIR__.'/vendor/autoload.php';

    use Ivory\GoogleMap;
    use Ivory\GoogleMap\Map;
    use Ivory\GoogleMap\MapTypeId;
    use Ivory\GoogleMap\Helper\MapHelper;
    use Ivory\GoogleMap\Overlays\Animation;
    use Ivory\GoogleMap\Overlays\Marker;
    use Ivory\GoogleMap\Overlays\MarkerCluster;
    use Ivory\GoogleMap\Overlays\InfoWindow;
    use Ivory\GoogleMap\Events\MouseEvent;

    $map = new Map();

    $map->setPrefixJavascriptVariable('map_');
    $map->setHtmlContainerId('map_canvas');

    $map->setAsync(false);
    $map->setAutoZoom(false);

    $map->setCenter(0, 0, true);
    $map->setMapOption('zoom', 3);

    $map->setBound(-2.1, -3.9, 2.6, 1.4, true, true);

    $map->setMapOption('mapTypeId', MapTypeId::ROADMAP);
    $map->setMapOption('mapTypeId', 'roadmap');

    $map->setStylesheetOption('width', '700px');
    $map->setStylesheetOption('height', '500px');

    $bdd = new PDO('mysql:host=localhost;dbname=' . DB_NAME . ';charset=gbk', DB_USER, DB_PASS);  
    $sql = plotAll("younes");
    $result = $bdd->query($sql);
    $i = 0;
    while($data = $result->fetch()) {
        $lat[$i] = $data['Latitude'];
        $lon[$i] = $data['Longitude'];
        $phone[$i] = $data['phoneNumber'];
        $last[$i] = $data['LastUpdate'];
        $i++;
    }

    for ($i=0; $i < count($lat); $i++) { 
        
    $marker = new Marker();

    $marker->setPrefixJavascriptVariable('marker_');
    $marker->setPosition($lat[$i], $lon[$i], true);
    $marker->setAnimation(Animation::DROP);

    $marker->setIcon('http://maps.gstatic.com/mapfiles/markers/marker.png');

    $map->addMarker($marker);

    $infoWindow = new InfoWindow();

    $infoWindow->setPrefixJavascriptVariable('info_window_');
    $infoWindow->setPixelOffset(1.1, 2.1, 'px', 'pt');
    $infoWindow->setContent('<b>' . $phone[$i] . '</b> <br/>' . $last[$i]);
    $infoWindow->setOpen(false);
    $infoWindow->setAutoOpen(true);
    $infoWindow->setOpenEvent(MouseEvent::CLICK);
    $infoWindow->setAutoClose(false);
    $infoWindow->setOption('disableAutoPan', true);
    $infoWindow->setOption('zIndex', 10);

    $marker->setInfoWindow($infoWindow);

    }
    
    $mapHelper = new MapHelper();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Itinéraire - GPS Tracking</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body onload="load()">

  <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
      <!--header start-->
      <header class="header black-bg">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
              </div>
            <!--logo start-->
            <a href="index.php" class="logo"><b>GPS Tracking</b></a>
            <!--logo end-->
            <div class="top-menu">
            	<ul class="nav pull-right top-menu">
                    <li><a class="logout" href="login.html">Logout</a></li>
            	</ul>
            </div>
        </header>
      <!--header end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
              
              	  <p class="centered"><a href="profile.html"><img src="assets/img/ui-sam.jpg" class="img-circle" width="60"></a></p>
              	  <h5 class="centered">Nom de la société</h5>
              	  	                
                  <li class="mt">
                      <a href="suivi.php" >
                          <i class="fa fa-dashboard"></i>
                          <span>Suivi</span>
                      </a>

                  </li>

                  <li class="sub-menu">
                      <a class="active" href="javascript:;" >
                          <i class="fa fa-code-fork"></i>
                          <span>Itinéraire</span>
                      </a>
                      <ul class="sub">
                          <form>
                          <br>&nbsp;&nbsp;&nbsp;<input type="radio" name="who" value="who1"> Employe1<br>
                          &nbsp;&nbsp;&nbsp;<input type="radio" name="who" value="who2"> Employe2<br>
                          &nbsp;&nbsp;&nbsp;<input type="radio" name="who" value="who2"> Employe3
                      </form>
                      </ul>
                  </li>
                  
                  <li class="sub-menu">
                      <a href="employes.php" >
                          <i class="fa fa-tasks"></i>
                          <span>Employés</span>
                      </a>                      
                  </li>                  

              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
          	<h3><i class="fa fa-angle-right"></i> Itinéraire</h3>
          	<div class="row mt">
          		<div class="col-lg-12">
                    <?php echo $mapHelper->render($map); ?>
          		</div>
          	</div>
			
		</section><!--/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              2014 - @saadel
              <a href="itineraire.php#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

    <!--script for this page-->
    
  <script>
      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

  </script>

  </body>
</html>

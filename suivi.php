<?php
    require_once('classes/session.php');
    require_once('classes/database.php');
    require_once('classes/utilisateur.php');
    require_once('classes/societe.php');
    require_once('classes/employe.php');
    require_once('dbinfo.php');
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

    $session = new Session();

    if(!$session->is_loggedin()) {
        $session->message("vous devez s'authentifier");
        header('Location: index.php');
    }
    $ut= new Utilisateur();
    $ut->find_by_id($session->get_user_id());
    $ut_data= $ut->get_utilisateur();
    $employes=Employe::liste_employes_societe($ut_data['soc_id']);
    $comp = new Societe();
    $comp->find_by_id($ut_data['soc_id']);
    $comp_data = $comp->get_societe();


    $map = new Map();

    $map->setMapOption('zoom', 20);
    $map->setStylesheetOption('width', '700px');
    $map->setStylesheetOption('height', '500px');

    if (isset($_POST['who'])) {
        $array = implode("','", $_POST['who']);
    } else {
            $i=0;
            foreach ($employes as $employe) {
                $surnoms[$i] = $employe['emp_surnom'];
                $i++;
            }
            $array = implode("','", $surnoms);
    }

    $result = plotLast($array);
    $i=0;
    while($data = $result->fetch()) {
        $lat[$i] = $data['Latitude'];
        $lon[$i] = $data['Longitude'];
        $phone[$i] = $data['phoneNumber'];
        $last[$i] = $data['MAX(LastUpdate)'];
        $i++;
    }
    $map->setCenter($lat[count($lat)-1], $lon[count($lat)-1], true);
    
    for ($i=0; $i < count($lat); $i++) { 
        $marker = new Marker();

        $marker->setPrefixJavascriptVariable('marker_');
        $marker->setPosition($lat[$i], $lon[$i], true);
        $marker->setAnimation(Animation::DROP);

        // $marker->setIcon('http://maps.gstatic.com/mapfiles/markers/marker.png');
        $marker->setIcon('http://labs.google.com/ridefinder/images/mm_20_' . generateBG($i) . '.png');

        $map->addMarker($marker);

        $infoWindow = new InfoWindow();

        $infoWindow->setPrefixJavascriptVariable('info_window_');
        $infoWindow->setPixelOffset(1.1, 2.1, 'px', 'px');
        $infoWindow->setContent('<div style="width:150px; height:50px"><b>' . ucwords($phone[$i]) . '</b><br>' . $last[$i].'</div>');
        $infoWindow->setOpen(true);
        $infoWindow->setAutoOpen(true);
        $infoWindow->setOpenEvent(MouseEvent::CLICK);
        $infoWindow->setAutoClose(false);
        $infoWindow->setOption('disableAutoPan', true);
        $infoWindow->setOption('zIndex', 10);

        $marker->setInfoWindow($infoWindow);
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Suivi - GPS Tracking</title>

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

  <body>

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
            <a href="index.html" class="logo"><b>GPS Tracking</b></a>
            <!--logo end-->
            <div class="top-menu">
            	<ul class="nav pull-right top-menu">
                    <li><a class="logout" href="process/logout.php">Logout</a></li>
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
              	  <h5 class="centered"><?php echo escape($comp_data["soc_nom"]); ?></h5>
              	  	                
                  <li class="mt">
                      <a class="active" href="javascript:;" >
                          <i class="fa fa-dashboard"></i>
                          <span>Suivi</span>
                      </a>
                      <ul class="sub">
                      <form method="post">
                      <?php 
                          foreach ($employes as $employe): 
                          $id = $employe["emp_id"]; ?>
                          <br>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="who[]" value="<?php echo escape($employe["emp_surnom"]); ?>" <?php if(isset($_POST['who']) && is_array($_POST['who']) && in_array($employe["emp_surnom"], $_POST['who'])) echo 'checked="checked"' ?> > <?php echo escape($employe["emp_prenom"] ." ". $employe['emp_nom']); ?>
                      <?php endforeach ?>
                      <br><br>&nbsp;&nbsp;&nbsp;<input class="btn btn-succes btn-xs" type="submit" value="Go">
                      &nbsp;&nbsp;&nbsp;<input class="btn btn-succes btn-xs" type="reset" value="Reset">
                      </form>
                      </ul>
                  </li>

                  <li class="sub-menu">
                      <a href="itineraire.php" >
                          <i class="fa fa-code-fork"></i>
                          <span>Itinéraire</span>
                      </a>
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
          	<h3><i class="fa fa-angle-right"></i> Suivi</h3>
          	<div class="row mt">
          		<div class="col-lg-12">
                    <?php 
                        $mapHelper = new MapHelper();
                        echo $mapHelper->render($map); 
                    ?>
          		</div>
          	</div>
			
		</section><!--/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              2014 - @saadel
              <a href="suivi.php#" class="go-top">
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

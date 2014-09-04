<?php
    require_once('classes/session.php');
    require_once('classes/utilisateur.php');
    require_once('classes/societe.php');
    require_once('classes/employe.php');
    require_once('dbinfo.php');
    require 'includes/functions.php';
    $session = new Session();
    
    if(!$session->is_loggedin()) {
        $session->message("vous devez s'authentifier");
        header('Location: index.php');
    }
    $ut = new Utilisateur();
    $ut->find_by_id($session->get_user_id());
    $ut_data = $ut->get_utilisateur();
    $employes = Employe::liste_employes_societe($ut_data['soc_id']);
    $comp = new Societe();
    $comp->find_by_id($ut_data['soc_id']);
    $comp_data = $comp->get_societe();    
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Employés - GPS Tracking</title>

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
              
              	  <p class="centered"><a href="profile.html"><img src="assets/img/ui-danro.jpg" class="img-circle" width="60"></a></p>
              	  <h5 class="centered"><?php echo escape($comp_data["soc_nom"]); ?></h5>
              	  	                
                  <li class="mt">
                      <a href="suivi.php" >
                          <i class="fa fa-dashboard"></i>
                          <span>Suivi</span>
                      </a>
                  </li>

                  <li class="sub-menu">
                      <a href="itineraire.php" >
                          <i class="fa fa-code-fork"></i>
                          <span>Itinéraire</span>
                      </a>
                  </li>
                  
                  <li class="sub-menu">
                      <a class="active" href="employes.php" >
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
            <div class="row mt">
                <div class="col-lg-12">
                    <?php 
                        if ($session->message()) {
                            echo '<div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">
                                    &times;</button>';
                            echo $session->message(); 
                            echo "</div>";    
                        }
                     ?> 
                  <div class="content-panel">
                      <table class="table table-hover">
          	             <h3><i class="fa fa-angle-right"></i> Employés</h3>
                      <hr>
                        <thead>
                          <tr>
                            <th> Nom </th>
                            <th> Prénom </th>
                            <th> Surnom </th>
                            <th class="td-actions">Options</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php foreach($employes as $employe):?>
                          <tr>
                            <?php $id = $employe["emp_id"]; ?>
                            <td>
                            <?php echo escape($employe["emp_nom"]); ?></td>
                            <td><?php echo escape($employe["emp_prenom"]); ?></td>
                            <td><?php echo escape($employe["emp_surnom"]); ?></td>
                            <td class="td-actions">
                            <button type="button" data-toggle="modal" class="btn btn-primary btn-xs" href="employes.php#my2ndModal<?php echo $id; ?>"><i class="fa fa-pencil "></i> Modifier</button>
                            <button type="button" data-toggle="modal" class="btn btn-danger btn-xs" href="employes.php#myModal<?php echo $id; ?>"><i class="fa fa-trash-o "></i> Supprimer</button>
                            <!-- Modal 1 Suppression -->
                        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal<?php echo $id; ?>" class="modal fade">
                          <div class="modal-dialog">
                              <div class="modal-content">
                                  <div class="modal-header2">
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                      <h4 class="modal-title">Êtes-vous sûr de vouloir supprimer cet employé?</h4>
                                  </div>
                                  <div class="modal-body">
                                    <p><h3><?php echo escape($employe["emp_prenom"].' '.$employe["emp_nom"]); ?></h3></p>
                                  </div>
                                    <form action="process/delete.php" method="post">
                                      <div class="modal-footer">
                                          <input type="hidden" name="idemp" value='<?php echo escape($id); ?>'>                      
                                          <button data-dismiss="modal" class="btn btn-default" type="button">Annuler</button>
                                          <button class="btn btn-danger" type="submit">Supprimer</button>
                                      </div>
                                  </form>
                              </div>
                          </div>
                      </div>
                        <!-- Modal 1 -->
                        <!-- Modal 2 Modification -->
                        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="my2ndModal<?php echo $id; ?>" class="modal fade">
                          <div class="modal-dialog">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                      <h4 class="modal-title">Modification</h4>
                                  </div>
                                    <form action="process/update.php" method="post">
                                        <div class="modal-body">
                                            <p><h3><?php echo escape($employe["emp_prenom"].' '.$employe["emp_nom"]); ?></h3></p>
                                            <!-- Nom: <input name="nomemploye" type="text" class="form-control" required placeholder="<?php echo escape($employe["emp_prenom"]);?>"><br> -->
                                            <!-- Prenom: <input name="prenomemploye" type="text" class="form-control" required placeholder="<?php echo escape($employe["emp_nom"]);?>"><br>                                       -->
                                            <input type="hidden" name="idemp" value='<?php echo escape($id); ?>'>                      
                                            Surnom: <input name="surnomemploye" type="text" class="form-control" required placeholder="<?php echo escape($employe["emp_surnom"]);?>"><br>                                      
                                            * Le surnom doit être le même que celui utilisé dans l'application mobile.
                                        </div>
                                        <div class="modal-footer">
                                            <button data-dismiss="modal" class="btn btn-default" type="button">Annuler</button>
                                            <button class="btn btn-theme" type="submit">Modifier</button>
                                        </div>
                                    </form>
                              </div>
                          </div>
                        </div>
                        <!-- Modal 2 -->
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                      </table>
                  </div>
                  <div><br>
                <a href="#my3rdModal" role="button" class="btn btn-info" data-toggle="modal">Ajouter un employé</a>
                </div>

                    <!-- Modal 3 Ajout -->
                    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="my3rdModal" class="modal fade">
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                  <h4 class="modal-title">Ajout d'un employé</h4>
                              </div>
                            <form action="process/add.php" method="post">
                                <div class="modal-body">
                                      <input type="hidden" name="societe" value='<?php echo escape($comp_data["soc_id"]); ?>'>                      
                                      <input name="nomemploye" type="text" class="form-control" required placeholder="Nom"><br>
                                      <input name="prenomemploye" type="text" class="form-control" required placeholder="Prenom"><br>
                                      <input name="surnomemploye" type="text" class="form-control" required placeholder="Surnom"><br>
                                      * Utilisez le même surnom que vous venez d'attribuer à l'employé dans l'application mobile.
                                </div>
                              <div class="modal-footer">
                                  <button data-dismiss="modal" class="btn btn-default" type="button">Annuler</button>
                                  <button class="btn btn-theme" type="submit">Ajouter</button>
                              </div>
                            </form>
                          </div>
                      </div>
                    </div>
                    <!-- Modal 3 -->

          		</div>
          	</div>
			
		</section><!--/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              2014 - @saadel
              <a href="employes.php#" class="go-top">
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

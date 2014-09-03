<?php	
	require_once('../classes/database.php');
	require_once('../classes/utilisateur.php');
	require_once('../classes/session.php');
	require_once('users.php');

  	$session = new Session();  	

  	$valid = true;

	if (!empty($_POST)) {
	  $requiredFields = array('firstname', 'lastname', 'email', 'username', 'password', 'confirm_password');
	  foreach ($_POST as $key => $value) {
	    if (empty($value) && in_array($key, $requiredFields)) {
	      $session->message('Tous les champs sont obligatoires.');
	      $valid = false;
	      header('Location: ../signup.php');
	    }
	  }

	if(!$session->is_there_any_msg()) {
	  if (user_exists($_POST['username'])) {
	    $session->message('Désolé cet identifiant: ' . $_POST['username'] . ' est déjà utilisé par un autre membre');
	    $valid = false;
	    header('Location: ../signup.php');
	  }

	  if (strlen($_POST['password']) < 6) {
	    $session->message('Le mot de passe doit être de 6 caractères ou plus');
	    $valid = false;
	    header('Location: ../signup.php');
	  }

	  if ($_POST['password'] !== $_POST['confirm_password']) {
	    $session->message('Les mots de passe saisis ne sont pas identiques');
	    $valid = false;
	    header('Location: ../signup.php');
	  }
	}
}

  	if ($valid) {				
        $socid = register_company($_POST['societe']);
        $register_data = array(
            'u_prenom' => ucfirst($_POST['firstname']),
            'u_nom' => ucfirst($_POST['lastname']),
            'email' => $_POST['email'],
            'username' => $_POST['username'],
            'password' => $_POST['password'],
            'validation' => 0,
            'soc_id' => $socid,
        );
		register_user($register_data);
        $session->message('Compte crée !');
        header('Location: ../index.php');
	}		
?>
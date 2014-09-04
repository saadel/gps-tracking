<?php
require_once '../classes/database.php';
require_once '../classes/utilisateur.php';
require_once '../classes/session.php';
require_once '../classes/employe.php';
require_once 'users.php';

$session = new Session();

if(!empty($_POST['prenomemploye'])) {
	$emp = new Employe();
	$register_data = array(
		'emp_nom' => ucfirst($_POST['nomemploye']),
		'emp_prenom' => ucfirst($_POST['prenomemploye']),
		'emp_surnom' => $_POST['surnomemploye'],
		'soc_id' => $_POST['societe']
	);
	foreach ($register_data as $key => $value) {
		$emp->set_employe($key,$value);
	}
	$emp->create();
	header('Location: ../employes.php');
} else {
    header('Location: ../index.php');
}


<?php
require_once '../classes/database.php';
require_once '../classes/utilisateur.php';
require_once '../classes/session.php';
require_once '../classes/employe.php';
require_once 'users.php';

$session = new Session();

if(!empty($_POST['idemp'])) {
	
	$emp = new Employe();
	$emp->find_by_id($_POST['idemp']);
	$emp->delete();
	header('Location: ../employes.php');

} else {
    header('Location: ../index.php');
}

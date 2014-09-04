<?php
require_once '../classes/database.php';
require_once '../classes/utilisateur.php';
require_once '../classes/session.php';
require_once '../classes/employe.php';

$session = new Session();   

function surnom_exists($sn) {
    global $db;
    $sql = 'SELECT emp_id FROM employe WHERE emp_surnom = :surnom';
    $re=$db->query($sql,array("surnom"=>$sn));
    $resultat=$re->fetch();

    if (empty($resultat)) {
        return false;
    } else {
        return true;
    }
}

if(!empty($_POST['surnomemploye'])) {
    if (!surnom_exists($_POST['surnomemploye'])) {
        $emp = new Employe();
        $emp->find_by_id($_POST['idemp']);
        $emp->set_employe('emp_surnom', $_POST['surnomemploye']);
        $emp->update();
        header('Location: ../employes.php');
    } else {
        $session->message("Ce surnom est déjà utilisé par un autre employé, veuillez choisir un autre.");
        header('Location: ../employes.php');
    }
}


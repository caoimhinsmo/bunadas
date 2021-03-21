<?php
//Sguab às drong d
  if (!include('autoload.inc.php')) { die('include autoload failed'); }

  if (!isset($_REQUEST['d']))   { die('Parameter d a dhìth');   }
  $d = $_REQUEST['d'];

  $stordataConnector = SM_Bunadas::stordataConnector();
  $DbBun = $stordataConnector::singleton('rw');

  $stmt1 = $DbBun->prepare('DELETE FROM bundf WHERE d=:d');
  $stmt1->execute([ ':d'=>$d ]);
  
  $stmt2 = $DbBun->prepare('DELETE FROM bund WHERE d=:d');
  $stmt2->execute([ ':d'=>$d ]);
  
  echo 'OK';
?>

<?php
//Atharrachaidh seo am meit aig facal f ann am buidheann d gu m

  if (!include('autoload.inc.php')) { die('include autoload failed'); }
  if (!isset($_REQUEST['d']))   { die('d is not set'); }
  if (!isset($_REQUEST['f']))   { die('f is not set'); }
  if (!isset($_REQUEST['m']))   { die('m is not set'); }
  $d = $_REQUEST['d'];
  $f = $_REQUEST['f'];
  $m = $_REQUEST['m'];
  if (!SM_Bunadas::ceadSgriobhaidh()) die('Duilich - Chan eil cead-sgrìobhaidh agad');
  $stordataConnector = SM_Bunadas::stordataConnector();
  $DbBun = $stordataConnector::singleton('rw');
  $stmtDEL = $DbBun->prepare('UPDATE bundf SET meit=:m WHERE d=:d AND f=:f');
  $stmtDEL->execute(array(':d'=>$d,':f'=>$f,':m'=>$m));
  echo 'OK';

?>

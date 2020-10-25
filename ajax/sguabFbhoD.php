<?php
//Sguabaidh seo am facal f bhon drong d

  if (!include('autoload.inc.php')) { die('include autoload failed'); }
  if (!isset($_REQUEST['f']))   { die('f is not set'); }
  if (!isset($_REQUEST['d']))   { die('d is not set'); }
  $f = $_REQUEST['f'];
  $d = $_REQUEST['d'];
  if (!SM_Bunadas::ceadSgriobhaidh()) die('Duilich - Chan eil cead-sgrìobhaidh agad');
  $stordataConnector = SM_Bunadas::stordataConnector();
  $DbBun = $stordataConnector::singleton('rw');
  $stmtDEL = $DbBun->prepare('DELETE FROM bundf WHERE f=:f AND d=:d');
  $stmtDEL->execute(array(':f'=>$f,':d'=>$d));
  echo 'OK';

?>

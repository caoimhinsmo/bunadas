<?php
//Sguabaidh seo ás an litreachadh l

  if (!include('autoload.inc.php')) { die('include autoload failed'); }
  if (!isset($_REQUEST['f']))   { die('f is not set'); }
  if (!isset($_REQUEST['l']))   { die('l is not set'); }
  $f = $_REQUEST['f'];
  $l = $_REQUEST['l'];
  if (!SM_Bunadas::ceadSgriobhaidh()) die('Duilich - Chan eil cead-sgrìobhaidh agad');
  $stordataConnector = SM_Bunadas::stordataConnector();
  $DbBun = $stordataConnector::singleton('rw');
  $stmtDEL = $DbBun->prepare('DELETE FROM bunfLit WHERE f=:f AND l=:l');
  $stmtDEL->execute(array(':f'=>$f,':l'=>$l));
  echo 'OK';

?>

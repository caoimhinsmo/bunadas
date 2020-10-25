<?php
//Sguabaidh seo ás an t-iomradh i

  if (!include('autoload.inc.php')) { die('include autoload failed'); }
  if (!isset($_REQUEST['f']))   { die('f is not set'); }
  if (!isset($_REQUEST['i']))   { die('i is not set'); }
  $f = $_REQUEST['f'];
  $i = $_REQUEST['i'];
  if (!SM_Bunadas::ceadSgriobhaidh()) die('Duilich - Chan eil cead-sgrìobhaidh agad');
  $stordataConnector = SM_Bunadas::stordataConnector();
  $DbBun = $stordataConnector::singleton('rw');
  $stmtDEL = $DbBun->prepare('DELETE FROM bunfImrad WHERE f=:f AND i=:i');
  $stmtDEL->execute(array(':f'=>$f,':i'=>$i));
  echo 'OK';

?>

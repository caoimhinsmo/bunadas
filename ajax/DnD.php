<?php
//Cuir am facal fDrag anns an drong dDrop
//agus sguab às a’ bhuidheann dDrag e, ma tha parameter dDrag ann.

  if (!include('autoload.inc.php')) { die('include autoload failed'); }
  if (!isset($_REQUEST['fDrag']))   { die('fDrag is not set'); }
  if (!isset($_REQUEST['dDrop']))   { die('dDrop is not set'); }
  $fDrag = $_REQUEST['fDrag'];
  $dDrop = $_REQUEST['dDrop'];
  if (!SM_Bunadas::ceadSgriobhaidh()) die('Duilich - Chan eil cead-sgrìobhaidh agad');
  $stordataConnector = SM_Bunadas::stordataConnector();
  $DbBun = $stordataConnector::singleton('rw');
  $DbBun->beginTransaction();
  $stmtCuirriBuidheann = $DbBun->prepare("INSERT IGNORE INTO bundf(f,d) VALUES (:f,:d)");
  $stmtCuirriBuidheann->execute( array(':f'=>$fDrag, ':d'=>$dDrop) );
  if (isset($_REQUEST['dDrag'])) {
      $dDrag = $_REQUEST['dDrag'];
      $stmtDEL = $DbBun->prepare('DELETE FROM bundf WHERE f=:f AND d=:d');
      $stmtDEL->execute(array(':f'=>$fDrag,':d'=>$dDrag));
  }
  $DbBun->commit();
  echo 'OK';

?>

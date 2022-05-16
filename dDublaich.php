<?php
  if (!include('autoload.inc.php'))
    header("Location:https://claran.smo.uhi.ac.uk/mearachd/include_a_dhith/?faidhle=autoload.inc.php");
  header("Cache-Control:max-age=0");

  try {
      $myCLIL = SM_myCLIL::singleton();
      if (!SM_Bunadas::ceadSgriobhaidh()) { $myCLIL->diultadh(''); }
  } catch (Exception $e) {
      $myCLIL->toradh = $e->getMessage();
  }

  try {
    $myCLIL->dearbhaich();
    $smid = $myCLIL->id;
    $bunadasURL = SM_Bunadas::bunadasurl();
    $T = new SM_T('bunadas/dDublaich');
    $hl = $T::hl0();
    $T_Chaidh_drong_a_chopaigeadh = $T->h('Chaidh_drong_a_chopaigeadh');
    $T_Parameter_neo_iomchaidh    = $T->h('Parameter neo-iomchaidh');
    $T_Chan_eil_drong_d           = $T->h('Chan_eil_drong_d');

    $navbar = SM_Bunadas::navbar($T->domhan);

    $dUr = -1;
    $HTML = $refreshHtml = '';

    $d = (!isset($_REQUEST['d']) ? 0 : $_REQUEST['d']);
    $d = htmlspecialchars($d);
    if (!is_numeric($d) || intval($d)<>$d || $d<1) { throw new SM_Exception("$T_Parameter_neo_iomchaidh: d=$d"); }

    $stordataConnector = SM_Bunadas::stordataConnector();
    $DbBun = $stordataConnector::singleton('rw');
    $stmtDSEL = $DbBun->prepare('SELECT * FROM bund WHERE d=:d');
    $stmtDSEL->execute(array(':d'=>$d));
    if (!$row = $stmtDSEL->fetch(PDO::FETCH_ASSOC)) { throw new SM_Exception(sprintf($T_Chan_eil_drong_d,$d)); }
    extract($row);
    $DbBun->beginTransaction();
    $stmtDINS = $DbBun->prepare('INSERT INTO bund (topar,fis,csmid,cutime,msmid,mutime) VALUES (:topar,:fis,:csmid,:cutime,:msmid,:mutime)');
    $stmtDINS->execute(array(':topar'=>$topar,':fis'=>$fis,':csmid'=>$csmid,':cutime'=>$cutime,':msmid'=>$msmid,':mutime'=>$mutime));
    $dUr = $DbBun->lastInsertId();
    $stmtDFSEL = $DbBun->prepare('SELECT f,ciana,meit FROM bundf WHERE d=:d');
    $stmtDFSEL->execute(array(':d'=>$d));
    $rows = $stmtDFSEL->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
        $f     = $row['f'];
        $ciana = $row['ciana'];
        $meit  = $row['meit'];
        $stmtDFINS = $DbBun->prepare('INSERT INTO bundf (d,f,ciana,meit) VALUES (:d,:f,:ciana,:meit)');
        $stmtDFINS->execute(array(':d'=>$dUr,':f'=>$f,':ciana'=>$ciana,'meit'=>$meit));
    }
    $DbBun->commit();

    if ($dUr>0) {
        $refreshHtml = "\n    <meta http-equiv=refresh content='1;url=$bunadasURL/d.php?d=$dUr'>";
        $T_Chaidh_drong_a_chopaigeadh = sprintf($T_Chaidh_drong_a_chopaigeadh,$d,$dUr);
        $HTML = "<p>$T_Chaidh_drong_a_chopaigeadh</p>\n";
    }

  } catch (Exception $e) {
      if (strpos($e,'Sgrios')!==FALSE) { $HTML = ''; }
      $HTML .= $e;
  }

  $stordataCss = SM_Bunadas::stordataCss();
  $duilleagHTML = <<<EODduilleag
<!DOCTYPE html>
<html lang="$hl">
<head>
    <meta charset="UTF-8">
    <meta name="google" content="notranslate">
    <meta name="robots" content="noindex,nofollow">
    <title>Bunadas: Dùblaich drong $d</title>$refreshHtml
    <link rel="StyleSheet" href="/css/smo.css">$stordataCss
</head>
<body>

$navbar
<div class="smo-body-indent">

$HTML

</div>
$navbar

</body>
</html>
EODduilleag;

echo $duilleagHTML;

?>

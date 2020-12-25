<?php
  if (!include('autoload.inc.php'))
    header("Location:https://claran.smo.uhi.ac.uk/mearachd/include_a_dhith/?faidhle=autoload.inc.php");
  header('Cache-Control:max-age=0');

  try {
      $moSMO = SM_moSMO::singleton();
      if (!SM_Bunadas::ceadSgriobhaidh()) { $moSMO->diultadh(''); }
  } catch (Exception $e) {
      $moSMO->toradh = $e->getMessage();
  }

  try {
    $stordataConnector = SM_Bunadas::stordataConnector();
    $DbBun = $stordataConnector::singleton('rw');
    $moSMO->dearbhaich();

    $T = new SM_T('bunadas/fSguab');
    $hl = $T::hl0();
    $T_Parameter_mi_iom        = $T->h('Parameter_mi_iom');
    $T_Chaidh_facal_f_sguabadh = $T->h('Chaidh_facal_f_sguabadh');

    $f = (!isset($_REQUEST['f']) ? 0 : $_REQUEST['f']);
    $f = htmlspecialchars($f);
    if (!is_numeric($f) || intval($f)<>$f || $f<1) { throw new SM_Exception("$T_Parameter_mi_iom: f=$f"); }
    $till = (empty($_REQUEST['till']) ? '' : $_REQUEST['till']);
    $till = htmlspecialchars($till);

    $stmtDELETEbundf = $DbBun->prepare('DELETE FROM bundf WHERE f=:f')->execute(array(':f'=>$f));
    $stmtDELETEbunf  = $DbBun->prepare('DELETE FROM bunf  WHERE f=:f')->execute(array(':f'=>$f));

    $T_Chaidh_facal_f_sguabadh = sprintf($T_Chaidh_facal_f_sguabadh,$f);
    $HTML = "<p style='font-size:140%;font-weight:bold'><img src='/icons-smo/sgudal.png' alt=''></p>$T_Chaidh_facal_f_sguabadh</p>\n";

  } catch (Exception $e) {
      if (strpos($e,'Sgrios')!==FALSE) { $HTML = ''; }
      $HTML .= $e;
  }


  $stordataCss = SM_Bunadas::stordataCss();
  echo <<<EODduilleag
<!DOCTYPE html>
<html lang="$hl">
<head>
    <meta charset="UTF-8">
    <meta name="google" content="notranslate">
    <meta name="robots" content="noindex,nofollow">
    <title>Bunadas: Sguab às facal $f</title>
    <meta http-equiv=refresh content="1;url=$till">
    <link rel="StyleSheet" href="/css/smo.css">$stordataCss
</head>
<body>
$HTML
EODduilleag;

?>

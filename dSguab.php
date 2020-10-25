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

    $T = new SM_T('bunadas/dSguab');
    $hl = $T::hl0(); 
    $T_Chaidh_drong_d_a_sguabadh_as = $T->_('Chaidh_drong_d_a_sguabadh_as');

    $d = (!isset($_REQUEST['d']) ? 0 : $_REQUEST['d']);
    $d = htmlspecialchars($d);
    if (!is_numeric($d) || intval($d)<>$d || $d<1) { throw new SM_Exception("Parameter neo-iomchaidh: d=$d"); }

    $stmtDELETEbundf = $DbBun->prepare('DELETE FROM bundf WHERE d=:d')->execute(array(':d'=>$d));
    $stmtDELETEbund  = $DbBun->prepare('DELETE FROM bund  WHERE d=:d')->execute(array(':d'=>$d));

    $T_Chaidh_drong_d_a_sguabadh_as = sprintf($T_Chaidh_drong_d_a_sguabadh_as,$d);
    $HTML = "<p style='font-size:140%;font-weight:bold'><img src='/icons-smo/sgudal.png' alt=''> $T_Chaidh_drong_d_a_sguabadh_as</p>\n";

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
    <title>Bunadas: Sguab às drong $d</title>
    <meta http-equiv=refresh content="1;url=./">
    <link rel="StyleSheet" href="/css/smo.css">$stordataCss
</head>
<body>
$HTML
EODduilleag;

?>

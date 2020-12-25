<?php
  if (!include('autoload.inc.php'))
    header("Location:https://claran.smo.uhi.ac.uk/mearachd/include_a_dhith/?faidhle=autoload.inc.php");
  header('Cache-Control:max-age=0');

  try {
      $moSMO = SM_moSMO::singleton();
//    if (!$moSMO->cead('{logged-in}')) { $moSMO->diultadh(''); }
  } catch (Exception $e) {
      $moSMO->toradh = $e->getMessage();
  }

  $T = new SM_T('bunadas/sgrudDgabh');
  $hl = $T::hl0();
  $T_sgrudDgabh_tiotal = $T->h('sgrudDgabh_tiotal');
  $T_drong             = $T->h('drong');
  $T_drongan           = $T->h('drongan');
  $T_ntoraidheanFios   = $T->h('ntoraidheanFios');

  $smid = $moSMO->id;
  $navbar = SM_Bunadas::navbar($T->domhan);
  $stordataCss = SM_Bunadas::stordataCss();
  $stordataConnector = SM_Bunadas::stordataConnector();
  $DbBun = $stordataConnector::singleton('rw');

  $stmt1 = $DbBun->prepare('SELECT d FROM bund ORDER BY d');
  $stmt1->execute();
  $res = $stmt1->fetchAll(PDO::FETCH_COLUMN);
  $ntoraidhean = 0;
  $toraidheanHtml = '';
  foreach ($res as $d) {
      $stmt2 = $DbBun->prepare('SELECT f FROM bundf WHERE d=:d');
      $stmt2->execute(array(':d'=>$d));
      $fArr = $stmt2->fetchAll(PDO::FETCH_COLUMN);
     if (empty($fArr)) { continue; }
      $dochasaich = [];
      foreach ($fArr as $f) {
          $stmt3 = $DbBun->prepare('SELECT d FROM bundf WHERE f=:f');
          $stmt3->execute(array(':f'=>$f));
          $dArr = $stmt3->fetchAll(PDO::FETCH_COLUMN);
          foreach ($dArr as $d2) {
             if ($d2==$d) { continue; }
              $dochasaich[$d2] = 1;
          }
      }
      foreach (array_keys($dochasaich) as $d2) {
          if (SM_Bunadas::foDrong($d,$d2) == 0) {
              unset($dochasaich[$d2]);
          } else {
              $dochasaich[$d2] = SM_Bunadas::foDrong($d,$d2) + 10 * SM_Bunadas::foDrong($d2,$d);
          }
      }
     if (count($dochasaich)==0) { continue; }
      $toraidheanHtml .= "<p><a href='d.php?d=$d'>$d</a>:";
      foreach (array_keys($dochasaich) as $d2) {
          $flag = $dochasaich[$d2];
          $toraidheanHtml .= " <a href=d.php?d=$d2>$d2</a><span class='fann'>-$flag</span>";
      }
      $toraidheanHtml .= "</p>\n";
      $ntoraidhean++;
  }
  $cunntasDrong = $T->cunntas($ntoraidhean,$T_drong,$T_drongan);
  $T_ntoraidheanFios = sprintf($T_ntoraidheanFios,$cunntasDrong);
  $toraidheanHtml = <<<EODTOR
<p style="margin-top:2em;background-color:grey; color:white; padding:2px 6px; max-width:50em">$T_ntoraidheanFios</p>
<table id='tor'>
$toraidheanHtml
</table>
EODTOR;

  echo <<<EODHtmlTus
<!DOCTYPE html>
<html lang="$hl">
<head>
    <meta charset="UTF-8">
    <meta name="google" content="notranslate">
    <meta name="robots" content="noindex,nofollow">
    <title>Bunadas: $T_sgrudDgabh_tiotal</title>
    <link rel="StyleSheet" href="/css/smo.css">
    <link rel="StyleSheet" href="snas.css.php">$stordataCss
    <style>
       table#tor { border-collapse:collapse; margin-top:1em; text-align:right; }
       table#tor td { padding:5px; }
    </style>
    <script>
        function teangaUr(sel) {
            sel.parentNode.parentNode.lang = sel.value;
        }
    </script>
</head>
<body>

$navbar
<div class="smo-body-indent">
EODHtmlTus;

  try {
    $moSMO->dearbhaich();
    $smid = $moSMO->id;
    echo <<<EODHtmlCeann
<a href="./"><img src="dealbhan/bunadas64.png" style="float:left;border:1px solid black;margin:0 2em 2em 0" alt=""></a>
<h1 class=smo>$T_sgrudDgabh_tiotal</h1>

$toraidheanHtml
EODHtmlCeann;

  } catch (Exception $e) { echo $e; }

  echo <<<EODHtmlEis
</div>
$navbar

</body>
</html>
EODHtmlEis

?>

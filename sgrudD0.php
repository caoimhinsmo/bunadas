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

  $T = new SM_T('bunadas/sgrudD0');
  $hl = $T::hl0();
  $T_sgrudD0_tiotal  = $T->_('sgrudD0_tiotal');
  $T_drong           = $T->_('drong');
  $T_drongan         = $T->_('drongan');
  $T_ntoraidheanFios = $T->_('ntoraidheanFios');

  $smid = $moSMO->id;
  $navbar = SM_Bunadas::navbar($T->domhan);
  $stordataCss = SM_Bunadas::stordataCSS();
  $stordataConnector = SM_Bunadas::stordataConnector();
  $DbBun = $stordataConnector::singleton('rw');

  $querySEL = 'SELECT bund.d, bund.topar FROM bund LEFT JOIN bundf ON bundf.d=bund.d WHERE bundf.f IS NULL ORDER BY d';
  $stmtSEL = $DbBun->prepare($querySEL);
  $stmtSEL->execute();
  $toraidhean = $stmtSEL->fetchAll(PDO::FETCH_OBJ);
  $ntoraidhean = count($toraidhean);
  foreach ($toraidhean as $r) {
      $d     = $r->d;
      $topar = $r->topar;
      $toraidheanHtml .= "<tr><td><a href='d.php?d=$d'>$d</a></td><td>$topar</td></tr>\n";
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
<html lang="$ul">
<head>
    <meta charset="UTF-8">
    <meta name="google" content="notranslate">
    <meta name="robots" content="noindex,nofollow">
    <title>Bunadas: $T_sgrudD0_tiotal</title>
    <link rel="StyleSheet" href="/css/smo.css">
    <link rel="StyleSheet" href="snas.css">$stordataCss
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
<h1 class=smo>$T_sgrudD0_tiotal</h1>

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

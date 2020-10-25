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

  $T = new SM_T('bunadas/sgrudDmor');
  $hl = $T::hl0();
  $T_sgrudDmor_tiotal = $T->_('sgrudDmor_tiotal');
  $T_ntoraidheanFios  = $T->_('ntoraidheanFios');

  $smid = $moSMO->id;
  $navbar = SM_Bunadas::navbar($T->domhan);
  $stordataCss = SM_Bunadas::stordataCss();
  $stordataConnector = SM_Bunadas::stordataConnector();
  $DbBun = $stordataConnector::singleton('rw');

  $n = (isset($_GET['n']) ? $_GET['n'] : 200);
  if (!is_numeric($n) || intval($n)<>$n) { $n = 200; }

  $stmtSEL  = $DbBun->prepare("SELECT d, COUNT(1) AS cnt FROM bundf GROUP BY d ORDER BY cnt DESC, d LIMIT $n");
  $stmtSEL2 = $DbBun->prepare('SELECT f FROM bundf WHERE d=:d AND ciana=0');

  $stmtSEL->execute();
  $toraidhean = $stmtSEL->fetchAll(PDO::FETCH_OBJ);
  $ntoraidhean = count($toraidhean);
  foreach ($toraidhean as $r) {
      $d     = $r->d;
      $cnt   = $r->cnt;
      $stmtSEL2->execute([':d'=>$d]);
      $faclanArr = $stmtSEL2->fetchALL(PDO::FETCH_COLUMN);
      foreach ($faclanArr as &$f) { $f = SM_Bunadas::fHTML($f); }
      $faclan = implode(' ',$faclanArr);
      $toraidheanHtml .= "<tr><td><a href='d.php?d=$d'>$d</a></td><td>($cnt)</td><td>$faclan</td></tr>\n";
  }
  $T_ntoraidheanFios = sprintf($T_ntoraidheanFios,$ntoraidhean);
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
    <title>Bunadas: $T_sgrudDmor_tiotal</title>
    <link rel="StyleSheet" href="/css/smo.css">
    <link rel="StyleSheet" href="snas.css">$stordataCss
    <style>
       table#tor { border-collapse:collapse; margin-top:1em; text-align:right; }
       table#tor td { padding:5px; }
       table#tor td:nth-child(3) { text-align:left; }
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
<h1 class=smo>$T_sgrudDmor_tiotal</h1>

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

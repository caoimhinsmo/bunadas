<?php
  if (!include('autoload.inc.php'))
    header("Location:https://claran.smo.uhi.ac.uk/mearachd/include_a_dhith/?faidhle=autoload.inc.php");
  header('Cache-Control:max-age=0');

  try {
      $myCLIL = SM_myCLIL::singleton();
//    if (!$myCLIL->cead('{logged-in}')) { $myCLIL->diultadh(''); }
  } catch (Exception $e) {
      $myCLIL->toradh = $e->getMessage();
  }

  $T = new SM_T('bunadas/sgrudD1');
  $hl = $T::hl0();
  $T_sgrudD1_tiotal  = $T->h('sgrudD1_tiotal');
  $T_drong           = $T->h('drong');
  $T_drongan         = $T->h('drongan');
  $T_ntoraidheanFios = $T->h('ntoraidheanFios');

  $smid = $myCLIL->id;
  $navbar = SM_Bunadas::navbar($T->domhan);
  $stordataCss = SM_Bunadas::stordataCss();
  $stordataConnector = SM_Bunadas::stordataConnector();
  $DbBun = $stordataConnector::singleton('rw');

  $n = (isset($_GET['n']) ? $_GET['n'] : 1);

  $querySEL = 'SELECT d, COUNT(1) AS cnt FROM bundf GROUP BY d HAVING cnt=:n';
  $stmtSEL = $DbBun->prepare($querySEL);
  $stmtSEL->execute(array(':n'=>$n));
  $toraidhean = $stmtSEL->fetchAll(PDO::FETCH_OBJ);
  $ntoraidhean = count($toraidhean);
  foreach ($toraidhean as $r) {
      $d     = $r->d;
      $toraidheanHtml .= "<tr><td><a href='d.php?d=$d'>$d</a></td></tr>\n";
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
    <title>Bunadas: $T_sgrudD1_tiotal</title>
    <link rel="StyleSheet" href="/css/smo.css">
    <link rel="StyleSheet" href="snas.css.php">$stordataCss
    <style>
       table#tor { border-collapse:collapse; margin-top:1em; text-align:center; }
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
    $myCLIL->dearbhaich();
    $smid = $myCLIL->id;
    echo <<<EODHtmlCeann
<a href="./"><img src="dealbhan/bunadas64.png" style="float:left;border:1px solid black;margin:0 2em 2em 0" alt=""></a>
<h1 class=smo>$T_sgrudD1_tiotal</h1>

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

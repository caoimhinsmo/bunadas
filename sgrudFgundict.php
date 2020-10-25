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

  $T = new SM_T('bunadas/sgrudF0');
  $hl = $T::hl0();
  $T_sgrudFgundict_tiotal = $T->_('sgrudFgundict_tiotal');
  $T_facal           = $T->_('facal');
  $T_facail          = $T->_('facail');
  $T_ntoraidheanFios = $T->_('ntoraidheanFios');

  $smid = $moSMO->id;
  $navbar = SM_Bunadas::navbar($T->domhan);
  $stordataCss = SM_Bunadas::stordataCss();
  $stordataConnector = SM_Bunadas::stordataConnector();
  $DbBun = $stordataConnector::singleton('rw');

  $querySEL = "SELECT bunf.f FROM bunf LEFT JOIN bunfDict ON bunfDict.f=bunf.f WHERE t='sga' AND bunfDict.f IS NULL ORDER BY focal,derb";
  $stmtSEL = $DbBun->prepare($querySEL);
  $stmtSEL->execute();
  $toraidhean = $stmtSEL->fetchAll(PDO::FETCH_OBJ);
  $ntoraidhean = count($toraidhean);
  foreach ($toraidhean as $r) {
      $f = $r->f;
      $toraidheanHtml .= '<tr><td>' . SM_Bunadas::fHTML($f) . "</td></tr>\n";
  }
  $cunntasFacal = $T->cunntas($ntoraidhean,$T_facal,$T_facail);
  $T_ntoraidheanFios = sprintf($T_ntoraidheanFios,$cunntasFacal);
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
    <title>Bunadas: $T_sgrudFgundict_tiotal</title>
    <link rel="StyleSheet" href="/css/smo.css">
    <link rel="StyleSheet" href="snas.css">$stordataCss
    <style>
       table#tor { border-collapse:collapse; margin-top:1em; }
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
<h1 class=smo>$T_sgrudFgundict_tiotal</h1>

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

<?php
  if (!include('autoload.inc.php'))
    header("Location:https://claran.smo.uhi.ac.uk/mearachd/include_a_dhith/?faidhle=autoload.inc.php");
  header('Cache-Control:max-age=0');

  try {
    $moSMO = SM_moSMO::singleton();

    $T = new SM_T('bunadas/lorg');
    $hl = $T::hl0();
    $T_Lorg_facal       = $T->h('Lorg facal');
    $T_Canan            = $T->h('Language');
    $T_Facal            = $T->h('Facal');
    $T_Facal_ph         = $T->h('Facal_ph');
    $T_Gluas            = $T->h('Gluas');
    $T_Gluas_ph         = $T->h('Gluas_ph');
    $T_Lorg             = $T->h('Lorg');
    $T_priomhLit        = $T->h('priomhLit');
    $T_facal            = $T->h('facal');
    $T_facail           = $T->h('facail');
    $T_ntoraidheanFios  = $T->h('ntoraidheanFios');
    $T_Cruthaich_facal  = $T->h('Cruthaich facal ùr');

    $ainmTeanga = SM_Bunadas::ainmTeanga();
    $teangaithe = array_keys($ainmTeanga);
    $conditionArr = $executeArr = array();
    $fqHtml = $gluasqHtml = $plChecked = $tq = '';
    if (!empty($_REQUEST['pl'])) { $plChecked = 'checked'; }
    if (!empty($_REQUEST['t'])) {
        $tq = $_REQUEST['t'];
        if (in_array($tq,$teangaithe)) { $conditionArr['t'] = 'bunf.t LIKE :t'; }
         else { $tq = ''; }
    }
    if (!empty($_REQUEST['gluas'])) {
        $gluasq = trim($_REQUEST['gluas']);
        $gluasq = '%' . strtr($gluasq,array('*'=>'%')) . '%';
        $gluasq = strtr($gluasq,array('%_'=>'%','_%'=>'%','%%'=>'%'));
        $gluasq = strtr($gluasq,array('%_'=>'%','_%'=>'%','%%'=>'%'));
        $gluasqHtml = htmlspecialchars(strtr($gluasq,array('%'=>'*')));
        if ($gluasqHtml=='%') { $gluasqHtml = ''; }
        $conditionArr['gluas'] = 'gluas LIKE :gluas';
    }
    if (!empty($_REQUEST['f'])) {
        $fq = trim($_REQUEST['f']);
        if (is_numeric($fq)) {
            $fqHtml = $fq;
            $tqHtml = $gluasqHtml = '';
            $conditionArr = array('f' => 'bunf.f=:f');
        } else {
            $fq = strtr($fq,array('*'=>'%'));
            $fq = strtr($fq,array('%_'=>'%','_%'=>'%','%%'=>'%'));
            $fqHtml = htmlspecialchars(strtr($fq,array('%'=>'*')));
            $conditionArr['f'] = ( $plChecked
                                 ? 'focal LIKE :f'
                                 : '(focal LIKE :f OR lit LIKE :f)'
                                 );
        }
    }

    $selectTHtml  = "<select name='t'>\n";
    $selectTHtml .= "<option value=''" . ($tq=='' ? ' selected' : '') . " lang=''>" . "</option>\n";
    foreach ($teangaithe as $t) { $selectTHtml .= "<option value='$t'" . ($tq==$t ? ' selected' : '') . " lang='$t'>" . $ainmTeanga[$t] . "</option>\n"; }
    $selectTHtml .= "</select>\n";  

    $toraidheanHtml = $cruthaichFocalHtml = '';
    if (count($conditionArr)>0) {
        $condition = implode (' AND ',$conditionArr);
        $stordataConnector = SM_Bunadas::stordataConnector();
        $DbBun = $stordataConnector::singleton('rw');
        $querySEL = "SELECT DISTINCT bunf.f FROM bunf LEFT JOIN bunfLit ON bunf.f=bunfLit.f LEFT JOIN bunt ON bunf.t=bunt.t WHERE $condition ORDER BY parentage_ord,focal,derb";
        $stmtSEL = $DbBun->prepare($querySEL);
        if (isset($conditionArr['t']))     { $executeArr['t']     = $tq;     }
        if (isset($conditionArr['f']))     { $executeArr['f']     = $fq;     }
        if (isset($conditionArr['gluas'])) { $executeArr['gluas'] = $gluasq; }
        $stmtSEL->execute($executeArr);
        $toraidhean = $stmtSEL->fetchAll(PDO::FETCH_COLUMN);
        $ntoraidhean = count($toraidhean);
        foreach ($toraidhean as $f) { $toraidheanHtml .= '<tr><td>' . SM_Bunadas::fHTML($f) . "</td></tr>\n"; }
        if (SM_Bunadas::ceadSgriobhaidh()) {
            $fqURL = urlencode($fq);
            $multidictHtml = "<a href='//multidict.net/multidict/?sl=$tq&amp;word=$fqURL'><img src='dealbhan/multidict.png' style='margin-right:10px' alt=''></a>";
            $cruthaichFocalHtml = "<p style='margin-bottom:0.2em'>⇒ <a href='fDeasaich.php?f=0&amp;t=$tq&amp;focal=$fqURL'>$T_Cruthaich_facal</a> $multidictHtml</p>";
        }
        $cunntasFacal = $T->cunntas($ntoraidhean,$T_facal,$T_facail);
        $T_ntoraidheanFios = sprintf($T_ntoraidheanFios,$cunntasFacal);
        $toraidheanHtml = <<<EODTOR
<p style="margin-top:2em;background-color:grey; color:white; padding:2px 6px; max-width:50em">$T_ntoraidheanFios</p>
<table id='tor'>
$toraidheanHtml
</table>
$cruthaichFocalHtml
EODTOR;
    }

    $formHtml = <<<EODFORM
<form method="get" style="clear:both">
<table>
<tr><td title="Language">$T_Canan</td><td title="Word">$T_Facal</td><td>$T_Gluas</td><td></td></tr>
<tr style="vertical-align:top">
<td>$selectTHtml</td>
<td><input name="f" value="$fqHtml" placeholder="$T_Facal_ph" style="width:25em"><br>
    <label><input type=checkbox name=pl $plChecked> <span style="font-size:60%">$T_priomhLit</label></td>
<td><input name="gluas" value="$gluasqHtml" placeholder="$T_Gluas_ph" style="width:15em"></td>
<td><input type="submit" name="lorg" value="$T_Lorg"></td>
</table>
</tr>
</form>
EODFORM;

    $navbar = SM_Bunadas::navbar($T->domhan);
    $stordataCss = SM_Bunadas::stordataCss();

    $HTML = <<<EODHTML
<!DOCTYPE html>
<html lang="$hl">
<head>
    <meta charset="UTF-8">
    <meta name="google" content="notranslate">
    <meta name="robots" content="noindex,nofollow">
    <title>Bunadas: $T_Lorg_facal</title>
    <link rel="StyleSheet" href="/css/smo.css">
    <link rel="StyleSheet" href="snas.css.php">$stordataCss
    <style>
       table#tor { border-collapse:collapse; margin:1em 0 2.5em 0; }
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

<a href="./"><img src="dealbhan/bunadas64.png" style="float:left;border:1px solid black;margin:0 2em 2em 0" alt=""></a>
<h1 class=smo title="Find a word">$T_Lorg_facal</h1>

$formHtml

$toraidheanHtml

</div>
$navbar

</body>
</html>
EODHTML;

    echo $HTML;

  } catch (Exception $e) { echo $e; }
?>

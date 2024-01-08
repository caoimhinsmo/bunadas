<?php
  if (!include('autoload.inc.php'))
    header("Location:https://claran.smo.uhi.ac.uk/mearachd/include_a_dhith/?faidhle=autoload.inc.php");
  header('Cache-Control:max-age=0');

  try {
    $T = new SM_T('bunadas/lorg');
    $hl = $T::hl0();
    $T_Lorg_facal = $T->h('Lorg facal');
    $T_Canan      = $T->h('Language');
    $T_Facal      = $T->h('Facal');
    $T_Facal_ph   = $T->h('Facal_ph');
    $T_Gluas      = $T->h('Gluas');
    $T_Gluas_ph   = $T->h('Gluas_ph');
    $T_Lorg       = $T->h('Lorg');
    $T_priomhLit  = $T->h('priomhLit');
    $T_facal      = $T->h('facal');
    $T_facail     = $T->h('facail');
    $T_ntoraidheanFios    = $T->h('ntoraidheanFios');
    $T_Cruthaich_facal_ur = $T->h('Cruthaich_facal_ur');
    $T_Inexact_matches    = $T->h('Inexact_matches');

    $toraidheanHtml = $cruthaichFocalHtml = $conditionf_ci = $toraidhean_ci_Html = '';

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
            if ($plChecked) {
                $conditionArr['f'] = 'focal LIKE :f';
                $conditionf_ci     = 'focal_ci LIKE :f';
            } else {
                $conditionArr['f'] = '(focal LIKE :f OR lit LIKE :f)';
                $conditionf_ci     = '(focal_ci LIKE :f OR lit_ci LIKE :f)';
            }
        }
    }

    $selectTHtml  = "<select name='t'>\n";
    $selectTHtml .= "<option value=''" . ($tq=='' ? ' selected' : '') . " lang=''>" . "</option>\n";
    foreach ($teangaithe as $t) { $selectTHtml .= "<option value='$t'" . ($tq==$t ? ' selected' : '') . " lang='$t'>" . $ainmTeanga[$t] . "</option>\n"; }
    $selectTHtml .= "</select>\n";  

    if (count($conditionArr)>0) {
        $condition = implode (' AND ',$conditionArr);
        $stordataConnector = SM_Bunadas::stordataConnector();
        $DbBun = $stordataConnector::singleton('rw');
        $querySELsel = 'SELECT DISTINCT bunf.f FROM bunf LEFT JOIN bunfLit ON bunf.f=bunfLit.f LEFT JOIN bunt ON bunf.t=bunt.t';
        $querySELord = 'ORDER BY parentage_ord,focal_ci,focal,derb';
        $querySEL = "$querySELsel WHERE $condition $querySELord";
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
            $multidictHtml   = "<a href='//multidict.net/multidict/?sl=$tq&amp;word=$fqURL'>"
                             . "<img src='dealbhan/multidict.png' style='margin-right:10px' alt=''></a>";
            $wiktionaryHtml  = "<a href='//en.wiktionary.org/wiki/$fqURL'>"
                             . "<img src='/favicons/wiktionary.png' style='margin-right:12px' alt=''></a>";
//            $etymologeekHtml = "<a href='//etymologeek.com/search/all/$fqURL'>"
//                             . "<img src='/favicons/etymologeek.png' alt=''></a>";
            $cruthaichFocalHtml = "<p style='margin-bottom:0.2em'>⇒ <a href='fDeasaich.php?f=0&amp;t=$tq&amp;focal=$fqURL'>"
                                . "$T_Cruthaich_facal_ur</a> $multidictHtml $wiktionaryHtml</p>";
        }
        $cunntasFacal = $T->cunntas($ntoraidhean,$T_facal,$T_facail);
        $T_ntoraidheanFios = sprintf($T_ntoraidheanFios,$cunntasFacal);
        if (!empty($conditionf_ci)) {
            $conditionArr_ci = $conditionArr;
            $executeArr_ci   = $executeArr;
            $fq_ci = SM_Bunadas::lomm($fq);
           $fq_ci = strtr($fq_ci,['·'=>'-']); //Atharraich seo ma atharraicheas sinn uaireigin '-' gu '·' ann an sga ann am Bunadas
            $conditionArr_ci['f'] = $conditionf_ci;
            $executeArr_ci['f']   = $fq_ci;
            $condition_ci = implode (' AND ',$conditionArr_ci);
            $querySEL_ci = "$querySELsel WHERE $condition_ci $querySELord";
            $stmtSEL_ci = $DbBun->prepare($querySEL_ci);
            $stmtSEL_ci->execute($executeArr_ci);
            $toraidhean_ci = array_diff( $stmtSEL_ci->fetchAll(PDO::FETCH_COLUMN), $toraidhean);
            foreach ($toraidhean_ci as $f) { $toraidhean_ci_Html .= SM_Bunadas::fHTML($f) . ' '; }
            if (!empty($toraidhean_ci)) {
                $toraidhean_ci_Html = <<<EODTORci
                    <div style='font-size:65%;background-color:#eee;border:1px solid black;border-radius:0.5em;padding:1px 0 3px 6px;margin-left:3em;max-width:80em'>
                    <p style="margin:0 0 2px 2px">$T_Inexact_matches</p>
                    $toraidhean_ci_Html
                    </div>
                    EODTORci;
            }
        }
        $toraidheanHtml = <<<EODTOR
            <p style="margin-top:2em;background-color:grey; color:white; padding:2px 6px; max-width:50em">$T_ntoraidheanFios</p>
            <table id='tor'>
            $toraidheanHtml
            </table>
            $toraidhean_ci_Html
            $cruthaichFocalHtml
            EODTOR;
    }

    $formHtml = <<<EODFORM
        <form method="get" style="clear:both">
        <table>
        <tr><td title="Language">$T_Canan</td><td title="Word">$T_Facal</td><td>$T_Gluas</td><td></td></tr>
        <tr style="vertical-align:top">
        <td>$selectTHtml</td>
        <td><input name="f" value="$fqHtml" type=text placeholder="$T_Facal_ph" style="width:25em"><br>
            <label><input type=checkbox name=pl $plChecked> <span style="font-size:60%">$T_priomhLit</label></td>
        <td><input name="gluas" value="$gluasqHtml" type=text placeholder="$T_Gluas_ph" style="width:15em"></td>
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
               input[type=text]:not(:placeholder-shown) { background-color:yellow; }
            </style>
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

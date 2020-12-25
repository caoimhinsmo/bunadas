<?php
  if (!include('autoload.inc.php'))
    header("Location:https://claran.smo.uhi.ac.uk/mearachd/include_a_dhith/?faidhle=autoload.inc.php");
  header("Cache-Control:max-age=0");

  try {
      $moSMO = SM_moSMO::singleton();
      if (!SM_Bunadas::ceadSgriobhaidh()) { $moSMO->diultadh(''); }
  } catch (Exception $e) {
      $moSMO->toradh = $e->getMessage();
  }

  try {
    $moSMO->dearbhaich();
    $T = new SM_T('bunadas/fDeasaich');
    $hl = $T::hl0();
    $T_Cruthaich_facal_ur  = $T->h('Cruthaich facal ùr');
    $T_Atharraich_facal    = $T->h('Atharraich facal');
    $T_canan               = $T->h('language');
    $T_facal               = $T->h('facal');
    $T_derb                = $T->h('derb');
    $T_gram                = $T->h('gram');
    $T_gluas               = $T->h('gluas');
    $T_IPA                 = $T->h('IPA');
    $T_fis                 = $T->h('fis');
    $T_Sabhail             = $T->h('Sàbhail');
    $T_Parameter_mi_iom    = $T->h('Parameter_mi_iom');
    $T_Chan_eil_facal_f    = $T->h('Chan eil facal %d ann idir');
    $T_Feumaidh_tu_canan   = $T->h('Feumaidh tu cànan a thaghadh');
    $T_Feumaidh_tu_facal   = $T->h('Cha do sgrìobh thu facal sam bith');
    $T_Atharrachadh_soirbh = $T->h('Atharrachadh soirbheachail');
    $T_Facal_ur_ann        = $T->h('Chaidh am facal a chur ann');
    $T_Facal_ann_mu_thrath = $T->h('Facal_ann_mu_thrath');

    $T_Facal_ann_mu_thrath = strtr ($T_Facal_ann_mu_thrath, [ '{' => "<a href='lorg.php?t=%s&amp;f=%s&amp;derb=%s'>", '}' => '</a>' ] );

    $smid = $moSMO->id;
    $bunadasURL = SM_Bunadas::bunadasurl();
    $navbar = SM_Bunadas::navbar($T->domhan);

    $fUr = -1;
    $HTML = $foirmHTML = $fiosMearachd = $refreshHtml = $h1 = '';

    $f = ( !isset($_REQUEST['f']) ? 0 : htmlspecialchars($_REQUEST['f']) );
    $d = ( !isset($_REQUEST['d']) ? 0 : htmlspecialchars($_REQUEST['d']) ); //Drong far an téid am focal ùr, ma ’s e focal ùr a th’ann
    if (!is_numeric($f) || intval($f)<>$f || $f<0) { throw new SM_Exception("$T_Parameter_mi_iom: f=$f"); }
    if (!is_numeric($d) || intval($d)<>$d || $d<0) { throw new SM_Exception("$T_Parameter_mi_iom: d=$d"); }

    $stordataConnector = SM_Bunadas::stordataConnector();
    $DbBun = $stordataConnector::singleton('rw');
    $stmtSEL = $DbBun->prepare('SELECT t,focal,derb,gram,gluas,ipa,fis FROM bunf WHERE f=:f');
    $stmtSEL->execute(array(':f'=>$f));
    $stmtSEL->bindColumn(1,$tRoimhe);
    $stmtSEL->bindColumn(2,$focalRoimhe);
    $stmtSEL->bindColumn(3,$derbRoimhe);
    $stmtSEL->bindColumn(4,$gramRoimhe);
    $stmtSEL->bindColumn(5,$gluasRoimhe);
    $stmtSEL->bindColumn(6,$ipaRoimhe);
    $stmtSEL->bindColumn(7,$fisRoimhe);
    if ($f==0) {  //Facal ùr
        $tRoimhe = $focalRoimhe = $derbRoimhe = $gramRoimhe = $gluasRoimhe = $ipaRoimhe = $fisRoimhe = '';
        if (!empty($_REQUEST['t']))     { $tRoimhe     = trim($_REQUEST['t']);     }
        if (!empty($_REQUEST['focal'])) { $focalRoimhe = trim($_REQUEST['focal']); }
    } elseif (!$stmtSEL->fetch()) {
        throw new SM_Exception(sprintf($T_Chan_eil_facal_f,$f));
    } else {
        $tRoimhe     = htmlspecialchars($tRoimhe);
        $focalRoimhe = htmlspecialchars($focalRoimhe);
        $derbRoimhe  = htmlspecialchars($derbRoimhe);
        $gramRoimhe  = htmlspecialchars($gramRoimhe);
        $gluasRoimhe = htmlspecialchars($gluasRoimhe);
        $ipaRoimhe   = htmlspecialchars($ipaRoimhe);
        $fisRoimhe   = htmlspecialchars($fisRoimhe);
    }

    if (!empty($_REQUEST['sabhail'])) {
        $tUr     = trim($_REQUEST['t']);
        $focalUr = trim($_REQUEST['focal']);
        $derbUr  = trim($_REQUEST['derb']);
        $gramUr  = trim($_REQUEST['gram']);
        $gluasUr = trim($_REQUEST['gluas']);
        $ipaUr   = trim($_REQUEST['ipa']);
        $fisUr   = trim($_REQUEST['fis']);
        $utime = time();
        if (empty($tUr))     { throw new SM_Exception("sgrios|bog|$T_Feumaidh_tu_canan"); }
        if (empty($focalUr)) { throw new SM_Exception("sgrios|bog|$T_Feumaidh_tu_facal"); }
        if ($f==0) {
            $stmtATHARRAICH = $DbBun->prepare('INSERT IGNORE INTO bunf (t,focal,derb,gram,gluas,ipa,fis,csmid,cutime,msmid,mutime) VALUES (:t,:focal,:derb,:gram,:gluas,:ipa,:fis,:csmid,:cutime,:msmid,:mutime)');
            $stmtATHARRAICH->execute( array(':t'=>$tUr, ':focal'=>$focalUr, ':derb'=>$derbUr, ':gram'=>$gramUr, ':gluas'=>$gluasUr, ':ipa'=>$ipaUr, ':fis'=>$fisUr, ':csmid'=>$smid, ':cutime'=>$utime, ':msmid'=>$smid, ':mutime'=>$utime) );
        } else {
            $stmtATHARRAICH = $DbBun->prepare('UPDATE IGNORE bunf SET t:=:t, focal=:focal, derb=:derb, gram=:gram, gluas=:gluas, ipa=:ipa, fis=:fis, msmid=:smid, mutime=:utime WHERE f=:f');
            $stmtATHARRAICH->execute( array(':f'=>$f, ':t'=>$tUr, ':focal'=>$focalUr, ':derb'=>$derbUr, ':gram'=>$gramUr, ':gluas'=>$gluasUr, ':ipa'=>$ipaUr, ':fis'=>$fisUr, ':smid'=>$smid, ':utime'=>$utime) );
        }
        if ($stmtATHARRAICH->rowCount()==1) {
            if ($f>0) {
                $fUr = $f;
            } else {
                $fUr = $DbBun->lastInsertId();
                if (!empty($d)) { $refreshHtml = "\n    <meta http-equiv=refresh content='1;url=$bunadasURL/d.php?cuirRi=$fUr&amp;d=$d&amp;f=$fUr'>"; } //Cuir am focal ùr ann an drong $d
            }
        } else {
            $fiosMearachd = sprintf($T_Facal_ann_mu_thrath,$tUr,$focalUr,$derbUr);
        }
    }

    if ($refreshHtml=='' && $fUr>0) { $refreshHtml = "\n    <meta http-equiv=refresh content='1;url=$bunadasURL/f.php?f=$fUr'>"; }

    if ($fUr==$f) {
        $HTML .= "<p><img src='/icons-smo/tick.gif' alt=''> $T_Atharrachadh_soirbh</p>\n";
    } elseif ($fUr>0) {
        $HTML .= "<p><img src='/icons-smo/tick.gif' alt=''> $T_Facal_ur_ann</p>\n";
    } else {
        $h1 = ( $f==0 ? $T_Cruthaich_facal_ur : "$T_Atharraich_facal $f" );
        $HTML .= <<<EODHtmlCeann
<a href="./"><img src="dealbhan/bunadas64.png" style="float:left;border:1px solid black;margin:0 2em 2em 0" alt=""></a>
<h1 class=smo>$h1</h1>
EODHtmlCeann;

        if (!empty($fiosMearachd)) {
            $HTML .= "<p style=\"color:red;font-weight:bold\">$fiosMearachd</p>\n";
        } else {
            $ainmTeanga = SM_Bunadas::ainmTeanga();
            $teangaithe = array_keys($ainmTeanga);
            $selectTHtml = "<select name='t'>\n";
            foreach ($teangaithe as $t) { $selectTHtml .= "<option value='$t'" . ($t==$tRoimhe?' selected':'') . " lang='$t'>" . $ainmTeanga[$t] . " ($t)</option>\n"; }
            $selectTHtml .= "</select>\n";


$selectTHtml = <<<END_selectTHtml
<input type=hidden id=tHidden name=t value=''>
<button type=button id=testButton value=''>TestButton</button>
<script>
function setT(lang,el) {
    document.getElementById('tHidden').value = lang;
    document.getElementById('testButton').value = lang;
    document.getElementById('testButton').innerHTML = el.innerHTML;
}
</script>
<button type=button onClick="setT('gd',this)">Gàidhlig</button>
<button type=button onClick="setT('ga',this)">Gaeilge</button>
<button type=button onClick="setT('gv',this)">Gaelg</button>
END_selectTHtml;

            $HTML .= <<<EODHtmlFoirm
<datalist id="gramList"><option value="root"><option value="n"><option value="v"><option value="adj"><option value="adverb"><option value="prefix"><option value="infix"><option value="suffix"><option value="placename"><option value="pronoun"><option value="numeral"><option value="determiner"></datalist>
<form id=priomhFoirm method=get action="" style="clear:both">
<input type="hidden" name="f" value="$f">
<input type="hidden" name="d" value="$d">
<table id=form>
<col style="width:4.2em"><col>
<tr><td>$T_canan</td><td>$selectTHtml</td></tr>
<tr><td>$T_facal</td><td><input style="width:20em" name="focal" value="$focalRoimhe" lang="$tRoimhe" spellcheck="true"></td></tr>
<tr style="font-size:80%"><td>$T_derb</td><td><input style="width:8em;font-size:80%;margin-left:1em" name="derb"  value="$derbRoimhe"></td></tr>
<tr><td>&nbsp;</td</tr>
<tr><td>$T_gram</td><td><input style="width:7em" name="gram" id="gram" value="$gramRoimhe" list="gramList"></td></tr>
<tr><td>$T_gluas</td><td><input style="width:100%" name="gluas" value="$gluasRoimhe"></td></tr>
<tr><td>&nbsp;</td</tr>
<tr><td>$T_IPA</td><td><input style="width:25em" name="ipa" value="$ipaRoimhe"></td></tr>
<tr><td>$T_fis</td><td><input style="width:100%" name="fis" value="$fisRoimhe"></td></tr>
<tr><td colspan=2 style='text-align:left'><input type=submit name="sabhail" value="$T_Sabhail"></td></tr>
</table>
</form>
EODHtmlFoirm;
        }
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
    <title>Bunadas: $h1</title>$refreshHtml
    <link rel="StyleSheet" href="/css/smo.css">
    <link rel="StyleSheet" href="snas.css.php">$stordataCss
    <style>
        table#form { width:100%; }
        table#form tr td:first-child { text-align:right; }
        button[value=gd] { background-color:blue; }
        button[value=ga] { background-color:green; }
        button[value=gv] { background-color:red; }
    </style>
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

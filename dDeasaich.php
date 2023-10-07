<?php
  if (!include('autoload.inc.php'))
    header("Location:https://claran.smo.uhi.ac.uk/mearachd/include_a_dhith/?faidhle=autoload.inc.php");
  header("Cache-Control:max-age=0");

  try {
      $myCLIL = SM_myCLIL::singleton();
      if (!SM_Bunadas::ceadSgriobhaidh()) { $myCLIL->diultadh(''); }
  } catch (Exception $e) {
      $myCLIL->toradh = $e->getMessage();
  }

  try {
    $myCLIL->dearbhaich();
    $T = new SM_T('bunadas/dDeasaich');
    $hl = $T::hl0();
    $T_Cruthaich_drong_ur  = $T->h('Cruthaich drong ùr');
    $T_Atharraich_drong    = $T->h('Atharraich drong');
    $T_topar               = $T->h('topar');
    $T_fis                 = $T->h('fis');
    $T_Sabhail             = $T->h('Sàbhail');
    $T_Parameter_mi_iom    = $T->h('Parameter_mi_iom');
    $T_Chan_eil_drong_d    = $T->h('Chan_eil_drong_d');
    $T_Feumaidh_tu_topar   = $T->h('Feumaidh_tu_topar');
    $T_Drong_ann_mu_thrath = $T->h('Drong_ann_mu_thrath');
    $T_failig_INSERT       = $T->h('failig_INSERT');
    $T_Atharrachadh_soirbh = $T->h('Atharrachadh soirbheachail');
    $T_Drong_ur_ann        = $T->h('Chaidh an drong a chur ann');

    $smid = $myCLIL->id;
    $bunadasURL = SM_Bunadas::bunadasurl();
    $navbar = SM_Bunadas::navbar($T->domhan);

    $dUr = -1;
    $HTML = $foirmHTML = $fiosMearachd = $h1 = '';

    $d = (!isset($_REQUEST['d']) ? 0 : $_REQUEST['d']);
    $d = htmlspecialchars($d);
    if (!is_numeric($d) || intval($d)<>$d || $d<0) { throw new SM_Exception("$T_Parameter_mi_iom: d=$d"); }
    $f = (!isset($_REQUEST['f']) ? 0 : $_REQUEST['f']);
    $f = htmlspecialchars($f);
    if (!is_numeric($f) || intval($f)<>$f || $f<0) { throw new SM_Exception("$T_Parameter_mi_iom: f=$f"); }

    $stordataConnector = SM_Bunadas::stordataConnector();
    $DbBun = $stordataConnector::singleton('rw');
    $stmtSEL = $DbBun->prepare('SELECT topar,fis FROM bund WHERE d=:d');
    $stmtSEL->execute(array(':d'=>$d));
    $stmtSEL->bindColumn(1,$toparRoimhe);
    $stmtSEL->bindColumn(2,$fisRoimhe);
    if ($d==0) {  //Drong ùr
        $toparRoimhe = 'Wikt';
        $fisRoimhe = '';
    } elseif (!$stmtSEL->fetch()) {
        throw new SM_Exception(sprintf($T_Chan_eil_drong_d,$d));
    } else {
        $toparRoimhe = htmlspecialchars($toparRoimhe);
        $fisRoimhe   = htmlspecialchars($fisRoimhe);
    }
    $toparCumHtmlArr = [];
    $toparStoplist = "'ING', 'KSga', 'KSgv_cont', 'KSgv_der', 'KSgv_inf', 'SCC'";
    $stmtTC = $DbBun->prepare("SELECT COUNT(1) AS cnt, topar AS toparCum FROM bund WHERE topar NOT IN ($toparStoplist)"
                             ." GROUP BY topar ORDER BY cnt DESC,topar LIMIT 32");
    $stmtTC->execute();
    $rows = $stmtTC->fetchAll(PDO::FETCH_ASSOC);
    $cntArd   = $rows[7]['cnt'];
    $cntIseal = $rows[15]['cnt'];
    foreach ($rows as $row) {
        extract($row);
        if      ($cnt>$cntArd)   { $cntClass = 'ard'; }
         elseif ($cnt>$cntIseal) { $cntClass = 'meadhan'; }
         else                    { $cntClass = 'iseal'; }
        $toparCumHtmlArr[$toparCum] = "<span class=$cntClass title=$cnt onclick='toparCumClick(this.innerHTML);'>$toparCum</span>";
    }
    ksort($toparCumHtmlArr);
    $toparCumHtml = implode(' ',$toparCumHtmlArr);

    if (!empty($_REQUEST['sabhail'])) {
        $toparUr = ( empty($_REQUEST['topar']) ? '' : $_REQUEST['topar'] );
        $fisUr   = ( empty($_REQUEST['fis'])   ? '' : $_REQUEST['fis']   );
        if (empty($toparUr)) { throw new SM_Exception("sgrios|bog|$T_Feumaidh_tu_topar"); }
        if ($d==0) {
            $stmtATHARRAICH = $DbBun->prepare('INSERT IGNORE INTO bund (topar,fis) VALUES (:topar,:fis)');
            $stmtATHARRAICH->execute( array(':topar'=>$toparUr, ':fis'=>$fisUr) );
        } else {
            $stmtATHARRAICH = $DbBun->prepare('UPDATE IGNORE bund SET topar:=:topar, fis=:fis WHERE d=:d');
            $stmtATHARRAICH->execute( array(':d'=>$d, ':topar'=>$toparUr, ':fis'=>$fisUr ) );
        }
        if ($stmtATHARRAICH->rowCount()==1) {
            if ($d==0) { $dUr = $DbBun->lastInsertId(); }
             else      { $dUr = $d; }
        } else {
            $fiosMearachd = $T_Drong_ann_mu_thrath;
        }
        if ($f<>0) {
            $stmtINSERTf = $DbBun->prepare('INSERT IGNORE INTO bundf(d,f,ciana,meit) VALUES (:d,:f,1,0)');
            $stmtINSERTf->execute( array(':d'=>$dUr,':f'=>$f) );
            if ($stmtINSERTf->rowCount()==0) { throw new SM_Exception(sprintf($T_failig_INSERT,$f,$dUr)); }
        }
    }

    $refreshHtml = ( $dUr>0 ? "\n    <meta http-equiv=refresh content='1;url=$bunadasURL/d.php?d=$dUr'>" : '');

    if ($dUr==$d) {
        $HTML .= "<p><img src='/icons-smo/tick.gif' alt=''> $T_Atharrachadh_soirbh</p>\n";
    } elseif ($dUr>0) {
        $HTML .= "<p><img src='/icons-smo/tick.gif' alt=''> $T_Drong_ur_ann</p>\n";
    } else {
        $h1 = ( $d==0 ? $T_Cruthaich_drong_ur : "$T_Atharraich_drong $d" );
        $HTML .= <<<EODHtmlCeann
<a href="./"><img src="dealbhan/bunadas64.png" style="float:left;border:1px solid black;margin:0 2em 2em 0" alt=""></a>
<h1 class=smo>$h1</h1>
EODHtmlCeann;

        if (!empty($fiosMearachd)) {
            $HTML .= "<p style=\"color:red;font-weight:bold\">$fiosMearachd</p>\n";
        } else {
            $HTML .= <<<EODHtmlFoirm
<form method=get action="" style="clear:both">
<input type="hidden" name="d" value="$d">
<input type="hidden" name="f" value="$f">
<table id=form>
<tr><td>$T_topar</td><td><input name="topar" id="topar" style="width:6em" value="$toparRoimhe" autofocus> <span id=toparCum>e.g.: $toparCumHtml</td></tr>
<tr><td>$T_fis</td><td><input name="fis" style="width:40em" value="$fisRoimhe"></td></tr>
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
    <link rel="StyleSheet" href="/css/smo.css">$stordataCss
    <style>
        table#form tr td:first-child { text-align:right; }
        span#toparCum { font-size:70%; color:green }
        span#toparCum span.ard     { font-size:115%; color:green; font-weight:bold; }
        span#toparCum span.meadhan { font-size:100%; color:#080; }
        span#toparCum span.iseal   { font-size:80%;  color:#0a0; }
        span#
    </style>
    <script>
        function toparCumClick(topar) {
            var toparEl = document.getElementById('topar');
            toparEl.value = topar;
            toparEl.style.backgroundColor = 'yellow';
        }
    </script>
</head>
<body>

$navbar
<div class="smo-body-indent" style="margin-bottom:2em">

$HTML

</div>
$navbar

</body>
</html>
EODduilleag;

echo $duilleagHTML;

?>

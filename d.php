<?php
  if (!include('autoload.inc.php'))
    header("Location:https://claran.smo.uhi.ac.uk/mearachd/include_a_dhith/?faidhle=autoload.inc.php");
  header('Cache-Control:max-age=0');

  try {
      $moSMO = SM_moSMO::singleton();
  } catch (Exception $e) {
      $moSMO->toradh = $e->getMessage();
  }

  try {
    $T = new SM_T('bunadas/d');
    $hl = $T::hl0();
    $T_Parameter_p_a_dhith  = $T->_('Parameter_p_a_dhith');
    $T_Parameter_mi_iom     = $T->_('Parameter_mi_iom');
    $T_Dublaich_darireabh   = $T->_('Dublaich_darireabh');
    $T_Dublaich             = $T->_('Dublaich'); 
    $T_Air_neo              = $T->_('Air neo');
    $T_Sguir                = $T->_('Sguir');
    $T_Drong                = $T->_('Drong');
    $T_topar                = $T->_('topar');
    $T_Deasaich_an_drong    = $T->_('Deasaich an drong');
    $T_Cru_facal_don_drong  = $T->_('Cruthaich facal ùr dhan drong seo');
    $T_Dublaich_an_drong    = $T->_('Dùblaich an drong');
    $T_Cuir_as_don_drong    = $T->_('Cuir às don drong');
    $T_Sguab_as_an_drong    = $T->_('Sguab am facal seo às an drong');
    $T_Lorg_le_Multidict    = $T->_('Lorg le Multidict');
    $T_Sguab_as_an_drong    = $T->_('Sguab am facal seo às an drong');
    $T_Atharr_nasg_le_drong = $T->_('Atharr_nasg_le_drong');
    $T_Lorg                 = $T->_('Lorg');
    $T_Canan                = $T->_('Language');
    $T_Facal                = $T->_('Facal');
    $T_Lorg_facal_don_drong = $T->_('Lorg_facal_don_drong');
    $T_Facal_ph             = $T->_('Facal_ph');
    $T_Gluas_ph             = $T->_('Gluas_ph');
    $T_coltachd             = $T->_('coltachd');
    $T_Tagh_facal_ri_cur    = $T->_('Tagh_facal_ri_cur');
    $T_Cuir_ris_an_drong    = $T->_('Cuir ris an drong');
    $T_cus_fhaclan_a_lorg   = $T->_('cus_fhaclan_a_lorg');
    $T_Chan_eil_drong_d     = $T->_('Chan_eil_drong_d');
    $T_Sguab_as             = $T->_('Sguab às');
    $T_Sguab_drong_da_rir   = $T->_('Sguab_drong_da_rir');
    $T_Error_in             = $T->_('Error_in','eq');

    $stordataConnector = SM_Bunadas::stordataConnector();
    $DbBun = $stordataConnector::singleton('rw');
    $bunadasurl = SM_Bunadas::bunadasurl();
    $deasaich = SM_Bunadas::ceadSgriobhaidh();
    $T = new SM_T('bunadas/d');

    $navbar = SM_Bunadas::navbar($T->domhan);

    if (!isset($_REQUEST['d'])) { throw new SM_Exception(sprintf($T_Parameter_p_a_dhith,'d')); }
    $d = htmlspecialchars($_REQUEST['d']);
    if (!is_numeric($d) || intval($d)<>$d || $d<1) { throw new SM_Exception("$T_Parameter_mi_iom: d=$d"); }

    $ainmTeanga = SM_Bunadas::ainmTeanga();
    $teangaithe = array_keys($ainmTeanga);
    $meitArr = SM_Bunadas::meitHtmlArr();

    function uairHtml ($utime) {
        $uairObject = new DateTime("@$utime");
        $latha     = date_format($uairObject, 'Y-m-d');
        $lathaUair = date_format($uairObject, 'Y-m-d H:i:s');
        return "<span title=\"$lathaUair UT\">$latha</span>";
    }

    $dublaichHTML = $sguabHTML = $cuirRiHTML = $dDeasaichHTML = $fDeasaichHTML = $fSguabCeistHTML = $javascriptDeasachaidh = '';

    if ($deasaich) {
        if (isset($_GET['dublaich'])) {
            $dublaichHTML = <<< END_dublaich
<div class=sguab>
$T_Dublaich_darireabh&nbsp;&nbsp; <a href="dDublaich.php?d=$d" class=sguab>$T_Dublaich</a>
<br><br>
$T_Air_neo <a href=d.php?d=$d>$T_Sguir</a>
</div>
END_dublaich;
        } elseif (isset($_GET['sguab'])) {
            $sguabHTML = <<< END_sguab
<div class=sguab>
$T_Sguab_drong_da_rir&nbsp;&nbsp; <a href="dSguab.php?d=$d&amp;till=./" class=sguab>$T_Sguab_as</a>
<br><br>
$T_Air_neo <a href=d.php?d=$d>$T_Sguir</a>
</div>
END_sguab;
        } elseif (isset($_GET['cuirRi'])) {
            $cuirRi = htmlspecialchars($_REQUEST['cuirRi']);
            $meit  = $_REQUEST['meit']  ?? 0;  $meit  = htmlspecialchars($meit);
            $ciana = $_REQUEST['ciana'] ?? 1;  $ciana = htmlspecialchars($ciana); 
            $doich = $_REQUEST['doich'] ?? 1;  $doich = htmlspecialchars($doich); 
            if (!is_numeric($cuirRi) || intval($cuirRi)<>$cuirRi || $cuirRi<1) { throw new SM_Exception("Parameter neo-iomchaidh: cuirRi=$cuirRi"); }
            if (!in_array($meit,array_keys($meitArr)))                         { throw new SM_Exception("Parameter neo-iomchaidh: meit=$meit");     }
            if (!is_numeric($ciana) || $ciana<0)                               { throw new SM_Exception("Parameter neo-iomchaidh: ciana=$ciana");   }
            if (!is_numeric($doich) || $doich<=0 || $doich>1 )                 { throw new SM_Exception("Parameter neo-iomchaidh: doich=$doich");   }
            $stmtINS = $DbBun->prepare("REPLACE INTO bundf (d,f,ciana,meit,doich) VALUES (:d,:f,:ciana,:meit,:doich)");
            $stmtINS->execute(array(':d'=>$d,':f'=>$cuirRi,':ciana'=>$ciana,':meit'=>$meit,':doich'=>$doich));
        }

        //Cruthaich foirm airson focal a lorg
        $ainmTeanga = SM_Bunadas::ainmTeanga();
        $teangaithe = array_keys($ainmTeanga);
        $selectTHtml  = "<select name='t'>\n";
        $selectTHtml .= "<option value='' selected></option>\n";
        foreach ($teangaithe as $t) { $selectTHtml .= "<option value='$t' lang='$t'>" .  $ainmTeanga[$t] . "</option>\n"; }
        $selectTHtml .= "</select>\n";  
        $cuirRiHTML = <<<END_cuirRiHTML
<fieldset class="cuirRis" style="margin:0.5em 0 0.5em 0">
<legend>$T_Lorg_facal_don_drong</legend>
<form method="get" style="clear:both">
<table>
<tr style="font-size:80%"><td>$T_Canan</td><td title="Word">$T_Facal</td><td></td></tr>
<tr>
<td>$selectTHtml</td>
<td><input name="focal" placeholder="$T_Facal_ph") a tha ri lorg" autofocus style="width:25em"></td>
<td><input name="gluas" placeholder="$T_Gluas_ph" style="width:12em"></td>
<td><input type="submit" name="lorg" value="$T_Lorg"></td>
</table>
</tr>
<input type="hidden" name=d value=$d>
</form>
</fieldset>
END_cuirRiHTML;

        if (!empty($_GET['f']) || !empty($_GET['focal']) || !empty($_GET['gluas'])) {
            $fq     = ( empty($_GET['f'])     ? '%' : $_GET['f']     );
            $tq     = ( empty($_GET['t'])     ? '%' : $_GET['t']     ); 
            $focalq = ( empty($_GET['focal']) ? '%' : trim($_GET['focal']) );
            $gluasq = ( empty($_GET['gluas']) ? '%' : '%' . $_GET['gluas'] . '%' );
            $focalq = strtr($focalq,array('*'=>'%','?'=>'_'));
            $gluasq = strtr($gluasq,array('*'=>'%','?'=>'_'));
            $stmtSEL = $DbBun->prepare('SELECT bunf.f,ciana,meit,doich'
                                          . ' FROM bunt, bunf LEFT JOIN bundf ON d=:d AND bundf.f=bunf.f'
                                          . ' WHERE bunt.t=bunf.t AND bunf.f LIKE :f AND bunf.t LIKE :t AND focal LIKE :focal AND gluas LIKE :gluas'
                                          . ' ORDER BY parentage_ord,focal,derb');
            $stmtSEL->execute(array(':d'=>$d,':f'=>$fq,':t'=>$tq,':focal'=>$focalq,':gluas'=>$gluasq));
            $torArr = $stmtSEL->fetchAll(PDO::FETCH_OBJ);
            $count = count($torArr);
            if ($count==0) {
                $cuirRiHTML .= "<p class='mearachd'>Chan eil a leithid d’fhacail r’a lorg ann am Bunadas.  Feuch a-rithist...</p>\n";
            } elseif ($count>200) {
                $cuirRiHTML .= "<p class='mearachd'>$T_cus_fhaclan_a_lorg</p>\n";
            } else {
                $cuirRiHTML .= "<fieldset class=cuirRis style='margin-left:2em'>\n";
                if ($count>1) { $cuirRiHTML .= "<legend style='background-color:black'>$T_Tagh_facal_ri_cur</legend>\n"; }
                $cuirRiHTML .= "<table id=cuirRiTable>\n";
                foreach ($torArr as $tor) {
                    $f     = $tor->f;
                    $annAs = ( isset($tor->ciana) ? 'tick' : 'null' ); $annAs = "<img src='/favicons/$annAs.png' alt=''>";
                    $ciana = ( isset($tor->ciana) ? $tor->ciana : 1 );
                    $meit  = ( isset($tor->meit)  ? $tor->meit  : 0 );
                    $doich = ( isset($tor->doich) ? $tor->doich : 1 );
                    $cianaMax = max($ciana+2,10);
                    $optionsHTML = '';
                    foreach ($meitArr as $val=>$symb) { $optionsHTML .= "<option value=$val" . ($val==$meit ? ' selected' : '') . ">$symb</option>"; }
                    $fHTML = SM_Bunadas::fHTML($f);
                    $cuirRiHTML .= <<<END_cuirRiHTMLrow
<form><tr><td>$annAs</td><td>$fHTML<input type='hidden' name='cuirRi' value='$f'><input type='hidden' name='d' value='$d'></td>
<td><select name='meit'>$optionsHTML</select></td>
<td id='ciana$f' class='ciana'>$ciana</td>
<td><input name='ciana' type='range' min=0 max=$cianaMax step=0.1 value=$ciana style='width:38em;color:#aaa' list=ticks oninput="setCiana('ciana$f',value);" onchange="setCiana('ciana$f',value);"></td>
<td><input type='submit' value='$T_Cuir_ris_an_drong'></td>
<td><input name='doich' type='range' min=0 max=1 step=0.1 value=$doich style='width:5em;color:#bbb' list=ticks oninput="setDoich('doich$f',value);" onchange="setDoich('doich$f',value);"></td>
<td id='doich$f' class='doich'>$doich</td></tr></form>
END_cuirRiHTMLrow;
                }
                $cuirRiHTML .= "</table>\n</fieldset>\n";
            }
        }

        $javascriptDeasachaidh = <<<END_javascriptDeasachaidh
    <script>
        function setCiana(id,ciana) {
            document.getElementById(id).innerHTML=parseFloat(ciana);
        }
        function setDoich(id,doich) {
            document.getElementById(id).innerHTML=parseFloat(doich);
        }
        function sguabFbhoD(f,d) {
            var url = '$bunadasurl/ajax/sguabFbhoD.php?f=' + f + '&d=' + d;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open('GET', url, false);
            xmlhttp.send();
            var resp = xmlhttp.responseText;
            if (resp!='OK') { alert('$T_Error_in sguabFbhoD: ' + resp); }
            window.location.href = '$bunadasurl/d.php?d=' + d;
        }
        function atharrMeit(d,f,m) {
            var url = '$bunadasurl/ajax/atharrMeit.php?d=' + d + '&f=' + f + '&m=' + m;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open('GET', url, false);
            xmlhttp.send();
            var resp = xmlhttp.responseText;
            if (resp!='OK') { alert('$T_Error_in atharrMeit: ' + resp); }
            url = window.location.protocol + '//'
                + window.location.hostname
                + window.location.pathname + '?d=' + d;
            window.location.assign(url);
        }
        function atharrCiana(d,f,c) {
            if (c<0) { c = 0; }
            var url = '$bunadasurl/ajax/atharrCiana.php?d=' + d + '&f=' + f + '&c=' + c;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open('GET', url, false);
            xmlhttp.send();
            var resp = xmlhttp.responseText;
            if (resp!='OK') { alert('$T_Error_in atharrCiana: ' + resp); }
            url = window.location.protocol + '//'
                + window.location.hostname
                + window.location.pathname + '?d=' + d;
            window.location.assign(url);
        }
    </script>
END_javascriptDeasachaidh;

    }

    $stmtd1 = $DbBun->prepare('SELECT topar FROM bund WHERE d=:d');
    $stmtd1->execute(array(':d'=>$d));
    if (!$row = $stmtd1->fetch(PDO::FETCH_ASSOC)) { throw new SM_Exception(sprintf($T_Chan_eil_drong_d,$d)); }
    extract($row);

    $queryd2 = 'SELECT bunf.f AS f2, bunf.t AS t2, bunf.focal AS focal2, bunf.derb AS derb2, meit, ciana, doich FROM bundf,bunf,bunt'
             . ' WHERE bundf.d=:d'
             . '   AND bundf.f=bunf.f'
             . '   AND bunt.t = bunf.t'
             . ' ORDER BY ciana,meit,parentage_ord,focal2,derb2';
    $stmtd2 = $DbBun->prepare($queryd2);

    if ($deasaich) { $dDeasaichHTML =  "<a href=dDeasaich.php?d=$d><img src=/icons-smo/peann.png title='$T_Deasaich_an_drong'></a>"
                                    .  " <a href=fDeasaich.php?f=0&amp;d=$d><img src=/icons-smo/plusStar.png title='$T_Cru_facal_don_drong'></a>"
                                    . " <a href=d.php?d=$d&amp;dublaich><img src=/icons-smo/dubladh.png title='$T_Dublaich_an_drong'></a>"
                                    . " <a href=d.php?d=$d&amp;sguab><img src=/icons-smo/curAs2.png title='$T_Cuir_as_don_drong'></a>"; }
    $drongHTML = "<div class=drong><div class=dCeann><b>$T_Drong $d</b> $dDeasaichHTML &nbsp; <span title='$T_topar'>$topar</span></div>\n";
    $stmtd2->execute(array(':d'=>$d));
    $drongHTML .= '<table>';
    while ($row2 = $stmtd2->fetch(PDO::FETCH_ASSOC)) {
        extract($row2);
        $doichHtml = $doichStyle = '';
        if ($doich<0.98) {
            $doichHtml = ( $doich>=0.8 ? '?' : '??' );
            if      ($doich<0.6) { $doichStyle = 'style="color:red;font-weight:bold"'; }
             elseif ($doich<0.7) { $doichStyle = 'style="color:red"'; }
            $doichHtml = " <span $doichStyle title='$T_coltachd $doich'>$doichHtml</span>";
        }
        $meitHtml = SM_Bunadas::meitHtml($meit);
        if ($deasaich) {
                $cianaDeasaichHTML = "<span onclick='atharrCiana($d,$f2,$ciana-1)' style='font-weight:bold;font-size:120%'>-</span> "
                                   . "<span onclick='atharrCiana($d,$f2,$ciana-0.1)'>-</span> "
                                   . "<span onclick='atharrCiana($d,$f2,$ciana+0.1)'>+</span> "
                                   . "<span onclick='atharrCiana($d,$f2,$ciana+1)' style='font-weight:bold;font-size:120%'>+</span> ";
                $meitDeasaichHTML = "<span onclick='atharrMeit($d,$f2,-3)'>≪</span> "
                                  . "<span onclick='atharrMeit($d,$f2,-2)'>≺</span> "
                                  . "<span onclick='atharrMeit($d,$f2,-1)'>≼</span> "
                                  . "<span onclick='atharrMeit($d,$f2,0)'>–</span> "
                                  . "<span onclick='atharrMeit($d,$f2,1)'>≽</span> "
                                  . "<span onclick='atharrMeit($d,$f2,2)'>≻</span> "
                                  . "<span onclick='atharrMeit($d,$f2,3)'>≫</span≻";
               $fDeasaichHTML = "<a href='d.php?d=$d&amp;f=$f2'><img src='/icons-smo/peann.png' title='$T_Atharr_nasg_le_drong' alt='Deasaich'></a>"
                                             .   " <img src='/icons-smo/curAs.png' onclick=\"sguabFbhoD($f2,$d)\" title='$T_Sguab_as_an_drong' alt='Sguab'>";
               $fDeasaichHTML = "<td>$fDeasaichHTML<span class=cianDeasaich>$cianaDeasaichHTML</span><span class=meitDeasaich>$meitDeasaichHTML</span></td>";
        }
        $cianaHTML = ( $ciana>0 ? $ciana : "<b style='color:black'>$ciana</b>" );
        $drongHTML .=  "<tr><td><a href=\"//multidict.net/multidict/?sl=$t2&amp;word=" . urlencode($focal2) . "\"><img src='dealbhan/multidict.png' style='margin-right:10px' alt='[M]' title='$T_Lorg_le_Multidict'></a></td><td>"
                     . SM_Bunadas::fHTML($f2) . "</td><td>$meitHtml</td><td class='ciana'>$cianaHTML$doichHtml</td>$fDeasaichHTML</tr>\n";
    }
    $drongHTML .= "</table>\n</div>\n";
    $HTML = <<<END_HTML
$dublaichHTML$sguabHTML$fSguabCeistHTML

<a href="./"><img src="dealbhan/bunadas64.png" style="float:left;border:1px solid black;margin:0 1em 1em 0" alt=""></a>
$cuirRiHTML
$drongHTML
END_HTML;

  } catch (Exception $e) {
      if (strpos($e,'Sgrios')!==FALSE) { $HTML = ''; }
      $HTML .= $e;
  }

  $stordataCss = SM_Bunadas::stordataCss();
  echo <<<END_duilleag
<!DOCTYPE html>
<html lang="$hl">
<head>
    <meta charset="UTF-8">
    <meta name="google" content="notranslate">
    <meta name="robots" content="noindex,nofollow">
    <title>Bunadas: Fiosrachadh mu Drong $d</title>
    <link rel="StyleSheet" href="/css/smo.css">$stordataCss
    <link rel="StyleSheet" href="snas.css">
    <style>
        div.drong { background-color:#ffd; clear:both; margin:0.8em 0; border:1px solid; border-radius:0.4em; padding:0.2em; }
        div.drong table { border-collapse:collapse; }
        div.drong table tr:hover { background-color:#fdd; }
        div.drong table td { padding:2px; }
        div.drong tr td:nth-child(3) { min-width:1.1em; }
        div.drong tr td:nth-child(4) { min-width:1.6em; }
        div.drong tr td:nth-child(5) { padding-left:1.5em; }
        div.sguab         { margin:0.4em 0; border:6px solid red; border-radius:7px; background-color:#fee; padding:0.7em; }
        div.sguab a       { font-size:112%; background-color:#55a8eb; color:white; font-weight:bold; padding:3px 10px; border:0; border-radius:8px; text-decoration:none; }
        div.sguab a:hover { background-color:blue; }
        div.sguab a.sguab       { background-color:#f84; }
        div.sguab a.sguab:hover { background-color:red; font-weight:bold; }
        p.mearachd { color:red; font-size:85%; }
        td.ciana { color:grey; font-size:80%; width:1.8em; white-space:nowrap }
        td.doich { color:#aaa; font-size:70%; }
        div.dCeann { margin-bottom:0.5em; font-size:90%; color:#bbb; }
        div.dCeann b { color:black; }
        fieldset.cuirRis        { margin-top:0.3em; padding:0.2em 0.3em; background-color:#fee; border:1px solid #a99; border-radius:3px; }
        fieldset.cuirRis legend { background-color:grey; color:white; padding:1px 4px; border:1px solid grey; border-radius:4px; font-weight:bold; font-size:70%; }
        table#cuirRiTable { border-collapse:collapse; }
        table#cuirRiTable tr:hover { background-color:#dd9; }
        span.cianDeasaich { padding-left:1.5em; color:#ac9; }
        span.meitDeasaich { padding-left:1.5em; color:#99f; }
        span.cianDeasaich > span:hover,
        span.meitDeasaich > span:hover { background-color:blue; color:yellow; cursor:default; }
    </style>
$javascriptDeasachaidh
</head>
<body>
<datalist id=ticks>
<option>1</option>
<option>2</option>
<option>3</option>
<option>4</option>
<option>5</option>
<option>6</option>
<option>7</option>
<option>8</option>
<option>9</option>
<option>10</option>
</datalist>
$navbar
<div class="smo-body-indent">

$HTML

</div>
$navbar
</body>
</html>
END_duilleag;

?>

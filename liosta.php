<?php
  if (!include('autoload.inc.php'))
    header("Location:https://claran.smo.uhi.ac.uk/mearachd/include_a_dhith/?faidhle=autoload.inc.php");
  header('Cache-Control:max-age=0');

  try {
    $T = new SM_T('bunadas/liosta');
    $hl = $T::hl0();
    $T_Liosta                 = $T->h('Liosta');
    $T_Sioltachan             = $T->h('Sìoltachan');
    $T_Sioltachan_ph          = $T->h('Sioltachan_ph');
    $T_Nochd_gach_facal       = $T->h('Nochd_gach_facal');
    $T_Nochd_gach_facal_title = $T->h('Nochd_gach_facal_title');
    $T_Nochd_fo_mhirean       = $T->h('Nochd_fo_mhirean');
    $T_Nochd_fo_mhirean_fios  = $T->h('Nochd_fo_mhirean_fios');
    $T_Nochd_fo_mhirean_title = $T->h('Nochd_fo_mhirean_title');
    $T_Nochd_os_mhirean       = $T->h('Nochd_os_mhirean');
    $T_Nochd_os_mhirean_fios  = $T->h('Nochd_os_mhirean_fios');
    $T_Nochd_os_mhirean_title = $T->h('Nochd_os_mhirean_title');
    $T_Modh                   = $T->h('Modh');
    $T_Ionannas_teann         = $T->h('Ionannas_teann');
    $T_Ionannas_garbh         = $T->h('Ionannas_garbh');
    $T_Ionannas_garbh_fios    = $T->h('Ionannas_garbh_fios');
    $T_Lean_mion_mhirean      = $T->h('Lean_mion_mhirean');
    $T_Lean_mion_mhirean_fios = $T->h('Lean_mion_mhirean_fios');
    $T_Uas_chiana             = $T->h('Uas_chiana');
    $T_Uas_chiana_fios        = $T->h('Uas_chiana_fios');
    $T_Uraich                 = $T->h('Uraich');
    $T_Uas_aireamh            = $T->h('Uas_aireamh');
    $T_Fios_aireamh_canan1    = $T->h('Fios_aireamh_canan1');
    $T_Fios_aireamh_canan2    = $T->h('Fios_aireamh_canan2');
    $T_facal                  = $T->h('facal');
    $T_facail                 = $T->h('facail');
    $T_Briog_gus_suaip        = $T->h('Briog_gus_suaip');
    $T_No_words_found         = $T->h('No_words_found');
    $T_Seall_na_h_uile        = $T->h('Seall_na_h_uile');
    $T_Seall_na_h_uile_title  = $T->h('Seall_na_h_uile_title');
    $T_Astar_fios             = $T->h('Astar_fios');
    $T_Sealltainn_aireamh_t1  = $T->h('Sealltainn_aireamh_t1');
    $T_Sealltainn_aireamh_t2  = $T->h('Sealltainn_aireamh_t2');

    $T_Nochd_os_mhirean_fios  = strtr ($T_Nochd_os_mhirean_fios,  [ '(' => '&nbsp; (' ] );
    $T_Ionannas_garbh_fios    = strtr ($T_Ionannas_garbh_fios,    [ ':' => ': &nbsp;' ] );
    $T_Lean_mion_mhirean_fios = strtr ($T_Lean_mion_mhirean_fios, [ ':' => ': &nbsp;' ] );

    $T_Fios_aireamh_canan1    = strtr ( $T_Fios_aireamh_canan1, [ '{' => '<b>', '}' => '</b>' ] );
    $T_Fios_aireamh_canan2    = strtr ( $T_Fios_aireamh_canan2, [ '{' => '<b>', '}' => '</b>' ] );
    $T_Sealltainn_aireamh_t1  = strtr ( $T_Sealltainn_aireamh_t1, [ '{%d}' => '<b>%d</b>' ] );
    $T_Sealltainn_aireamh_t2  = strtr ( $T_Sealltainn_aireamh_t2, [ '{%d}' => '<b>%d</b>' ] );

    $navbar = SM_Bunadas::navbar($T->domhan);

    $ainmTeanga = SM_Bunadas::ainmTeanga();
    $teangaithe = $teangaithe2 = array_keys($ainmTeanga);
    $teangaithe2[] = '*'; //saorag ceadaichte airson t2
    $ainmTeanga['*'] = '*';
    $t1 = 'ga';
    $t2 = 'gd';
    if (isset($_GET['t1'])) { $t1 = $_GET['t1']; }
    if (isset($_GET['t2'])) { $t2 = $_GET['t2']; }
    if (!in_array($t1,$teangaithe )) { throw new SM_Exception("Parameter ceàrr: chan eil t1='$t1' ceadaichte"); }
    if (!in_array($t2,$teangaithe2)) { throw new SM_Exception("Parameter ceàrr: chan eil t2='$t2' ceadaichte"); }
    $patran1 = ( !empty($_GET['patran1']) ? trim($_GET['patran1']) : '%');
    $patran1 = strtr($patran1,array('*'=>'%','?'=>'_'));
    $patran1 = strtr($patran1,array('%_'=>'%','_%'=>'%','%%'=>'%'));
    $patran1 = strtr($patran1,array('%_'=>'%','_%'=>'%','%%'=>'%'));
    $patran1HTML = htmlspecialchars(strtr($patran1,array('%'=>'*')));
    if ($patran1HTML=='*') { $patran1HTML = ''; }
    $teanga1 = $ainmTeanga[$t1];
    $teanga2 = $ainmTeanga[$t2];
    $uasCiana  = ( isset($_GET['uasCiana'])  ? $_GET['uasCiana'] : 8 ); if (!is_numeric($uasCiana)) { $uasCiana = 8; }
    $nochdUile = ( empty($_GET['nochdUile']) ? FALSE : TRUE );
    $nochdUileChecked = ( $nochdUile ? ' checked' : '');
    $nochdFoMhir = ( empty($_GET['nochdFoMhir']) ? FALSE : TRUE );
    $nochdFoMhirChecked = ( $nochdFoMhir ? ' checked' : '');
    $nochdOsMhir = ( empty($_GET['nochdOsMhir']) ? FALSE : TRUE );
    $nochdOsMhirChecked = ( $nochdOsMhir ? ' checked' : '');
    $modh = ( isset($_GET['modh']) ? $_GET['modh'] : 1 );
    $modh0Checked = $modh1Checked = $modh2Checked = '';
    if ($modh==0) { $modh0Checked = 'checked'; }
    if ($modh==1) { $modh1Checked = 'checked'; }
    if ($modh==2) { $modh2Checked = 'checked'; }
    $uasAireamh = ( isset($_GET['uasAireamh']) ? intval($_GET['uasAireamh']) : 0 );
    $uasAireamh2 = ( isset($_GET['gunAireamh']) ? 0 : $uasAireamh );

    $selectT1Html = "<select name='t1' id='t1Select' onchange='priomhSubmit()'>\n";
    $selectT2Html = "<select name='t2' id='t2Select' onchange='priomhSubmit()'>\n";
    foreach ($teangaithe  as $t) { $selectT1Html .= "<option value='$t'" . ($t==$t1?' selected':'') . " lang='$t'>" . $ainmTeanga[$t] . " ($t)</option>\n"; }
    foreach ($teangaithe2 as $t) { $selectT2Html .= "<option value='$t'" . ($t==$t2?' selected':'') . " lang='$t'>" . $ainmTeanga[$t] . " ($t)</option>\n"; }
    $selectT1Html .= "</select>\n";
    $selectT2Html .= "</select>\n";

    $stordataConnector = SM_Bunadas::stordataConnector();
    $DbBun = $stordataConnector::singleton('rw');

    $resultHtml = $aireamhHtml = '';
    if (empty($patran1)) { $patran1 = '*'; }
    $fquery = ( ctype_digit($patran1)
              ? 'f=:patran1'
              : 'focal LIKE :patran1'
              );
    $fquery .= " AND t=:t1";

    $stmtSELbunf = $DbBun->prepare("SELECT f FROM bunf WHERE $fquery");
    $stmtSELbunf->execute(array(':patran1'=>$patran1,':t1'=>$t1));
    $fArr = $stmtSELbunf->fetchAll(PDO::FETCH_COLUMN, 0);
    $aireamht1 = $aireamht2 = 0;
    foreach ($fArr as $f) {
        $nabArr = SM_Bunadas::nabaidhean($f,$uasCiana,$t2,$nochdFoMhir,$nochdOsMhir,$modh);
        $nabHtmlArr = [];
        foreach ($nabArr as $nab=>$nabInfo) {
            $ciana   = $nabInfo[0];
            $slige   = $nabInfo[1];
            $meitCar = $nabInfo[2];
            $put = SM_Bunadas::fHTML($nab);
            $fontsize = round(400.0/(3.7+$ciana));
            $put = "<div class='charput' style='font-size:$fontsize%' title='ciana: $ciana - $slige'>$meitCar$put</div>";
            $nabHtmlArr[] = $put;
        }
        if ($nochdUile || !empty($nabHtmlArr)) {
            $nabHTML = implode(' ',$nabHtmlArr);
            $resultHtml .= '<div class=loidhne>' . SM_Bunadas::fHTML($f) . " — $nabHTML</div>\n";
            $aireamht1 = $aireamht1 + 1;
            $aireamht2 = $aireamht2 + count($nabHtmlArr);
        }
        if ($uasAireamh2>0 && $aireamht1==$uasAireamh) { break; }
    }
    $php_self = $_SERVER['PHP_SELF'];
    if (!ctype_digit($patran1)) {
        if ($aireamht1==0) {
            $aireamhHtml = $T_No_words_found;
            $aireamhDath = '#f99';
        } elseif ($aireamht1==$uasAireamh2) {
            $uilePutan = "<input type='submit' name='gunAireamh' value='$T_Seall_na_h_uile' class='gunAireamh' onclick='priomhSubmit()' title='$T_Seall_na_h_uile_title'>";
            $T_Sealltainn_aireamh_t1 = sprintf($T_Sealltainn_aireamh_t1,$aireamht1);
            $T_Sealltainn_aireamh_t2 = sprintf($T_Sealltainn_aireamh_t2,$aireamht2);
            $aireamhHtml = "$T_Sealltainn_aireamh_t1 - <span style='font-size:85%'>($T_Sealltainn_aireamh_t2)</span> $uilePutan";
            $aireamhDath = '#ff0';
        } else {
            $cunntasFacal = $T->cunntasLom($aireamht1,$T_facal,$T_facail);
            $T_Fios_aireamh_canan1 = sprintf($T_Fios_aireamh_canan1,$aireamht1,$cunntasFacal);
            $T_Fios_aireamh_canan2 = sprintf($T_Fios_aireamh_canan2,$aireamht2);
            $aireamhHtml = "$T_Fios_aireamh_canan1 <span style='font-size:85%'>— $T_Fios_aireamh_canan2</span>";
            $aireamhDath = '#9f9';
        }
        $aireamhHtml = "<p class='aireamh' style='background-color:$aireamhDath'>$aireamhHtml</p>";
        $aireamhInputHtml = "<input name='uasAireamh' value='$uasAireamh' style='width:3em;text-align:right'> $T_Uas_aireamh";
    } else {
        $aireamhInputHtml = "<input name='uasAireamh' value='$uasAireamh' type='hidden'>";
    }

    $stordataCss = SM_Bunadas::stordataCss();
    $html = <<<END_HTML
<!DOCTYPE html>
<html lang="$hl">
<head>
    <meta charset="UTF-8">
    <meta name="google" content="notranslate">
    <meta name="robots" content="noindex,nofollow">
    <title>Bunadas: $T_Liosta $teanga1 gu $teanga2</title>
    <link rel="StyleSheet" href="/css/smo.css">
    <link rel="StyleSheet" href="snas.css.php">$stordataCss
    <style>
        div.loidhne { margin:7px 0 6px 3em; text-indent:-3em; }
        div.loidhne div { text-indent:0; }
        div.charput { display:inline; white-space:nowrap; }
        div.f { vertical-align:middle; }
        select, option { font-size:100%; }
        p.aireamh { margin:0.8em 0; padding:0.1em 0.5em; border:1px solid black; border-radius:0.2em; background-color:yellow; font-size:80%; }
        input.gunAireamh { border:1px solid black; border-radius:4px; background-color:#fcc; padding:1px 4px; font-size:105%; }
        input.gunAireamh:hover { background-color:blue; color:yellow; }
    </style>
    <script>
        function priomhSubmitIf() {
            if (document.getElementById('uasCiana').value != uasCianaRoimhe) { priomhSubmit(); }
        }

        function priomhSubmit() {
            document.getElementById('priomhFoirm').style.backgroundColor='#a88';
            document.getElementById('priomhFoirm').submit();
        }

        function suaipCananan() {
            var t1Select = document.getElementById('t1Select');
            var t2Select = document.getElementById('t2Select');
            var selected1 = t1Select.selectedIndex;
            var selected2 = t2Select.selectedIndex;
            if (!t1Select.options[selected2]) { return; } //Sguir ma ’s e saorag a th’ann an t2
            t1Select.selectedIndex = selected2;
            t2Select.selectedIndex = selected1;
            priomhSubmit();
        }
    </script>
</head>
<body style="font-size:125%">

$navbar
<div class="smo-body-indent">

<form id="priomhFoirm">
<a href="./"><img src="dealbhan/bunadas64.png" alt="An Sruth" style="float:left;border:1px solid black;margin:0 1em 1px 0"></a>
<p style="font-weight:bold;font-size:120%;margin-bottom:1px">$T_Liosta:
$selectT1Html
<a href2="$php_self?t1=$t2&amp;t2=$t1" title="$T_Briog_gus_suaip" onclick="suaipCananan();">▶</a>
$selectT2Html</p>

<div style="clear:both;border2:1px solid;padding:1px">
<p style="margin:0 0 20px 80px;font-size:80%">
$T_Sioltachan <input name="patran1" value="$patran1HTML" placeholder="$T_Sioltachan_ph"><br>
 <span title="$T_Nochd_gach_facal_title">
  <label><input type="checkbox" name="nochdUile" $nochdUileChecked onclick="priomhSubmit();"> $T_Nochd_gach_facal</label>
 </span><br>
 <span title="$T_Nochd_fo_mhirean_title">
  <label><input type="checkbox" name="nochdFoMhir" $nochdFoMhirChecked onclick="priomhSubmit();"> $T_Nochd_fo_mhirean</label>
  <span style="color:green;font-size:70%">- $T_Nochd_fo_mhirean_fios</span>
 </span><br>
 <span title="$T_Nochd_os_mhirean_title">
  <label><input type="checkbox" name="nochdOsMhir" $nochdOsMhirChecked onclick="priomhSubmit();"> $T_Nochd_os_mhirean</label>
  <span style="color:green;font-size:70%">- $T_Nochd_os_mhirean_fios</span>
 </span><br>
 $T_Modh:<br>
 &nbsp;<label><input type="radio" name="modh" value="0" $modh0Checked onclick="priomhSubmit();"> $T_Ionannas_teann</label><br>
 &nbsp;<label><input type="radio" name="modh" value="1" $modh1Checked onclick="priomhSubmit();"> $T_Ionannas_garbh</label> <span style="color:green;font-size:70%">- $T_Ionannas_garbh_fios</span><br>
 &nbsp;<label><input type="radio" name="modh" value="2" $modh2Checked onclick="priomhSubmit();"> $T_Lean_mion_mhirean</label> <span style="color:green;font-size:70%">- $T_Lean_mion_mhirean_fios</span><br>
</p>

<p style="margin:7px 0;font-size:80%" title="$T_Astar_fios">
 <label for="uasCiana" style="padding-left:1.7em">$T_Uas_chiana:</label> <output for="uasCiana" id="uasCianaOut" style="font-weight:bold">$uasCiana</output><br>0
 <input id="uasCiana" name="uasCiana" type="range" min="0" max="15" step="0.1" value="$uasCiana" style="width:80em;height:20px;padding:0" list="astTicks" oninput="document.getElementById('uasCianaOut').value=this.value;" onchange="document.getElementById('uasCianaOut').value=this.value;" onmouseout="priomhSubmitIf();">
 <datalist id="astTicks"><option>2</option><option>4</option><option>6</option><option>8</option></datalist>
 15 <input type="submit" name="cuir" value="$T_Uraich" onclick="priomhSubmit();"><br>
<span style="color:green;font-size:80%;padding-left:2.1em">$T_Uas_chiana_fios</span></p>
</div>
<script type="text/javascript"> uasCianaRoimhe = $uasCiana; </script>
<p style="clear:both;margin:0;font-size:70%;color:grey">$aireamhInputHtml</p>


$aireamhHtml
$resultHtml
$aireamhHtml

</form>

</div>
$navbar

</body>
</html>
END_HTML;

    echo $html;

  } catch (exception $e) { echo $e; }
?>

<?php
  if (!include('autoload.inc.php'))
    header("Location:https://claran.smo.uhi.ac.uk/mearachd/include_a_dhith/?faidhle=autoload.inc.php");
  header('Cache-Control:max-age=0');
  global $nabArr,$soillsich;

  try {
    $T = new SM_T('bunadas/liosta');
    $hl = $T::hl0();
    $T_Coimhearsnachd         = $T->_('Coimhearsnachd');
    $T_Nochd_fo_mhirean       = $T->_('Nochd_fo_mhirean');
    $T_Nochd_fo_mhirean_fios  = $T->_('Nochd_fo_mhirean_fios');
    $T_Nochd_fo_mhirean_title = $T->_('Nochd_fo_mhirean_title');
    $T_Nochd_os_mhirean       = $T->_('Nochd_os_mhirean');
    $T_Nochd_os_mhirean_fios  = $T->_('Nochd_os_mhirean_fios');
    $T_Nochd_os_mhirean_title = $T->_('Nochd_os_mhirean_title');
    $T_Modh                   = $T->_('Modh');
    $T_Ionannas_teann         = $T->_('Ionannas_teann');
    $T_Ionannas_garbh         = $T->_('Ionannas_garbh');
    $T_Ionannas_garbh_fios    = $T->_('Ionannas_garbh_fios');
    $T_Lean_mion_mhirean      = $T->_('Lean_mion_mhirean');
    $T_Lean_mion_mhirean_fios = $T->_('Lean_mion_mhirean_fios');
    $T_Uas_chiana             = $T->_('Uas_chiana');
    $T_Uas_chiana_fios        = $T->_('Uas_chiana_fios');
    $T_Uraich                 = $T->_('Uraich');
    $T_facal                  = $T->_('facal');
    $T_facail                 = $T->_('facail');
    $T_Astar_fios             = $T->_('Astar_fios');

    $T_Nochd_os_mhirean_fios  = strtr ($T_Nochd_os_mhirean_fios,  [ '(' => '&nbsp; (' ] );
    $T_Ionannas_garbh_fios    = strtr ($T_Ionannas_garbh_fios,    [ ':' => ': &nbsp;' ] );
    $T_Lean_mion_mhirean_fios = strtr ($T_Lean_mion_mhirean_fios, [ ':' => ': &nbsp;' ] );

    $navbar = SM_Bunadas::navbar($T->domhan);

    if (empty($_GET['f'])) { throw new Exception('Parameter f a dhìth'); }
    $f = $_GET['f'];
    if (!ctype_digit($f)) { throw new Exception("Parameter neo-iomchaidh f=$f"); }
    $soillsich = $_GET['soillsich'] ?? 0;
    $f = (int)($f);
    $uasCiana  = ( isset($_GET['uasCiana'])  ? $_GET['uasCiana'] : 12 ); if (!is_numeric($uasCiana)) { $uasCiana = 12; }
    $nochdFoMhir = ( empty($_GET['nochdFoMhir']) ? FALSE : TRUE );
    $nochdFoMhirChecked = ( $nochdFoMhir ? ' checked' : '');
    $nochdOsMhir = ( empty($_GET['nochdOsMhir']) ? FALSE : TRUE );
    $nochdOsMhirChecked = ( $nochdOsMhir ? ' checked' : '');
    $modh = ( isset($_GET['modh']) ? $_GET['modh'] : 1 );
    $modh0Checked = $modh1Checked = $modh2Checked = '';
    if ($modh==0) { $modh0Checked = 'checked'; }
    if ($modh==1) { $modh1Checked = 'checked'; }
    if ($modh==2) { $modh2Checked = 'checked'; }

    $stordataConnector = SM_Bunadas::stordataConnector();
    $DbBun = $stordataConnector::singleton('rw');

    $nabArr = SM_Bunadas::nabaidhean2($f,$uasCiana,$nochdFoMhir,$nochdOsMhir,$modh);

    function cmp($nab1,$nab2) {
    //Airson nàbaidhean a chur an òrdugh
        global $nabArr;
        $nabInfo1 = $nabArr[$nab1];
        $nabInfo2 = $nabArr[$nab2];
        //Cuir ciana an coimeas
        if ($nabInfo1[0] < $nabInfo2[0]) return -1;
        if ($nabInfo1[0] > $nabInfo2[0]) return  1;
        //Cuir parentage_ord an coimeas
        if ($nabInfo1[7] < $nabInfo2[7]) return -1;
        if ($nabInfo1[7] > $nabInfo2[7]) return  1;
        //Cuir meitchar an coimeas
        if ($nabInfo1[2] < $nabInfo2[2]) return -1;
        if ($nabInfo1[2] > $nabInfo2[2]) return  1;
        return SM_Bunadas::alphCompare($nab1,$nab2);
    }

    function divHtml($f,$doichRoimhe) {
        global $nabArr, $soillsich;
        $html = SM_Bunadas::fHTML($f);
        if ($f==$soillsich) {
            $reul = "<span style='background-color:#f10;color:white;font-weight:bold;font-size:65%;padding:0 0.3em;border-radius:0.3em'>*</span>";
            $html = "$html <span class=preab>$reul <span style='color:red;font-weight:bold'>←</span></span>";
        }
        $ciana       = $nabArr[$f][0];
        $meitchar    = $nabArr[$f][2];
        $doich       = $nabArr[$f][3];
        $cianaceum   = $nabArr[$f][6];
        $doichHtml   = SM_Bunadas::doichHtml($doich/$doichRoimhe);
        if      ($meitchar=='≺') { $backcol = '#ddf'; }
         elseif ($meitchar=='≻') { $backcol = '#fdd'; }
         elseif ($meitchar=='≶') { $backcol = '#fbf'; }
         else                    { $backcol = '#fff'; }
        $cianaroimhe = $ciana - $cianaceum;
        $fontsizeceum = number_format(100 * (9+$cianaroimhe)/(9+$ciana) ); //percent
        $fontsize = round(800.0/(6+$ciana));
        $html = "$doichHtml$meitchar<div class=charput style='margin:1px' id=cp$f>$html</div>";
        $html = "<div style='float:left;font-size:$fontsizeceum%;background-color:$backcol'>$html</div>";
        $clannArr = $clannHtmlArr = [];
        foreach ($nabArr as $nab=>$nabInfo) { if ($nabInfo[5]==$f) { $clannArr[] = $nab; } }
        usort($clannArr,'cmp');
        foreach ($clannArr as $nab) { $clannHtmlArr[$nab] = divHtml($nab,$doich).'<br style="clear:both">'; }
        $clannHtml = implode(' ',$clannHtmlArr);
        if (!empty($clannHtml)) {
            $html .= "<div class=nabDiv style='font-size:$fontsizeceum%;background-color:$backcol' id=nabDiv$f>$clannHtml</div>";
            $html .= "<div class=togDiv id=td$f>*</div>";
        }
        return $html;
    }
    $resultHtml = '<div style="font-size:120%;margin-top:0.5em">' . divHtml($f,1) .'</div>';

    $resultHtml .= "<div style='clear:both;height:2em'></div>\n";  //spacer

/* Sguab seo uaireigin
    $nabHtmlArr = [];
    foreach ($nabArr as $nab=>$nabInfo) {
        $ciana   = $nabInfo[0];
        $slige   = $nabInfo[1];
        $meitCar = $nabInfo[2];
        $parant  = $nabInfo[5];
        $cianaceum     = $nabInfo[6];
        $parantage_ord = $nabInfo[7];
        $put = SM_Bunadas::fHTML($nab);
        $fontsize = round(850.0/(6+$ciana));
        $put = "<div class='charput' style='font-size:$fontsize%' title='ciana: $ciana - $slige - $cianaceum'>$meitCar$put</div>";
        $nabHtmlArr[] = $put;
    }
    $nabHTML = implode(' ',$nabHtmlArr);
    $resultHtml .= "<div class=loidhne>$nabHTML</div>\n";
*/

    $stordataCss = SM_Bunadas::stordataCss();
    $html = <<<END_HTML
<!DOCTYPE html>
<html lang="$hl">
<head>
    <meta charset="UTF-8">
    <meta name="google" content="notranslate">
    <meta name="robots" content="noindex,nofollow">
    <title>Bunadas: $T_Coimhearsnachd $f</title>
    <link rel="StyleSheet" href="/css/smo.css">
    <link rel="StyleSheet" href="snas.css">$stordataCss
    <style>
        div.loidhne { margin:7px 0 6px 1em; text-indent:-1em; background-color:#dcc; border-top:1px solid grey; }
        div.loidhne div { text-indent:0; }
        div.charput { display:inline; white-space:nowrap; }
        div.f { vertical-align:middle; }
        div.nabDiv, div.togDiv { float:left; white-space:nowrap; margin:2px; padding-left:3px; border-left:2px solid black; border-radius:5px; }
        div.togDiv { display:none; }
        span.preab { animation:preabadh 5s; }
        @keyframes preabadh { from { opacity:0; }
                               10% { opacity:1; }
                               20% { opacity:0; }
                               30% { opacity:1; background-color:red; }
                               40% { opacity:0; }
                               50% { opacity:1; }
                               60% { opacity:0; }
                               70% { opacity:1; }
                               80% { opacity:0; }
                               90% { opacity:1; }
                                to { opacity:0; }
                            }
    </style>
    <script>
        function priomhSubmitIf() {
            if (document.getElementById('uasCiana').value != uasCianaRoimhe) { priomhSubmit(); }
        }
        function priomhSubmit() {
            document.getElementById('priomhFoirm').style.backgroundColor='#a88';
            document.getElementById('priomhFoirm').submit();
        }
        function toggleDiv(e) {
            var f = e.currentTarget.id.substring(2);
            if (!e.target.hasAttribute('href')) {
                nabDiv = document.getElementById('nabDiv'+f);
                togDiv = document.getElementById('td'+f);
                if (nabDiv.style.display=='none') {
                    nabDiv.style.display = 'block';
                    togDiv.style.display = 'none';
                } else {
                    nabDiv.style.display = 'none';
                    togDiv.style.display = 'block';
                }
            }
        }
        function onloadFunc() {
            var cpdivs = document.querySelectorAll('div.charput');
            var tddivs = document.querySelectorAll('div.togDiv');
            for (var i = 0; i < cpdivs.length; i++) { cpdivs[i].addEventListener('click',toggleDiv); }
            for (var i = 0; i < tddivs.length; i++) { tddivs[i].addEventListener('click',toggleDiv); }
        }
    </script>
</head>
<body style="font-size:120%;" onload="onloadFunc();">

$navbar
<div class="smo-body-indent">

<form id="priomhFoirm">
<a href="./"><img src="dealbhan/bunadas64.png" alt="An Sruth" style="float:left;border:1px solid black;margin:0 1em 1px 0"></a>
<h1 style="font-size:100%;margin-bottom:1px">$T_Coimhearsnachd $f</h1>

<div style="clear:both;padding:1px">
<p style="margin:0 0 20px 80px;font-size:80%">
 <span title="$T_Nochd_fo_mhirean_title">
  <label><input type="checkbox" name="nochdFoMhir" $nochdFoMhirChecked onclick="priomhSubmit();"> $T_Nochd_fo_mhirean</label>
  <span style="color:green;font-size:70%">- $T_Nochd_fo_mhirean_fios</span>
 </span><br>
 <span title="$T_Nochd_os_mhirean_title">
  <label><input type="checkbox" name="nochdOsMhir" $nochdOsMhirChecked onclick="priomhSubmit();"> $T_Nochd_os_mhirean</label>
  <span style="color:green;font-size:70%">- $T_Nochd_os_mhirean_fios)</span>
 </span><br>
 $T_Modh:<br>
 &nbsp;<label><input type="radio" name="modh" value="0" $modh0Checked onclick="priomhSubmit();"> $T_Ionannas_teann</label><br>
 &nbsp;<label><input type="radio" name="modh" value="1" $modh1Checked onclick="priomhSubmit();"> $T_Ionannas_garbh</label> <span style="color:green;font-size:70%">- $T_Ionannas_garbh_fios</span><br>
 &nbsp;<label><input type="radio" name="modh" value="2" $modh2Checked onclick="priomhSubmit();"> $T_Lean_mion_mhirean</label> <span style="color:green;font-size:70%">- $T_Lean_mion_mhirean_fios</span><br>
</p>

<p style="margin:7px 0;font-size:80%" title="$T_Astar_fios">
 <label for="uasCiana" style="padding-left:1.7em">$T_Uas_chiana:</label> <output for="uasCiana" id="uasCianaOut" style="font-weight:bold">$uasCiana</output><br>0
 <input id="uasCiana" name="uasCiana" type="range" min="0" max="18" step="0.1" value="$uasCiana" style="width:80em;height:20px;padding:0" list="astTicks" oninput="document.getElementById('uasCianaOut').value=this.value;" onchange="document.getElementById('uasCianaOut').value=this.value;" onmouseout="priomhSubmitIf();">
 <datalist id="astTicks"><option>2</option><option>4</option><option>6</option><option>8</option></datalist>
 18 <input type="submit" name="cuir" value="$T_Uraich" onclick="priomhSubmit();"><br>
<span style="color:green;font-size:80%;padding-left:2.1em">$T_Uas_chiana_fios</span></p>
</div>
<script> uasCianaRoimhe = $uasCiana; </script>

$resultHtml

<input type=hidden name=f value=$f>
</form>

</div>
$navbar

</body>
</html>
END_HTML;

    echo $html;

  } catch (exception $e) { echo $e; }
?>

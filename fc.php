<?php
  if (!include('autoload.inc.php'))
    header("Location:https://claran.smo.uhi.ac.uk/mearachd/include_a_dhith/?faidhle=autoload.inc.php");
  header('Cache-Control:max-age=0');
  global $nabArr, $clethArr, $rindArr;
  $clethArr = $rindArr = [];

  try {
    $T = new SM_T('bunadas/liosta');
    $hl = $T::hl0();
    $T_Coimhearsnachd         = $T->h('Coimhearsnachd');
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
    $T_facal                  = $T->h('facal');
    $T_facail                 = $T->h('facail');
    $T_Astar_fios             = $T->h('Astar_fios');
    $T_Language               = $T->h('Language');
    $T_Word_count             = $T->h('Word_count');

    $T_Nochd_os_mhirean_fios  = strtr ($T_Nochd_os_mhirean_fios,  [ '(' => '&nbsp; (' ] );
    $T_Ionannas_garbh_fios    = strtr ($T_Ionannas_garbh_fios,    [ ':' => ': &nbsp;' ] );
    $T_Lean_mion_mhirean_fios = strtr ($T_Lean_mion_mhirean_fios, [ ':' => ': &nbsp;' ] );

    $navbar = SM_Bunadas::navbar($T->domhan);

    if (empty($_GET['f'])) { throw new Exception('Parameter f a dhìth'); }
    $f = $_GET['f'];
    if (!ctype_digit($f)) { throw new Exception("Parameter neo-iomchaidh f=$f"); }
    if (!empty($_GET['cleth'])) { $clethArr = explode('|',$_GET['cleth']); }
    if (!empty($_GET['rind']))  { $rindArr  = explode('|',$_GET['rind']);  }
    $f = (int)($f);
    foreach ($clethArr as $i=>$fCleth) { $clethArr[$i] = (int)$fCleth; }
    foreach ($rindArr  as $i=>$fRind)  { $rindArr[$i]  = (int)$fRind;  }
    $clethImplode = implode('|',$clethArr);
    $uasCiana  = ( isset($_GET['uasCiana'])  ? $_GET['uasCiana'] : 14 ); if (!is_numeric($uasCiana)) { $uasCiana = 14; }
    $nochdFoMhir = ( empty($_GET['nochdFoMhir']) ? FALSE : TRUE );
    $nochdFoMhirChecked = ( $nochdFoMhir ? ' checked' : '');
    $nochdOsMhir = ( empty($_GET['nochdOsMhir']) ? FALSE : TRUE );
    $nochdOsMhirChecked = ( $nochdOsMhir ? ' checked' : '');
    $KSM = ( empty($_GET['KSM']) ? FALSE : TRUE );
    $KSMChecked = ( $KSM ? ' checked' : '');
    $modh = ( isset($_GET['modh']) ? $_GET['modh'] : 1 );
    $modh0Checked = $modh1Checked = $modh2Checked = '';
    if ($modh==0) { $modh0Checked = 'checked'; }
    if ($modh==1) { $modh1Checked = 'checked'; }
    if ($modh==2) { $modh2Checked = 'checked'; }
    $onloadSwopCount = '';

    $stordataConnector = SM_Bunadas::stordataConnector();
    $DbBun = $stordataConnector::singleton('rw');

    $nabArr = SM_Bunadas::nabaidhean2($f,$uasCiana,$nochdFoMhir,$nochdOsMhir,$modh,0.501,$KSM);

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
        global $nabArr, $rindArr, $clethArr;
        $html = SM_Bunadas::fHTML($f);
        if (in_array($f,$rindArr,true)) { $html .= ' <span class=preab><span>*</span> <span>←</span></span>'; }
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
        $fontsizeceum = number_format(100 * (8+$cianaroimhe)/(8+$ciana) ); //percent
        $fontsize = round(800.0/(6+$ciana));
        $html = "$doichHtml$meitchar<div class=charput style='margin:1px' id=cp$f>$html</div>";
        $html = "<div style='float:left;font-size:$fontsizeceum%;background-color:$backcol'>$html</div>";
        $clannArr = $clannHtmlArr = [];
        foreach ($nabArr as $nab=>$nabInfo) { if ($nabInfo[5]==$f) { $clannArr[] = $nab; } }
        usort($clannArr,'cmp');
        foreach ($clannArr as $nab) { $clannHtmlArr[$nab] = divHtml($nab,$doich).'<br style="clear:both">'; }
        $clannHtml = implode(' ',$clannHtmlArr);
        if (!empty($clannHtml)) {
            $clethClass = ( in_array($f,$clethArr,true) ? ' cleth' : '' );
            $html .= "<div class='nabDiv$clethClass' style='font-size:$fontsizeceum%;background-color:$backcol' id=nabDiv$f>$clannHtml</div>";
            $html .= "<div class='togDiv$clethClass' id=td$f>*</div>";
        }
        return $html;
    }
    $resultHtml = '<div style="clear:both;font-size:120%;padding-top:0.3em">' . divHtml($f,1) .'</div>';

    $resultHtml .= "<div style='clear:both;height:2em'></div>\n";  //spacer

    $stordataCss = SM_Bunadas::stordataCss();
    $h1 = "$T_Coimhearsnachd $f";

    $controlsHtml = <<<END_controlsHtml
<form id="priomhFoirm">
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
 <span title="Kiangley stiagh Gaelg veih Kevin Scannell">
  <label><input type="checkbox" name="KSM" $KSMChecked onclick="priomhSubmit();"> KSM</label>
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
END_controlsHtml;

    if (SM_Bunadas::is_count($f)) {
        $h1 = "$T_Language <a onclick='swopCount()'>⬌</a> $T_Word_count";
        $controlsHtml = '';
        if (isset($_GET['swopCount'])) { $onloadSwopCount = 'swopCount()'; }
    }

    $html = <<<END_HTML
<!DOCTYPE html>
<html lang="$hl">
<head>
    <meta charset="UTF-8">
    <meta name="google" content="notranslate">
    <meta name="robots" content="noindex,nofollow">
    <title>Bunadas: $T_Coimhearsnachd $f</title>
    <link rel="StyleSheet" href="/css/smo.css">
    <link rel="StyleSheet" href="snas.css.php">$stordataCss
    <style>
        div.loidhne { margin:7px 0 6px 1em; text-indent:-1em; background-color:#dcc; border-top:1px solid grey; }
        div.loidhne div { text-indent:0; }
        div.charput { display:inline; white-space:nowrap; }
        div.f { vertical-align:middle; }
        div.nabDiv, div.togDiv { float:left; white-space:nowrap; margin:2px; padding-left:3px; border-left:2px solid black; border-radius:5px; }
        div.togDiv { display:none; }
        div.nabDiv.cleth { display: none;  }
        div.togDiv.cleth { display: block; }
        span.preab { animation:preabadh 10s; }
        @keyframes preabadh { from { opacity:0; }
                                5% { opacity:1; }
                               10% { opacity:0; }
                               15% { opacity:1; background-color:red; }
                               20% { opacity:0; }
                               25% { opacity:1; }
                               30% { opacity:0; }
                               35% { opacity:1; background-color:pink;}
                               40% { opacity:0; }
                               45% { opacity:1; }
                               50% { opacity:0; }
                               55% { opacity:0.8; }
                               60% { opacity:0; }
                               65% { opacity:0.8; background-color:inherit; }
                               70% { opacity:0; }
                               75% { opacity:0.7; }
                               80% { opacity:0; }
                               85% { opacity:0.6; }
                               90% { opacity:0; }
                               95% { opacity:0.5; }
                                to { opacity:0; }
                            }
        span.preab span:nth-child(1) { background-color:#f10; color:white; font-weight:bold; font-size:65%; padding:0 0.3em; border-radius:0.3em }
        span.preab span:nth-child(2) { color:red; font-weight:bold; }
    </style>
    <script>
        var clethArr;
        function onloadFunc() {
            var cpdivs = document.querySelectorAll('div.charput');
            var tddivs = document.querySelectorAll('div.togDiv');
            for (var i = 0; i < cpdivs.length; i++) { cpdivs[i].addEventListener('click',toggleDiv); }
            for (var i = 0; i < tddivs.length; i++) { tddivs[i].addEventListener('click',toggleDiv); }

            var clethImplode = '$clethImplode';
            if (clethImplode=='') { clethArr = []; }
             else                 { clethArr = clethImplode.split('|'); }

            $onloadSwopCount
        }
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
                if (nabDiv.classList.contains('cleth')) {
                    nabDiv.classList.remove('cleth');
                    togDiv.classList.remove('cleth');
                    clethArr = clethArr.filter( function(el){return el!=f;} );
                } else {
                    nabDiv.classList.add('cleth');
                    togDiv.classList.add('cleth');
                    clethArr.push(f);
                }
            }
            var clethJoin = clethArr.join('|');
            var url = new URL(window.location.href);
            var search_params = url.searchParams
            search_params.delete('cleth');
            if (clethJoin!='') { search_params.append('cleth', clethJoin); }
            url.search = search_params.toString();
            var new_url = url.toString();
            history.replaceState({},null,new_url);
        }
        function swopCount() {
            let els = document.getElementsByClassName('f');
            for (let i=0; i<els.length; i++) {
                let elDeas = els[i].children[1];
                let elDeasA = elDeas.children[0];
                let value = elDeasA.innerHTML;
                let title = elDeas.title;
                elDeas.title = value;
                elDeasA.innerHTML = title;
            }
        }
    </script>
</head>
<body style="font-size:120%;" onload="onloadFunc();">

$navbar
<div class="smo-body-indent">

<a href="./"><img src="dealbhan/bunadas64.png" alt="An Sruth" style="float:left;border:1px solid black;margin:0 1em 1px 0"></a>
<h1 style="font-size:100%;margin-bottom:1px">$h1</h1>

$controlsHtml

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

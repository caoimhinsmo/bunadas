<?php
include 'autoload.inc.php';

function ceangal($f,$root,$rind=0,$params='') {
    $facal = SM_Bunadas::fHTML($f,0);
    if (empty($rind)) { $rind = $f; }
    $paramStr = ( $params=='fo' ? '&amp;fo=on' : '' );
    $ceangal = "<a href='/teanga/bunadas/fc.php?f=$root&amp;rind=$rind$paramStr'>$facal</a>";
    return $ceangal;
}

$neq = "<span style='padding:0 1em;font-family:monospace;font-size:140%'>&#x2249</span>";

$de_haben  = ceangal(57969,50740);
$la_habeo  = ceangal(55346,50544);

$de_Feuer  = ceangal(73926,50886);
$fr_feu    = ceangal(117210,66635);

$de_lassen = ceangal(58533,76334);
$fr_laisser= ceangal(58534,121907);

$en_day    = ceangal(54631,54630);
$es_dia    = ceangal(2494,50485);
$en_diary  = ceangal(141426,50485);

$en_much   = ceangal(59931,53344);
$es_mucho  = ceangal(135452,135454);

$en_other  = ceangal(134515,50685);
$es_otro   = ceangal(135466,56383);

$en_river  = ceangal(56080,56065);
$es_rio    = ceangal(57263,50717);

$en_cinder = ceangal(70325,70329);
$fr_cendre = ceangal(70322,70319);

$grc_theos = ceangal(54686,50503);
$la_deus   = ceangal(54633,50485,'54633|54639');
$grc_Zeus  = ceangal(54639,50485,'54633|54639');

$gd_eilean = ceangal(4348,60284);
$en_island = ceangal(60119,60119,0,'fo');
$en_isle   = ceangal(135432,135435);
$la_insula = ceangal(135435,135435);
$cy_ynys   = ceangal(1845,50945);
$ga_inis   = ceangal(3202,50945);

$en_lake   = ceangal(68157,68166);
$gd_loch   = ceangal(4621,68164,'4621|68177');
$fr_lac    = ceangal(68177,68164,'4621|68177');

$en_lay    = ceangal(117336,50779);
$gd_laoidh = ceangal(81139,134260);

$gd_duine  = ceangal(4312,50528);
$gd_daoine = ceangal(131918,50507); 


$en_male   = ceangal(140055,123546);
$en_female = ceangal(137801,50502);

$en_sorrow = ceangal(127608,127603);
$en_sorry  = ceangal(133599,61120);

$HTML = <<<END_HTML
<!DOCTYPE html>
<html lang="gd">
<head>
    <meta charset="UTF-8">
    <title>Cairdeas breugach</title>
    <link rel="StyleSheet" href="/css/smo.css">
    <link rel="StyleSheet" href="../snas.css.php">
    <style>
        ul.priomh { list-style:none; }
        ul li { margin:0 0 0.4em 0; }
        div.f div:nth-child(2):hover { background-color:blue; color:yellow; }
    </style>
</head>
<body style="font-size:125%">

<ul class="smo-navlist">
<li><a href="/toisich/" title="Sabhal Mór Ostaig - prìomh dhuilleag (le dà bhriog)">SMO</a></li>
<li><a href="/teanga/" title="Goireasan iol-chànanach aig SMO">Teanga</a></li>
<li><a href="/teanga/bunadas/" title="Bunadas - stòras de fhacail cho-dhàimheil">Bunadas</a>
</ul>
<div class="smo-body-indent" style="max-width:75em">

<h1 class="smo">Cairdeas breugach – False cognates</h1>

<ul class=priomh>
<li>$de_haben  $neq $la_habeo
<li>$de_Feuer  $neq $fr_feu
<li>$de_lassen $neq $fr_laisser
<li>$en_day    $neq $es_dia $en_diary
<li>$en_much   $neq $es_mucho
<li>$en_other  $neq $es_otro
<li>$en_river  $neq $es_rio
<li>$en_cinder $neq $fr_cendre
<li>$grc_theos $neq $la_deus $grc_Zeus
<li>$gd_eilean $neq $en_island $neq $en_isle $la_insula $neq $cy_ynys $ga_inis
<li>$en_lake   $neq $gd_loch $fr_lac
<li>$en_lay    $neq $gd_laoidh
<li>$gd_duine  $neq $gd_daoine

<li style="margin-top:2em">
    $en_male   $neq $en_female (cf. man≈woman)
<li>$en_sorrow $neq $en_sorry
</ul>

</div>
<ul class="smo-navlist">
<li><a href="/toisich/" title="Sabhal Mór Ostaig - prìomh dhuilleag (le dà bhriog)">SMO</a></li>
<li><a href="/teanga/" title="Goireasan iol-chànanach aig SMO">Teanga</a></li>
<li><a href="/teanga/bunadas/" title="Bunadas - stòras de fhacail cho-dhàimheil">Bunadas</a>
</ul>

<div class="smo-latha">2024-02-25 <a href="/~caoimhin/cpd.html">CPD</a></div>
</body>
</html>
END_HTML;

echo $HTML;
?>

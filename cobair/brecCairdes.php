<?php
include 'autoload.inc.php';

function ceangal($f,$root,$rind=0) {
    $facal = SM_Bunadas::fHTML($f,0);
    if (empty($rind)) { $rind = $f; }
    $ceangal = "<a href='/teanga/bunadas/fc.php?f=$root&amp;rind=$rind'>$facal</a>";
    return $ceangal;
}

$de_haben  = ceangal(57969,50740);
$la_habeo  = ceangal(55346,50544);

$de_Feuer  = ceangal(73926,50886);
$fr_feu    = ceangal(117210,66635);

$en_day    = ceangal(54631,54630);
$la_dies   = ceangal(51522,50485);

$grc_theos = ceangal(54686,50503);
$la_deus   = ceangal(54633,50485,'54633|54639');
$grc_Zeus  = ceangal(54639,50485,'54633|54639');

$en_lake   = ceangal(68157,68166);
$gd_loch   = ceangal(4621,68164,'4621|68177');
$fr_lac    = ceangal(68177,68164,'4621|68177');

$en_lay    = ceangal(117336,50779);
$gd_laoidh = ceangal(81139,134260);

$ga_duine  = ceangal(3000,50528);
$ga_daoine = ceangal(131917,50507); 

$HTML = <<<END_HTML
<!DOCTYPE html>
<html lang="gd">
<head>
    <meta charset="UTF-8">
    <title>Cairdeas breugach</title>
    <link rel="StyleSheet" href="/css/smo.css">
    <link rel="StyleSheet" href="../snas.css.php">
</head>
<body style="font-size:125%">

<ul class="smo-navlist">
<li><a href="/toisich/" title="Sabhal Mór Ostaig - prìomh dhuilleag (le dà bhriog)">SMO</a></li>
<li><a href="/teanga/" title="Goireasan iol-chànanach aig SMO">Teanga</a></li>
<li><a href="/teanga/bunadas/" title="Bunadas - stòras de fhacail cho-dhàimheil">Bunadas</a>
</ul>
<div class="smo-body-indent" style="max-width:75em">

<h1 class="smo">Cairdeas breugach – False cognates</h1>

<ul>
<li>$de_haben  ≠ $la_habeo
<li>$de_Feuer  ≠ $fr_feu
<li>$en_day    ≠ $la_dies
<li>$grc_theos ≠ $la_deus, $grc_Zeus
<li>$en_lake   ≠ $gd_loch, $fr_lac
<li>$en_lay    ≠ $gd_laoidh
<li>$ga_duine  ≠ $ga_daoine
</ul>

</div>
<ul class="smo-navlist">
<li><a href="/toisich/" title="Sabhal Mór Ostaig - prìomh dhuilleag (le dà bhriog)">SMO</a></li>
<li><a href="/teanga/" title="Goireasan iol-chànanach aig SMO">Teanga</a></li>
<li><a href="/teanga/bunadas/" title="Bunadas - stòras de fhacail cho-dhàimheil">Bunadas</a>
</ul>

<div class="smo-latha">2023-03-21 <a href="/~caoimhin/cpd.html">CPD</a></div>
</body>
</html>
END_HTML;

echo $HTML;
?>

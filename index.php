<?php
  if (!include('autoload.inc.php'))
    header("Location:https://claran.smo.uhi.ac.uk/mearachd/include_a_dhith/?faidhle=autoload.inc.php");

  try {
      $moSMO = SM_moSMO::singleton();
// Chan eil feum air seo an-dràsta co-dhiù
//      if (!$moSMO->cead('{logged-in}')) { $moSMO->diultadh(''); }
  } catch (Exception $e) {
      $moSMO->toradh = $e->getMessage();
  }

  $moSMO->dearbhaich();
  $T = new SM_T('bunadas/index');
  $hl = $T::hl0();
  $T_fotiotal         = $T->h('fo-tiotal');
  $T_Lorg_facal       = $T->h('Lorg facal');
  $T_facal_sanas      = $T->h('facal_sanas');
  $T_Liosta           = $T->h('Liosta');
  $T_Seall            = $T->h('Seall');
  $T_Cuir_ris         = $T->h('Cuir ris');
  $T_Cuir_facal_ris   = $T->h('Cuir facal ris');
  $T_Cuir_drong_ris   = $T->h('Cuir drong ris');
  $T_Sgrud            = $T->h('Sgrùd');
  $T_sgrudF0_tiotal   = $T->h('sgrudF0_tiotal');
  $T_sgrudD0_tiotal   = $T->h('sgrudD0_tiotal');
  $T_sgrudD1_tiotal   = $T->h('sgrudD1_tiotal');
  $T_sgrudDmor_tiotal = $T->h('sgrudDmor_tiotal');
  $T_sgrudDgabh_tiotal= $T->h('sgrudDgabh_tiotal');
  $T_sgrudFgundict_tiotal = $T->h('sgrudFgundict_tiotal');
  $T_Stordata         = $T->h('Stòr-dàta');
  $T_Cobhair          = $T->h('Cobhair');
  $T_mu_Bunadas       = $T->h('mu_Bunadas');
  $T_sa_Ghaidhlig     = $T->h('sa_Ghaidhlig');
  $T_sa_Bheurla       = $T->h('sa_Bheurla');
  $T_Briog_gus_suaip  = $T->h('Briog_gus_suaip');
  $T_Astar_fios       = $T->h('Astar_fios');
  $T_fiosStordata     = $T->h('fiosStordata');

  $T_fiosStordata     = strtr ( $T_fiosStordata, [ '{' => '<b>', '}' => '</b>' ] );

  $bunadasURL = SM_Bunadas::bunadasurl();
  if (!empty($_GET['bundb'])) {
      setcookie('bundb',$_GET['bundb']);
      header("Location:$bunadasURL");
  }
  $bundb = SM_Bunadas::bundb();
  if ($bundb=='bunadas') {
      $h1 = "<h1>Bunadas</h1>";
  } elseif ($bundb=='bunTest') {
      $h1 = <<<EODh1BunTest
<h1 style="margin:0.2em">BunTest</h1>
<p class="fiosStordata">$T_fiosStordata</p>
EODh1BunTest;
  } elseif ($bundb=='bunw') {
      $h1 = <<<EODh1Bunw
<h1 style="margin:0.2em">Bunw</h1>
<p class="fiosStordata">This is the <a href="//www1.icsi.berkeley.edu/~demelo/etymwn/">Etymological Wordnet</a> created by <a href="http://gerard.demelo.org/">Gerard de Melo</a> in 2013 by data-mining <a href="http://en.wiktionary.org">Wiktionary</a>.  It has been put into Bunadas format here as an experiment.</p>
EODh1Bunw;
  }

  $ainmTeanga = SM_Bunadas::ainmTeanga();
  $teangaithe = array_keys($ainmTeanga);
  $t1 = 'gd';
  $t2 = 'sga';

  $selectT1Html = "<select name='t1' onchange='this.form.submit()'>\n";
  $selectT2Html = "<select name='t2' onchange='this.form.submit()'>\n";
  foreach ($teangaithe as $t) { $selectT1Html .= "<option value='$t'" . ($t==$t1?' selected':'') . " lang='$t'>" . $ainmTeanga[$t] . " ($t)</option>\n"; }
  foreach ($teangaithe as $t) { $selectT2Html .= "<option value='$t'" . ($t==$t2?' selected':'') . " lang='$t'>" . $ainmTeanga[$t] . " ($t)</option>\n"; }
  $selectT1Html .= "</select>\n";
  $selectT2Html .= "</select>\n";

  $stordataCss = SM_Bunadas::stordataCss();

  try {
    $navbar = SM_Bunadas::navbar($T->domhan,1);

    if (SM_Bunadas::ceadSgriobhaidh()) {
        $deasaichHtml = <<<EODdeasaich

<li><a href="fDeasaich.php?f=0"><img src="/icons-smo/plusStar.png" alt=""> $T_Cuir_facal_ris</a>

<li>$T_Sgrud
   <ul>
   <li><a href="sgrudF0.php">$T_sgrudF0_tiotal</a>
   <li><a href="sgrudD0.php">$T_sgrudD0_tiotal</a>
   <li><a href="sgrudD1.php">$T_sgrudD1_tiotal</a>
   <li><a href="sgrudDmor.php">$T_sgrudDmor_tiotal</a>
   <li><a href="sgrudDgabh.php">$T_sgrudDgabh_tiotal</a>
   <li><a href="sgrudFgundict.php">$T_sgrudFgundict_tiotal</a>
   </ul>
EODdeasaich;
    } else {
        $deasaichHtml = '';
    }

    $bunadasSel = $bunTestSel = $bunwSel = '';
    if      ($bundb=='bunadas') { $bunadasSel = 'selected'; }
     elseif ($bundb=='bunTest') { $bunTestSel = 'selected'; }
     elseif ($bundb=='bunw')    { $bunwSel    = 'selected'; }
    $bundbForm = <<<EODbundbForm
<form style="float:right;margin-top:2em;font-size:70%" onChange="submit(this);">
$T_Stordata: <select name="bundb">
<option value="bunadas" $bunadasSel>bunadas</option>
<option value="bunTest" $bunTestSel>bunTest</option>
<option value="bunw" $bunwSel>bunw</option>
</select>
</form>
EODbundbForm;

    $html = <<<EODHTML
<!DOCTYPE html>
<html lang="$hl">
<head>
    <meta charset="UTF-8">
    <meta name="google" content="notranslate">
    <title>Bunadas</title>
    <link rel="StyleSheet" href="/css/smo.css">
    <link rel="StyleSheet" href="snas.css.php">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <style>
        ul#priomh { clear:both; list-style-type:none; }
        ul#priomh > li { margin-top:1.5em; }
        p.fiosStordata { margin:0 0 0 180px;padding:0.5em;border:2px solid green;border-radius:0.5em;background-color:#ffd;color:green;font-size:115% }
    </style>
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

<a href="dealbhan/bunadas476.png"><img src="dealbhan/bunadas160.png" style="float:left;border:1px solid black;margin:0 2em 2em 0" alt=""></a>

<div style="float:right;margin:0.3em 0.3em 1em 2em;border:1px solid green;border-radius:0.4em;background-color:#efe;padding:0.3em 0.5em;font-size:75%">
<a href="cobair/cobhair1.php">$T_Cobhair 1 <i>($T_sa_Ghaidhlig)</i></a><br>
<a href="cobair/cobhair2.php">$T_Cobhair 2 <i>($T_sa_Bheurla)</i></a><br>
<a href="cobair/muBunadas.php">$T_mu_Bunadas <i>($T_sa_Bheurla)</i></a></div>

$h1
<p style="margin-bottom:0.4em;font-weight:bold">$T_fotiotal</p>

<ul id="priomh">
<li><a href="lorg.php">$T_Lorg_facal <img src="/icons-smo/lorg.gif" alt=""></a>
    <form action=lorg.php style="display:inline"><input name="f" placeholder="$T_facal_sanas" autofocus></form>

<li>
<form style="display:inline" action="liosta.php">$T_Liosta
<input type="hidden" name="uasCiana" value=6>
<input type="hidden" name="uasAireamh" value=400>
$selectT1Html
<a href="liosta.php?t1=$t2&amp;t2=$t1&amp;uasCiana=6" title="$T_Briog_gus_suaip">▶</a>
$selectT2Html
<input id="uasCiana" name="uasCiana" type="range" min="0" max="15" step="0.1" value="2" style="width:30em;height:20px;padding:0" list=ticks title="$T_Astar_fios">
<input type="submit" value="$T_Seall">
</form>

$deasaichHtml
</ul>

$bundbForm

</div>
$navbar

</body>
</html>
EODHTML;

    echo $html;

  } catch (Exception $e) { echo $e; }
?>

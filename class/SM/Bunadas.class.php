<?php
class SM_Bunadas
{
  CONST LUCHD_SGRIOBHAIDH = 'caoimhinsmo|acdavie';
  public static function bunadasurl() {
       $url = ($_SERVER['HTTPS'] ? 'https' : 'http') . '://' . $_SERVER['SERVER_NAME'] . '/teanga/bunadas';
       return $url;
  }

//  public $fArr, $dArr, $fdArr, $dfArr;

  public static function bundb() {
      if (empty($_COOKIE['bundb']))     { return 'bunadas'; }
      if ($_COOKIE['bundb']=='bunadas') { return 'bunadas'; }
      if ($_COOKIE['bundb']=='bunTest') { return 'bunTest'; }
if ($_COOKIE['bundb']=='bunw')    { return 'bunadas';    }
      return 'bunadas';
  }

  public static function stordataConnector() {
      $bundb = self::bundb();
      if ($bundb=='bunadas') { return 'SM_BunadasPDO'; }
      if ($bundb=='bunTest') { return 'SM_BunTestPDO'; }
      throw new SM_Exception("\$stordata = $bundb - mì-laghail");
  }

  public static function ceadSgriobhaidh() {
      if (self::bundb()=='bunTest') { return 1; }
      $myCLIL = SM_myCLIL::singleton();
      if ($myCLIL->cead(self::LUCHD_SGRIOBHAIDH))   { return 1; }
      return 0;
  }

  public static function stordataCss() {
      $bundb = self::bundb();
      if ($bundb=='bunadas') { return ''; }
      if ($bundb=='bunTest') { return "\n    <link rel='StyleSheet' href='snasTest.css'>"; }
  }

  public static function navbar($domhan='',$duilleagAghaidh=0) {
      $hl0 = SM_T::hl0();
      $T = new SM_T('bunadas/navbar');
      $T_bunCeangalTitle    = $T->h('bunCeangalTitle');
      $T_canan_eadarAghaidh = $T->h('canan_eadarAghaidh');
      $T_Log_air            = $T->h('Log_air');
      $T_Log_air_fios       = $T->h('Log_air_fios');
      $T_Logout             = $T->h('Logout');
      $T_tr_fios            = $T->h('tr_fios');
      $bundb = ucfirst(self::bundb());
      $bunCeangal = ( $duilleagAghaidh ? '' : "\n<li><a href='/teanga/bunadas/' title='$T_bunCeangalTitle'>$bundb</a>" );
      $myCLIL = SM_myCLIL::singleton();
      $trPutan = '';
      if ($myCLIL->cead(SM_myCLIL::LUCHD_EADARTHEANGACHAIDH) && !empty($domhan))
        { $trPutan = "\n<li class=deas>"
                    ."<a href='http://www3.smo.uhi.ac.uk/teanga/smotr/tr.php?domhan=$domhan' target='tr' title='$T_tr_fios'>tr</a>"; }
      $bunadasURL = self::bunadasurl();
      $smotr = ( strpos($bunadasURL,'www2')!==false
               ? 'smotr_dev' //Adhockery - Cleachd 'smotr_dev' airson login air www2.smo.uhi.ac.uk
               : 'smotr');
      $till_gu = 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
      $ceangalRiMoSMO = ( isset($myCLIL->id)
                        ? "<li class='deas'><a href='/teanga/$smotr/logout.php?till_gu=$till_gu' title='Log out from myCLIL'>$T_Logout</a>"
                        : "<li class='deas'><a href='/teanga/$smotr/login.php?till_gu=$till_gu' title='$T_Log_air_fios'>$T_Log_air</a>"
                        );
      $hlArr = array(
          'br'=>'Brezhoneg',
          'da'=>'Dansk',
          'de'=>'Deutsch',
          'en'=>'English',
          'fr'=>'Français',
          'ga'=>'Gaeilge',
          'gd'=>'Gàidhlig',
          'it'=>'Italiano',
          'lt'=>'Lietuvių',
          'pt'=>'Portuguès',
          'sh'=>'Srpskohrvatsk',
          'bg'=>'Български',
//            '----1'=>'',  //Partial translations
            '----2'=>'',  //Very partial translations
          'cy'=>'Cymraeg (anorffenedig)',
          'es'=>'Español (incompleto)',
      );
      $options = '';
      foreach ($hlArr as $hl=>$hlAinm) {
          if (substr($hl,0,4)=='----')
                 { $options .= "<option value='' disabled>&nbsp;_{$hlAinm}_</option>\n"; }  //Divider in the list of select options
            else { $options .= "<option value='$hl|en'" . ( $hl==$hl0 ? ' selected' : '' ) . ">$hlAinm</option>\n"; }
      }
      $selCanan = <<< END_selCanan
<script>
    function atharraichCanan(hl) {
        document.cookie='Thl=' + hl + ';path=/teanga/bunadas/;max-age=15000000';  //Math airson sia mìosan
        var paramstr = location.search;
        if (/Trident/.test(navigator.userAgent) || /MSIE/.test(navigator.userAgent)) {
          //Rud lag lag airson seann Internet Explorer, nach eil eòlach air URLSearchParams. Sguab ás nuair a bhios IE marbh.
            if (paramstr.length==6 && paramstr.substring(0,4)=='?hl=') { paramstr = ''; }
            paramstr = paramstr;
        } else {
            const params = new URLSearchParams(paramstr)
            params.delete('hl');
            paramstr = params.toString();
            if (paramstr!='') { paramstr = '?'+paramstr; }
        }
        loc = window.location;
        location = loc.protocol + '//' + loc.hostname + loc.pathname + paramstr;
    }
</script>
<form>
<select name="hl" style="display:inline-block;background-color:#eef;margin:0 4px" onchange="atharraichCanan(this.options[this.selectedIndex].value)">
$options</select>
</form>
END_selCanan;
      $navbar = <<<EOD_NAVBAR
<ul class="smo-navlist">
<li><a href="/toisich/" title="Sabhal Mór Ostaig - prìomh dhuilleag (le dà briog)">SMO</a>
<li><a href="/teanga/" title="Goireasan iol-chànanach aig SMO">Teanga</a></li>$bunCeangal
$ceangalRiMoSMO
<li style="float:right" title="$T_canan_eadarAghaidh">$selCanan$trPutan
</ul>
EOD_NAVBAR;
      return $navbar;
  }

  public static function alphCompare($f1,$f2) {
  // Cuiridh seo na faclan $f1 agus $f2 an coimeas; tillidh e -1 ma tha $f1 roimh $f2 an òrdugh na h-abaidile agus 1 mura bheil
      $stordataConnector = self::stordataConnector();
      $DbCaoimhin = $stordataConnector::singleton('rw');
      $query = 'SELECT STRCMP(bunf1.focal,bunf2.focal) FROM bunf AS bunf1, bunf AS bunf2 WHERE bunf1.f=:f1 AND bunf2.f=:f2';
      $stmtcmp = $DbCaoimhin->prepare($query);
      $stmtcmp->execute([':f1'=>$f1,':f2'=>$f2]);
      $row = $stmtcmp->fetch(PDO::FETCH_NUM);
      return $row[0];
  }


  public static function is_count($f) {
      $stordataConnector = self::stordataConnector();
      $DbCaoimhin = $stordataConnector::singleton('rw');
      $stmt = $DbCaoimhin->prepare('SELECT focal FROM bunf WHERE f=:f');
      $stmt->execute(array(':f'=>$f));
      $focal = $stmt->fetchColumn();
      if ($focal=='{count}') { return 1; }
      return 0;
  }


  public static function fHTML($f,$ceangal=1,$KSM=TRUE) {
     //Cruthaich HTML airson putan a sheallas facail (le ceangal ma tha $ceangal=1)
      $stordataConnector = self::stordataConnector();
      $DbCaoimhin = $stordataConnector::singleton('rw');
      $stmt = $DbCaoimhin->prepare('SELECT t,focal,derb,gram,gluas FROM bunf WHERE f=:f');
      $stmt->execute(array(':f'=>$f));
      if (!($row = $stmt->fetch(PDO::FETCH_ASSOC)))
          { throw new SM_Exception('Mearachd sa function <b>putan</b>: Chan eil facal ' . htmlspecialchars($f) . ' ann'); }
      extract($row);
      $draggableT = $draggableF = $focalStyle = '';
      if ($focal=='{count}') {  //‘facal’ sònraichte airson cunntach
          if ($KSM) { $stmtCount = $DbCaoimhin->prepare("SELECT COUNT(1) FROM bunf WHERE t=:t"); } //Thoir a-steach faclan Manainnise bho Kevin Scannell
           else     { $stmtCount = $DbCaoimhin->prepare("SELECT COUNT(1) FROM bunf WHERE t=:t AND derb NOT LIKE 'KSM%'"); }
          $stmtCount->execute([':t'=>$t]);
          $focalHtml = $stmtCount->fetchColumn() - 1;
          $stmtBunt = $DbCaoimhin->prepare('SELECT ainmt FROM bunt WHERE t=:t');
          $stmtBunt->execute([':t'=>$t]);
          $gluasHtml = $stmtBunt->fetchColumn();
          if      ($focalHtml>=1000) { $focalStyle = 'font-weight:bold'; }
           elseif ($focalHtml<150)   { $focalStyle = 'opacity:0.4';      }
           elseif ($focalHtml<400)   { $focalStyle = 'opacity:0.7';      }
          if ($focalStyle) { $focalStyle = " style='$focalStyle'"; }
      } else {  //facal àbhaisteach
          $focalHtml = htmlspecialchars($focal,ENT_QUOTES);
          $gluasHtml = htmlspecialchars($gluas,ENT_QUOTES);
      }
      if (!empty($gram)) { $gluasHtml = "[$gram] $gluasHtml"; }
      if ($ceangal) {
          $draggableT = " draggable='true'";
          $draggableF = " draggable='false'";
          $focalHtml = "<a href='f.php?f=$f'$draggableF>$focalHtml</a>";
      }
      $tHtml = $t;
      if (strlen($t)>3 || $t=='mga' || $t=='xbm') { $tHtml = "<span style='font-size:75%'>$tHtml</span>"; }
      $derbStyle = ( substr($derb,0,3)=='KSM' ? ' style="color:red;background-color:pink"' : '' );
      $derbSC = htmlspecialchars($derb);
      $html = "<div class=f data-lang='$t' data-name='f$f'$draggableT>"
            . "<div>$tHtml</div><div$focalStyle title='$gluasHtml'>$focalHtml</div><div$derbStyle>$derbSC</div>"
            . "</div>";
      return $html;
  }


  public static function ainmTeanga() {
      $stordataConnector = self::stordataConnector();
      $DbCaoimhin = $stordataConnector::singleton('rw');
      $stmt = $DbCaoimhin->prepare('SELECT t,ainmt FROM bunt ORDER BY parentage_ord');
      $stmt->execute();
      $ainmean = array();
      while ($r = $stmt->fetch(PDO::FETCH_OBJ)) {
          $ainmean[$r->t] = $r->ainmt;
      }
      return $ainmean;
  }


  public static function meitHtmlArr() {
      $arr = array(
        -3 => '≪',   // U+226A  MUCH LESS THAN
        -2 => '≺',   // U+227A  PRECEEDS 
        -1 => '≼',   // U+227C  PRECEEDS OR EQUAL TO
         0 => '–',   // U+2013  EN DASH
         1 => '≽',   // U+227D  SUCCEEDS OR EQUAL TO
         2 => '≻',   // U+227B  SUCCEEDS
         3 => '≫');  // U+226B  MUCH GREATER THAN
      return $arr;
  }

  public static function meitHtml($meit) {
      switch ($meit) {
        case -3: return '≪';
        case -2: return '≺';
        case -1: return '<span style="color:#999">≼</span>';
        case  0: return '<span style="color:#ddd">–</span>';
        case  1: return '<span style="color:#999">≽</span>';
        case  2: return '≻';
        case  3: return '≫';
        default: throw new SM_Exception("\$meit neo-iomchaidh: $meit");
      }
  }
 

  public static function doichHtml($doich) {
  // Comharraidhean-ceiste mar rabhadh ma tha $doich<1
      $T = new SM_T('bunadas/f');
      $T_coltachd = $T->h('coltachd');
      $doichHtml = $doichStyle = '';
      if ($doich<0.98) {
          $doichHtml = ( $doich>=0.8 ? '?' : '??' );
          if      ($doich<0.6) { $doichStyle = 'style="color:red;font-weight:bold"'; }
           elseif ($doich<0.7) { $doichStyle = 'style="color:red"'; }
          $doichHtml = " <span $doichStyle title='$T_coltachd $doich'>$doichHtml</span>";
      }
      return $doichHtml;
  }


  public static function foDrong($dA,$dB) {
  // A’ cur sùil a bheil drong $dB a’ ghabhail a-steach drong $dB
  // Return values:
  //  2: Gach facal ann an $dA tha e cuideachd ann an $dB;
  //      agus chan fhaighear dà fhacal ann an $dA a tha nas fhaisg ann an $dA na tha iad ann an $dB.
  //  1: Gach facal ann an $dA tha e cuideachd ann an $dB;
  //      ach lorgar dà fhacal ann an $dA a tha nas fhaisg ann an $dA na tha iad ann an $dB.
  //  0: Chan eil $dB a’ gabhail a-steach $dA idir - tha facail ann an $dA nach eil ann an $dB.
      $stordataConnector = self::stordataConnector();
      $DbCaoimhin = $stordataConnector::singleton('rw');
      $stmtSELbuill = $DbCaoimhin->prepare('SELECT f,ciana,meit FROM bundf WHERE d=:d');

      $stmtSELbuill->execute(array(':d'=>$dA));
      $rows = $stmtSELbuill->fetchAll(PDO::FETCH_NUM);
      $buillA = array_column($rows,0);
      $cianaA = array_column($rows,1);

      $stmtSELbuill->execute(array(':d'=>$dB));
      $rows = $stmtSELbuill->fetchAll(PDO::FETCH_NUM);
      $buillB = array_column($rows,0);
      $cianaB = array_column($rows,1);

      if (count($buillA)>count($buillB)) { return 0; }
      foreach($buillA as $f) {
          if (!in_array($f,$buillB)) { return 0; }
      }  
      foreach ($buillA as $b1=>$f1) {
          foreach ($buillA as $b2=>$f2) {
              if ($f1>$f2) { continue; }
              if (  ($cianaA[$b1] 
                   + $cianaA[$b2])
                  < ($cianaB[$b1]
                   + $cianaB[$b2]) )
                  { return 1; }
          }
      }
      return 2;
  }


  public static function nabaidhean ($f0, $uasCiana=2, $t=null, $nochdFoMhir=0, $nochdOsMhir=0, $modh=0, $iosDoich=0.501) {
  // Tillidh seo array de na nabaidhean a tha taobh a-stigh ciana $uasCiana de facail $f0,
  // le coltachd os cionn $iosDoich, agus a tha ann an cànan $t.
      $stordataConnector = self::stordataConnector();
      $DbCaoimhin = $stordataConnector::singleton('rw');
      $nabArr = [$f0=>array(0,'','',1,'','')]; //ciana,slige,meitCar,doich,t,focal
      $piseach = 1;
      try {
//$iteration = 0;
          $stmtSEL1 = $DbCaoimhin->prepare('SELECT d,       ciana AS cianaD, -meit AS dolSuasD, doich AS doichD FROM bundf WHERE f=:f');
          $stmtSEL2 = $DbCaoimhin->prepare('SELECT f AS f2, ciana AS cianaF,  meit AS dolSuasF, doich AS doichF FROM bundf WHERE d=:d');
          $stmtSEL3 = $DbCaoimhin->prepare('SELECT t AS t2, focal AS focal2 FROM bunf WHERE f=:f');
          while ($piseach>0) {
//$iteration++;
              $piseach = 0;
              foreach ($nabArr as $f1=>$nabInfo1) {
                  $ciana1    = $nabInfo1[0];
                  $slige1    = $nabInfo1[1];
                  $meit1Car  = $nabInfo1[2];
                  $doich1    = $nabInfo1[3];
                  $stmtSEL1->execute(array(':f'=>$f1));
                  while ($rowd = $stmtSEL1->fetch(PDO::FETCH_ASSOC)) {
                      extract($rowd);
                      $cianaD += $ciana1;
                      $doichD *= $doich1;
                    if ($cianaD>$uasCiana) { continue; }
                    if ($doichD<$iosDoich) { continue; }
                      if ($modh==1 && abs($dolSuasD)==1) { $dolSuasD = 0; }
                      if (abs($dolSuasD)==3 && $modh<>2) { continue; }
                      if ($dolSuasD>0) {
                          if(!$nochdOsMhir) { continue; }
                          $meitDCar = '≻';
                      } elseif ($dolSuasD<0) {
                          if (!$nochdFoMhir) { continue; }
                          if ($meit1Car=='≻' || $meit1Car=='≶') { continue; } //Chan fhaodar dol sìos an déidh a dhol suas
                          $meitDCar = '≺';
                      } else {
                          $meitDCar = '';
                      }
                      if ($meit1Car<>'') {
                          if ($meitDCar=='≻' && $meit1Car=='≺') {
                              $meitDCar = '≶';
                          } else {
                              $meitDCar = $meit1Car;
                          }
                      }
                      $stmtSEL2->execute(array(':d'=>$d));
                      while ($rowf = $stmtSEL2->fetch(PDO::FETCH_ASSOC)) {
                      extract($rowf);
                          $ciana = $cianaD + $cianaF;
                          $doich = $doichD * $doichF;
                        if ($ciana>$uasCiana) { continue; }
                        if ($doich<$iosDoich) { continue; }
                          if (isset($nabArr[$f2]) && $nabArr[$f2][0]<=$ciana) { continue; }
                              if ($modh==1 && abs($dolSuasF)==1) { $dolSuasF = 0; }
                              if (abs($dolSuasF)==3 && $modh<>2) { continue; }
                              if ($dolSuasF>0) {
                                  if (!$nochdOsMhir) { continue; }
                                  $meitCar = '≻';
                              } elseif ($dolSuasF<0) {
                                  if (!$nochdFoMhir) { continue; }
                                  if ($meitDCar=='≻' || $meitDCar=='≶') { continue; } //Chan fhaodar dol sìos an déidh a dhol suas
                                  $meitCar = '≺';
                              } else {
                                  $meitCar = '';
                              }
                              if ($meitDCar<>'') {
                                  if ($meitCar=='≻' && $meitDCar=='≺') {
                                      $meitCar = '≶';
                                  } else {
                                      $meitCar = $meitDCar;
                                  }
                              }
                              $stmtSEL3->execute(array(':f'=>$f2));
                              $row = $stmtSEL3->fetch(PDO::FETCH_ASSOC);
                              extract($row);
                              $slige = $slige1 . "  ▶ ($t2) $focal2";
                              $nabArr[$f2] = array($ciana,$slige,$meitCar,$doich,$t2,$focal2);
                              $piseach=1;
                              if (count($nabArr)>1000) { throw new Exception('Cus nàbaidhean'); }
                      }
                  }
              }
          }
      } catch (exception $e) { }

      unset($nabArr[$f0]);
      if ($t<>'*') {
          foreach ($nabArr as $f=>$nabInfo) { if ($nabInfo[4]<>$t) { unset($nabArr[$f]); } }
      }
      asort($nabArr);
      return $nabArr;
  }


  public static function nabaidhean2 ($f0, $uasCiana=2, $nochdFoMhir=0, $nochdOsMhir=0, $modh=0, $iosDoich=0.501, $KSM=FALSE) {
  //Tillidh seo array de na nabaidhean a tha taobh a-stigh ciana $uasCiana de facail $f0, le coltachd os cionn $iosDoich.
      $stordataConnector = self::stordataConnector();
      $DbCaoimhin = $stordataConnector::singleton('rw');
      $stmtSEL1 = $DbCaoimhin->prepare('SELECT d,       ciana AS cianaD, -meit AS dolSuasD, doich AS doichD FROM bundf WHERE f=:f');
      $stmtSEL2 = $DbCaoimhin->prepare('SELECT f AS f2, ciana AS cianaF,  meit AS dolSuasF, doich AS doichF FROM bundf WHERE d=:d');
      $stmtSEL3 = $DbCaoimhin->prepare('SELECT bunf.t, focal, parentage_ord FROM bunf,bunt WHERE f=:f AND bunf.t=bunt.t');

      $stmtSEL3->execute(array(':f'=>$f0));
      $row0 = $stmtSEL3->fetch(PDO::FETCH_ASSOC);
      $t0 = $row0['t']; 
      $nabArr = [$f0=>array(0,'','',1,$t0,0,0,'')]; //ciana,slige,meitCar,doich,t,parant,cianaceum,parentage_ord
// ----- Sealach, gus déiligeadh ri Manainnis bho Kevin Scannell
$queryKSM = "SELECT bunf2.f FROM bunf AS bunf1, bunf AS bunf2"
            . " WHERE bunf1.f=:f1 AND bunf1.t=bunf2.t AND bunf1.focal=bunf2.focal"
            . " AND (    (bunf1.derb NOT LIKE 'KSM%' AND bunf2.derb LIKE 'KSM%')"
                 .  " OR (bunf1.derb LIKE 'KSM%' AND bunf2.derb NOT LIKE 'KSM%') )";
$stmtKSM = $DbCaoimhin->prepare($queryKSM);
// -------------------------------------------------------------
      $piseach = 1;
      try {
//$iteration = 0;
          while ($piseach>0) {
//$iteration++;
              $piseach = 0;
              foreach ($nabArr as $f1=>$nabInfo1) {
                  $ciana1    = $nabInfo1[0];
                  $slige1    = $nabInfo1[1];
                  $meit1Car  = $nabInfo1[2];
                  $doich1    = $nabInfo1[3];
                  $t1        = $nabInfo1[4];
// ----- Sealach, gus déiligeadh ri Manainnis bho Kevin Scannell
if ($KSM && in_array($t1,['gv','ga','gd','en'])) {
    $stmtKSM->execute([':f1'=>$f1]);
    $f2KSMArr = $stmtKSM->fetchAll(PDO::FETCH_COLUMN,0);
    foreach ($f2KSMArr as $f2KSM) {
        if (isset($nabArr[$f2KSM])) { continue; }
        $nabInfo2 = $nabInfo1;
        $nabInfo2[5] = $f1;
        $nabInfo2[6] = 0;
        $nabArr[$f2KSM] = $nabInfo2;
        $piseach = 1;
    }
}
// -------------------------------------------------------------
                  $stmtSEL1->execute(array(':f'=>$f1));
                  while ($rowd = $stmtSEL1->fetch(PDO::FETCH_ASSOC)) {
                      extract($rowd);
                      $cianaD += $ciana1;
                      $doichD *= $doich1;
                    if ($cianaD>$uasCiana) { continue; }
                    if ($doichD<$iosDoich) { continue; }
                      if ($modh==1 && abs($dolSuasD)==1) { $dolSuasD = 0; }
                      if (abs($dolSuasD)==3 && $modh<>2) { continue; }
                      if ($dolSuasD>0) {
                          if(!$nochdOsMhir) { continue; }
                          $meitDCar = '≻';
                      } elseif ($dolSuasD<0) {
                          if (!$nochdFoMhir) { continue; }
                          if ($meit1Car=='≻' || $meit1Car=='≶') { continue; } //Chan fhaodar dol sìos an déidh a dhol suas
                          $meitDCar = '≺';
                      } else {
                          $meitDCar = '';
                      }
                      if ($meit1Car<>'') {
                          if ($meitDCar=='≻' && $meit1Car=='≺') {
                              $meitDCar = '≶';
                          } else {
                              $meitDCar = $meit1Car;
                          }
                      }
                      $stmtSEL2->execute(array(':d'=>$d));
                      while ($rowf = $stmtSEL2->fetch(PDO::FETCH_ASSOC)) {
                          extract($rowf);
                          $ciana = $cianaD + $cianaF;
                          $cianaceum = $ciana - $ciana1;
                          $doich = $doichD * $doichF;
                        if ($ciana>$uasCiana) { continue; }
                        if ($doich<$iosDoich) { continue; }
                          if (isset($nabArr[$f2]) && $nabArr[$f2][0]<=$ciana) { continue; }
                              if ($modh==1 && abs($dolSuasF)==1) { $dolSuasF = 0; }
                              if (abs($dolSuasF)==3 && $modh<>2) { continue; }
                              if ($dolSuasF>0) {
                                  if (!$nochdOsMhir) { continue; }
                                  $meitCar = '≻';
                              } elseif ($dolSuasF<0) {
                                  if (!$nochdFoMhir) { continue; }
                                  if ($meitDCar=='≻' || $meitDCar=='≶') { continue; } //Chan fhaodar dol sìos an déidh a dhol suas
                                  $meitCar = '≺';
                              } else {
                                  $meitCar = '';
                              }
                              if ($meitDCar<>'') {
                                  if ($meitCar=='≻' && $meitDCar=='≺') {
                                      $meitCar = '≶';
                                  } else {
                                      $meitCar = $meitDCar;
                                  }
                              }
                              $stmtSEL3->execute(array(':f'=>$f2));
                              $row = $stmtSEL3->fetch(PDO::FETCH_ASSOC);
                              extract($row);
                              $slige = $slige1 . "  ▶ ($t) $focal";
                              $nabArr[$f2] = array($ciana,$slige,$meitCar,$doich,$t,$f1,$cianaceum,$parentage_ord);
                              $piseach=1;
                              if (count($nabArr)>1000) { throw new Exception('Cus nàbaidhean'); }
                      }
                  }
              }
          }
      } catch (exception $e) { }

      return $nabArr;
  }

  public static function focal($f) {
  //Tillidh seo am "focal" fhéin dhan fhacal le àireamh $f
      if (empty($f)) { return ''; }
      $stordataConnector = self::stordataConnector();
      $DbCaoimhin = $stordataConnector::singleton('rw');
      $stmt = $DbCaoimhin->prepare('SELECT focal FROM bunf WHERE f=:f');
      $stmt->execute([':f'=>$f]);
      $focal = $stmt->fetchColumn();
      return $focal;
  }

  public static function lomm($focal) {
      if (empty($focal)) { return ''; }
      $focalD = Normalizer::normalize($focal,Normalizer::FORM_D);
      $focalDchars = mb_str_split($focalD);
      $focalLomm = '';
      foreach ($focalDchars as $focalDchar) {
          if (!IntlChar::getCombiningClass($focalDchar)) { $focalLomm .= IntlChar::tolower($focalDchar); }
      }
      $focalLomm = Normalizer::normalize($focalLomm,Normalizer::FORM_C);
      return $focalLomm;
  }

}
?>

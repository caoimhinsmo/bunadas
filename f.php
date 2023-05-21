<?php
  if (!include('autoload.inc.php'))
    header("Location:https://claran.smo.uhi.ac.uk/mearachd/include_a_dhith/?faidhle=autoload.inc.php");
  header('Cache-Control:max-age=0');

  try {
      $myCLIL = SM_myCLIL::singleton();
  } catch (Exception $e) {
      $myCLIL->toradh = $e->getMessage();
  }

  try {
    $T = new SM_T('bunadas/f');
    $hl = $T::hl0();
    $T_Fios_mu_fhacal       = $T->h('Fiosrachadh mu fhacal');
    $T_Facal                = $T->h('Facal');
    $T_Coimhearsnachd       = $T->h('Coimhearsnachd');
    $T_Drong                = $T->h('Drong');
    $T_topar                = $T->h('topar');
    $T_Lorg_le_Multidict    = $T->h('Lorg le Multidict');
    $T_Lorg_ann_an_DASG     = $T->h('Lorg ann an DASG');
    $T_Deasaich_am_facal    = $T->h('Deasaich am facal');
    $T_Cru_drong_le_facal   = $T->h('Cruthaich drong ùr leis an fhacal seo');
    $T_Sguab_as             = $T->h('Sguab às');
    $T_Derb                 = $T->h('Derb');
    $T_Canan                = $T->h('Language');
    $T_Gram                 = $T->h('Gram');
    $T_Fis                  = $T->h('Fis');
    $T_IPA                  = $T->h('IPA');
    $T_Gluas                = $T->h('Gluas');
    $T_Cruthachadh          = $T->h('Cruthachadh');
    $T_Atharrachadh         = $T->h('Atharrachadh');
    $T_le                   = $T->h('le');
    $T_Cru_facal_don_drong  = $T->h('Cru_facal_don_drong');
    $T_Dublaich_an_drong    = $T->h('Dùblaich an drong');
    $T_Cuir_as_don_drong    = $T->h('Cuir às don drong');
    $T_Sguab_as_an_drong    = $T->h('Sguab am facal seo às an drong');
    $T_Atharr_nasg_le_drong = $T->h('Atharr_nasg_le_drong');
    $T_litreachadh          = $T->h('litreachadh');
    $T_fiosrachadh          = $T->h('fiosrachadh');
    $T_Litreachaidhean_eile = $T->h('Litreachaidhean eile');
    $T_Cuir_ris             = $T->h('Cuir ris');
    $T_teacsa               = $T->h('teacsa');
    $T_Iomraidhean          = $T->h('Iomraidhean');
    $T_Iomraidhean_fios     = $T->h('Iomraidhean_fios');
    $T_Faclairean           = $T->h('Faclairean');
    $T_Faclairean_fios      = $T->h('Faclairean_fios');
    $T_dictsltl_fios        = $T->h('dictsltl_fios');
    $T_word_placeholder     = $T->h('word_placeholder');
    $T_dictfis_ph           = $T->h('dictfis_ph');
    $T_a_bharrachd          = $T->h('a_bharrachd');
    $T_Briog_gus_am_faicinn = $T->h('Briog_gus_am_faicinn');
    $T_lexLegend            = $T->h('lexLegend');
    $T_lexLegend_fios       = $T->h('lexLegend_fios');
    $T_Os_fhacail           = $T->h('Os_fhacail');
    $T_Co_fhacail           = $T->h('Co_fhacail');
    $T_Fo_fhacail           = $T->h('Fo_fhacail');
    $T_Air_neo              = $T->h('Air neo');
    $T_Sguir                = $T->h('Sguir');
    $T_Sguab_facal_da_rir   = $T->h('Sguab_facal_da_rir');
    $T_Chan_eil_facal_ann   = $T->h('Chan_eil_facal_ann');
    $T_dictsltl_format_exc  = $T->h('dictsltl_format_exc');
    $T_Error_in             = $T->h('Error_in');

    $fisHtml = $dronganHtml = $lexHtml = $litHtml = $imradHtml = $dictHtml = $dictHtmlC = $javascriptDeasachaidh = $onload = '';

    $f = $_GET['f'];
    $deasaich = SM_Bunadas::ceadSgriobhaidh();

    $navbar = SM_Bunadas::navbar($T->domhan);

    $ainmTeanga = SM_Bunadas::ainmTeanga();
    $teangaithe = array_keys($ainmTeanga);

    $stordataConnector = SM_Bunadas::stordataConnector();
    $DbBun = $stordataConnector::singleton('rw');
    $bunadasurl = SM_Bunadas::bunadasurl();

    function uairHtml ($utime) {
        $uairObject = new DateTime("@$utime");
        $latha     = date_format($uairObject, 'Y-m-d');
        $lathaUair = date_format($uairObject, 'Y-m-d H:i:s');
        return "<span title=\"$lathaUair UT\">$latha</span>";
    }

    function comDrongHtml($f1,$f2) {
    //Cruthaich tick ma tha $f1 agus $f2 ann an drong còmhla
        global $DbBun;
        $stmt = $DbBun->prepare('SELECT 1 FROM bundf AS bundf1, bundf AS bundf2 WHERE bundf1.f=:f1 AND bundf2.f=:f2 AND bundf1.d=bundf2.d'); 
        $stmt->execute([':f1'=>$f1,':f2'=>$f2]);
        if ($stmt->fetch()) { return '<span class=cdTick>✓</span>'; }
         else               { return ''; }
    }

    $stmt = $DbBun->prepare('SELECT * FROM bunf WHERE f=:f');
    $stmt->execute(array(':f'=>$f));
    if (!$row = $stmt->fetch(PDO::FETCH_ASSOC)) { throw new SM_Exception("$T_Chan_eil_facal_ann: " . htmlspecialchars($f)); }
    extract($row);
    $fis   = htmlspecialchars($fis);
    $gluas = htmlspecialchars($gluas);
    $fDeasaichHtml = $fSguabHtml = $fiosCo = '';
    if ($deasaich) {
        $fiosCo   = ( empty($csmid) ? '' : "<span class=lab>$T_Cruthachadh:</span>&nbsp; " . uairHtml($cutime) . " $T_le $csmid" );
        $fiosCo  .= ( empty($msmid) || ($cutime==$mutime) ? '' : "<br><span class=lab>$T_Atharrachadh:</span> " . uairHtml($mutime) . " $T_le $msmid" );
        $fiosCo   = ( empty($fiosCo)? '' : "<tr style='font-size:50%'><td colspan=2>$fiosCo</td></tr>\n" );
        if (isset($_GET['sguab'])) {
            $fSguabHtml = <<< EODsguab
<div class=sguab>
$T_Sguab_facal_da_rir&nbsp;&nbsp; <a href="fSguab.php?f=$f&amp;till=./" class=sguab>$T_Sguab_as</a>
<br><br>
$T_Air_neo <a href=f.php?f=$f>$T_Sguir</a>
</div>
EODsguab;
        } else { 
            $fDeasaichHtml  = " <a href='fDeasaich.php?f=$f'><img src='/icons-smo/peann.png' alt='Deasaich' title='$T_Deasaich_am_facal'></a>"
                            . " <a href='dDeasaich.php?f=$f&d=0'><img src='/favicons/drongUr.png' alt='Drong ùr' title='$T_Cru_drong_le_facal'></a>"
                            . " <a href='f.php?f=$f&amp;sguab'><img src='/icons-smo/curAs2.png' title='$T_Sguab_as' alt='$T_Sguab_as'></a>";
        }
        $autofocusLit = ( isset($_GET['autofocusLit']) ? 'autofocus' : '');
        if (isset($_REQUEST['curLit']) && !empty($_REQUEST['lit']) && isset($_REQUEST['litfis'])) {
            $litREQ    = Normalizer::normalize(trim($_REQUEST['lit']));
            $litfisREQ = Normalizer::normalize(trim($_REQUEST['litfis']));
            $litREQ_ci = SM_Bunadas::lomm($litREQ);
            $stmtCurLit = $DbBun->prepare("INSERT IGNORE INTO bunfLit(f,lit,lit_ci,litfis) VALUES (:f,:lit,:lit_ci,:litfis)");
            $stmtCurLit->execute( array(':f'=>$f, ':lit'=>$litREQ, ':lit_ci'=>$litREQ_ci, ':litfis'=>$litfisREQ) );
            header("Location:$bunadasurl/f.php?f=$f&autofocusLit");
        }
        if (isset($_REQUEST['curImrad']) && isset($_REQUEST['imrad']) && isset($_REQUEST['url'])) {
            $imradREQ = trim($_REQUEST['imrad']);
            $urlREQ   = trim($_REQUEST['url']);
            if (!(empty($imradREQ)&&empty($urlREQ))) {
                $stmtCurImrad = $DbBun->prepare("INSERT IGNORE INTO bunfImrad(f,imrad,url) VALUES (:f,:imrad,:url)");
                $stmtCurImrad->execute( array(':f'=>$f, ':imrad'=>$imradREQ, ':url'=>$urlREQ) );
                header("Location:$bunadasurl/f.php?f=$f");
            }
        }
        if (isset($_REQUEST['curDict']) && isset($_REQUEST['dictsltl']) && isset($_REQUEST['word'])) {
            $dictsltlREQ = trim($_REQUEST['dictsltl']);
            $wordREQ     = trim($_REQUEST['word']);
            $dictfisREQ  = trim($_REQUEST['dictfis']);
            if (!(empty($dictsltlREQ)&&empty($wordREQ))) {
                if (count(explode('-',$dictsltlREQ))<>3) { throw new SM_Exception($T_dictsltl_format_exc); }
                if (preg_match('|dil\.ie/(.*)|',$wordREQ,$matches)) { $wordREQ = $matches[1]; }
                if (preg_match('|^\d+$|',$wordREQ)) { $wordREQ = "(($wordREQ))"; }
                $stmtCurDict = $DbBun->prepare("INSERT IGNORE INTO bunfDict(f,dictsltl,word,dictfis) VALUES (:f,:dictsltl,:word,:dictfis)");
                $stmtCurDict->execute([':f'=>$f, ':dictsltl'=>$dictsltlREQ, ':word'=>$wordREQ, ':dictfis'=>$dictfisREQ]);
                header("Location:$bunadasurl/f.php?f=$f");
            }
        }
        if ( isset($_REQUEST['DnD']) && isset($_REQUEST['fDrag']) && isset($_REQUEST['dDrop']) ) {  //Slaod is leig às
            $fDrag = $_REQUEST['fDrag'];
            $dDrop = $_REQUEST['dDrop'];
            $DbBun->beginTransaction();
            $stmtCuirriDrong = $DbBun->prepare("INSERT IGNORE INTO bundf(f,d) VALUES (:f,:d)");
            $stmtCuirriDrong->execute( array(':f'=>$fDrag, ':d'=>$dDrop) );
            if (isset($_REQUEST['dDrag'])) {
                $dDrag = $_REQUEST['dDrag'];
                $stmtDEL = $DbBun->prepare('DELETE FROM bundf WHERE f=:f AND d=:d');
                $stmtDEL->execute(array(':f'=>$fDrag,':d'=>$dDrag));
            }
            $DbBun->commit();
        }
    }
    $focalEnc = urlencode($focal);
    $ceanglaicheanHtml = "<a href='//multidict.net/multidict/?sl=$t&amp;word=$focalEnc' rel=nofollow>"
                       . "<img src='dealbhan/multidict.png' alt='Multidict' title='$T_Lorg_le_Multidict'></a>";
    if ($t=='gd') {
        $ceangalDASG = "//www.dasg.ac.uk/corpus/concordance.php?theData=$focalEnc"
                     . '&amp;qmode=sq_nocase&amp;pp=50&amp;del=end&amp;uT=y&amp;del=begin&amp;del=end&amp;uT=y';
        $ceanglaicheanHtml .= " <a href='$ceangalDASG' rel=nofollow>"
                             ."<img src=\"//multidict.net/multidict/icon.php?dict=DASG\" alt='DASG' title='$T_Lorg_ann_an_DASG'></a>";
    }
    $stmtDictC = $DbBun->prepare('SELECT * FROM bunfDict WHERE f=:f ORDER BY i');
    $stmtDictC->execute([':f'=>$f]);
    $rows = $stmtDictC->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $r) {
        extract($r);
        list($dict,$sl,$tl) = explode('-',$dictsltl);
        $title = "$dictsltl - $word";
        if (!empty($dictfis)) { $title .= " - $dictfis"; }
        $dictHtmlC .= " <a href='//multidict.net/multidict/?dict=$dict&amp;sl=$sl&amp;tl=$tl&amp;word=$word' title='$title' rel=nofollow>"
                     ."<img src='//multidict.net/multidict/icon.php?dict=$dict' alt='$dict'></a>";
    }
    $ceanglaicheanHtml .= $dictHtmlC;
    if      ($t=='ieur') { $focalWikt = "Reconstruction:Proto-Indo-European/$focal"; }
     elseif ($t=='celt') { $focalWikt = "Reconstruction:Proto-Celtic/$focal"; }
     elseif ($t=='mga')  { $focalWikt = "Reconstruction:Middle_Irish/$focal"; }
     elseif ($t=='brit') { $focalWikt = "Reconstruction:Proto-Brythonic/$focal"; }
     elseif ($t=='germ') { $focalWikt = "Reconstruction:Proto-Germanic/$focal"; }
     elseif ($t=='wger') { $focalWikt = "Reconstruction:Proto-West_Germanic/$focal"; }
     elseif ($t=='slav') { $focalWikt = "Reconstruction:Proto-Slavic/$focal"; }
     elseif ($t=='la')   { $focalWikt = strtr($focal,['ā'=>'a','ē'=>'e','ī'=>'i','ō'=>'o','ū'=>'u','Ā'=>'A','Ē'=>'E','Ī'=>'I','Ō'=>'O','Ū'=>'U']); }
     else                { $focalWikt = $focal; }
    $focalWikt = urlencode($focalWikt);
    $ceanglaicheanHtml .= " <a href='//en.wiktionary.org/wiki/$focalWikt' title='Wiktionary' rel=nofollow>"
                          ."<img src='/favicons/wiktionary.png' alt='W'></a>";

    $putan = SM_Bunadas::fHTML($f,0);
    $derbHtml = $gramHtml = $ipaHtml = $fiosHtml = '';
    if (!empty($derb)) { $derbHtml = "<br>&nbsp;<span class=lab>$T_Derb:</span> <b>$derb</b>"; }
    if (!empty($gram)) { $gramHtml = " &nbsp; <span class=lab>$T_Gram:</span> <span style='font-size:90%'>$gram</span>"; }
    if (!empty($ipa))  { $ipaHtml  = "<span class=lab style='padding-left:1em'>$T_IPA:</span> $ipa"; }
    if (!empty($fis))  { $fisHtml  = "<td colspan=2 style='padding-left:2em;text-indent:-2em'><span class=lab>$T_Fis:</span> <span style='font-size:80%'>$fis</span></td>"; }
    $ainmT = $ainmTeanga[$t];
    $fiosTableHtml = <<< END_fiosTableHtml
<table id=fiost>
<col><col>
<tr><td style='width:16em;white-space:nowrap'><span class=lab>$T_Canan:</span> $ainmT</td><td></td></tr>
<tr><td style='white-space:nowrap'><span class=lab>$T_Facal:</span> <b>$focal</b> $gramHtml$derbHtml</td><td>$ipaHtml</td></tr>
<tr><td colspan=2 style='padding-left:2.5em;text-indent:-2.5em'><span class=lab>$T_Gluas:</span> <span style='font-size:110%'>$gluas</span></td></tr>
$fisHtml
$fiosCo
</table>
END_fiosTableHtml;
    $fiosHtml = "<div style='float:left'>\n"
              . "<div style='margin:4px 0 7px 0'><span style='font-size:80%;font-weight:bold'>$T_Facal " . htmlspecialchars($f) ."</span> $ceanglaicheanHtml &nbsp;&nbsp;&nbsp;"
              . "<a href='fc.php?f=$f' class=putan>🌳 $T_Coimhearsnachd</a></div>\n"
              . "<div style='margin:2px 0;font-size:170%'>$putan$fDeasaichHtml</div>\n"
              . "</div>\n"
              . $fiosTableHtml;
    //(Dèan rudeigin nas adhartaiche uaireigin airson os-fhacail agus fo-fhacail, a’ toirt fa-near thàthanan agus toiseach facail agus deireadh facail)
    $stmtOs = $DbBun->prepare('SELECT f AS f2, focal AS focal2 FROM bunf WHERE focal LIKE :aPat AND focal<>:focal AND t=:t AND NOT f=:f AND CHAR_LENGTH(focal)>3'
                            . ' ORDER BY focal2,derb LIMIT 21');
    $stmtOs->execute(array(':aPat'=>"%$focal%",':focal'=>$focal,':t'=>$t,':f'=>$f));
    $rows = $stmtOs->fetchAll(PDO::FETCH_ASSOC);
    if (count($rows)>0 && count($rows)<21) {
        $lexHtml .= "<p class=tiotal>$T_Os_fhacail</p>\n";
        $lexHtml .= '<div style="margin:0.5em 0 0.5em 1em;line-height:150%">';
        foreach ($rows as $r) {
            extract($r);
            $lexHtml .= SM_Bunadas::fHTML($f2) . comDrongHtml($f,$f2) . ' ';
        }
        $lexHtml .= "</div>\n";
    }

    $stmtCo = $DbBun->prepare('SELECT f AS f2, focal AS focal2 FROM bunf WHERE focal=:focal AND t=:t AND NOT f=:f ORDER BY focal2,derb LIMIT 21');
    $stmtCo->execute(array(':focal'=>$focal,':t'=>$t,':f'=>$f));
    $rows = $stmtCo->fetchAll(PDO::FETCH_ASSOC);
    if (count($rows)>0 && count($rows)<21) {
        $lexHtml .= "<p class=tiotal>$T_Co_fhacail</p>\n";
        $lexHtml .= '<div style="margin:0.5em 0 0.5em 1em;line-height:150%">';
        foreach ($rows as $r) {
            extract($r);
            $lexHtml .= SM_Bunadas::fHTML($f2) . comDrongHtml($f,$f2) . ' ';
        }
        $lexHtml .= "</div>\n";
    }

    $stmtFo = $DbBun->prepare('SELECT f AS f2, focal AS focal2 FROM bunf WHERE LOCATE(focal,:focal)>0 AND focal<>:focal AND t=:t AND NOT f=:f AND CHAR_LENGTH(focal)>3'
                            . ' ORDER BY focal2,derb LIMIT 21');
    $stmtFo->execute(array(':focal'=>$focal,':t'=>$t,':f'=>$f));
    $rows = $stmtFo->fetchAll(PDO::FETCH_ASSOC);
    if (count($rows)>0 && count($rows)<21) {
        $lexHtml .= "<p class=tiotal>$T_Fo_fhacail</p>\n";
        $lexHtml .= '<div style="margin:0.5em 0 0.5em 1em;line-height:150%">';
        foreach ($rows as $r) {
            extract($r);
            $lexHtml .= SM_Bunadas::fHTML($f2) . comDrongHtml($f,$f2) . ' ';
        }
        $lexHtml .= "</div>\n";
    }

    if ($lexHtml) { $lexHtml = "<fieldset class=lex>\n<legend title='$T_lexLegend_fios'>$T_lexLegend</legend>\n$lexHtml\n</fieldset>\n"; }


    $stmtLit = $DbBun->prepare('SELECT l,lit,litfis FROM bunfLit WHERE f=:f ORDER BY bunfLit.l');
    $stmtLit->execute(array(':f'=>$f));
    $rows = $stmtLit->fetchAll(PDO::FETCH_ASSOC);
    $nLit = count($rows);
    if ($nLit<4)      { $nCols = 1; }
     elseif ($nLit<6) { $nCols = 2; }
     else             { $nCols = 3; }
    foreach ($rows as $r) {
        extract($r);
        $lit    = htmlspecialchars($lit);
        $litfis = htmlspecialchars($litfis);
        $litHtmlMir = $lit . ( empty($litfis) ? '' : " ($litfis)" );
        if ($litfis=='Gaeḋealg') { $litHtmlMir = "<span style='font-family:Bunchlo Dubh GC'>$litHtmlMir</span>"; }
        $litEnc = urlencode($lit);
        $multidictHtml = "<a href='//multidict.net/multidict/?sl=$t&amp;word=$litEnc' rel=nofollow>"
                        ."<img src='dealbhan/multidict.png' alt='Multidict' title='$T_Lorg_le_Multidict'></a>";
        $litHtmlMir = "$multidictHtml $litHtmlMir";
        $litHtmlsguab = ( !$deasaich ? ''
                        : " <span style='padding:0 0.5em 0 1.5em;color:grey'>—</span> <a onclick='sguabLit($f,$l)' title='$T_Sguab_as' style='color:red;font-weight:bold'>✘</a>"
                        );
        $litHtml .= "<li style='list-style-type:none'>$litHtmlMir$litHtmlsguab\n";
    }
    if ($litHtml) {
        $litHtml = "<ul style='columns:$nCols'>\n$litHtml</ul>\n";
    }
    if ($deasaich) {
        $litHtml .= "<ul><li class='curImrad'><form method='POST'><input type='hidden' name='f' value='$f'><input name='lit' placeholder='$T_litreachadh' value='' $autofocusLit>"
                    . " <input name='litfis' placeholder='$T_fiosrachadh' style='width:40em'>"
                    . " <input type='submit' name='curLit' value='$T_Cuir_ris'></form></ul>\n";
    }
    if ($litHtml) { $litHtml = "<fieldset class=imrad style='background-color:#eee8d7'>\n<legend title='Litreachaidhean eile air an aon fhacal'>$T_Litreachaidhean_eile</legend>\n$litHtml</fieldset>\n"; }

    $stmtImrad = $DbBun->prepare('SELECT i,imrad,url FROM bunfImrad WHERE f=:f ORDER BY bunfImrad.i');
    $stmtImrad->execute(array(':f'=>$f));
    $rows = $stmtImrad->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $r) {
        extract($r);
        $imrad = htmlspecialchars($imrad);
        $url   = htmlspecialchars($url);
        $ceangal = ( empty($imrad) ? $url : $imrad );
        if (!empty($url)) { $ceangal = "<a href='$url'>$ceangal</a>"; }
        $sguabImradHtml = ( !$deasaich ? ''
                          : " <span style='padding:0 0.5em 0 1.5em;color:grey'>—</span> <a onclick='sguabImrad($f,$i)' title='Sguab às' style='color:red;font-weight:bold'>✘</a>" );
        $imradHtml .= "<li>$ceangal$sguabImradHtml\n";
    }
    if ($deasaich) {
        $imradHtml .= "<li class='curImrad'><form method='POST'><input type='hidden' name='f' value='$f'><input name='imrad' placeholder='$T_teacsa' value=''>"
                    . " <input name='url' placeholder='url' style='width:40em'>"
                    . " <input type='submit' name='curImrad' value='$T_Cuir_ris'></form>\n";
    }
    if (!empty($imradHtml)) { $imradHtml = "<fieldset class=imrad>\n<legend title='$T_Iomraidhean_fios'>$T_Iomraidhean</legend>\n<ul>\n$imradHtml\n</ul>\n</fieldset>\n"; }

    if ($deasaich) {
        $stmtDict = $DbBun->prepare('SELECT * FROM bunfDict WHERE f=:f ORDER BY i');
        $stmtDict->execute(array(':f'=>$f));
        $rows = $stmtDict->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $r) {
            extract($r);
            $dictTaisbean = "$dictsltl : $word - $dictfis";
            $sguabDictHtml = ( !$deasaich ? ''
                              : " <span style='padding:0 0.5em 0 1.5em;color:grey'>—</span> <a onclick='sguabDict($f,$i)' title='Sguab às' style='color:red;font-weight:bold'>✘</a>" );
            $dictHtml .= "<li>$dictTaisbean$sguabDictHtml\n";
        }
        $dictsltlValue = $dictfisValue = '';
        if ($t=='sga' || $t=='mga') {
            $dictsltlValue = "value='eDIL-sga-en'";
            $dictfisValue = ( empty($derb) ? $focal : "$derb $focal" );
            $dictfisValue = "value='$dictfisValue'";
        }
        $dictHtml .= "<li class='curImrad'><form method='POST'><input type='hidden' name='f' value='$f'>"
                   . "<input name='dictsltl' placeholder='dict-sl-tl' pattern='\w{2,}-\w{2,}-\w{2,}' $dictsltlValue title='$T_dictsltl_fios'>"
                   . " <input name='word' placeholder='$T_word_placeholder' required style='width:20em'>"
                   . " <input name='dictfis' placeholder='$T_dictfis_ph' title='$T_dictfis_ph' $dictfisValue style='width:20em'>"
                   . " <input type='submit' name='curDict' value='$T_Cuir_ris'></form>\n";
        if (!empty($dictHtml)) { $dictHtml = "<fieldset class=imrad style='background-color:#fee'>\n<legend title='$T_Faclairean_fios'>$T_Faclairean</legend>\n<ul>\n$dictHtml\n</ul>\n</fieldset>\n"; }
    }

    $stmtd1 = $DbBun->prepare('SELECT bundf.d, topar, ABS(meit) AS meit0, ciana AS ciana0 FROM bundf,bund WHERE f=:f AND bundf.d=bund.d ORDER BY meit0,ciana0,d');
    $queryd2 = 'SELECT bunf.f AS f2, bunf.t AS t2, bunf.focal AS focal2, bunf.focal_ci AS focal2_ci, bunf.derb AS derb2, meit, ciana, doich, parentage_ord'
             . ' FROM bundf,bunf,bunt'
             . ' WHERE bundf.d=:d'
             . '   AND bundf.f=bunf.f'
             . '   AND bunf.t=bunt.t'
             . ' ORDER BY ciana,meit,parentage_ord,focal2_ci,focal2,derb2';
    $stmtd2 = $DbBun->prepare($queryd2);
    $stmtd1->execute(array(':f'=>$f));
    while ($row1 = $stmtd1->fetch(PDO::FETCH_ASSOC)) {
        extract($row1);
        $dDeasaichHtml = ( $deasaich
                         ? " <a href=fDeasaich.php?f=0&amp;d=$d><img src=/icons-smo/plusStar.png title='$T_Cru_facal_don_drong'></a>"
                          ." <a href=d.php?d=$d&amp;dublaich><img src=/icons-smo/dublaich.png class=dublaich title='$T_Dublaich_an_drong'></a>"
                          ." <a href=##><img src=/icons-smo/curAs2.png onClick=\"sguabDrong('$d');return(false);\" title='$T_Cuir_as_don_drong'></a>"
                         : ''
                         );
        $stmtd2->execute(array(':d'=>$d));
        $row2Arr = $stmtd2->fetchAll(PDO::FETCH_ASSOC);
        $nRiBearradh = 0;
        if (count($row2Arr)>6) { //Feuch cia meud sreathan a bhiodh rim bearradh
            $nTaisbean = 0;
            foreach ($row2Arr as $row2) {
                extract($row2);
                if ($f2==$f) { $nTaisbean++; }
                 elseif ( ($meit==1 && $nTaisbean>=10) || ($meit==2 && $nTaisbean>=6) || ($meit==3 && $nTaisbean>=4) ) { $nRiBearradh++; }
                 else { $nTaisbean++; }
            }
        }
        $bearr = ( $nRiBearradh>3 ? 1 : 0 ); //Nam biodh an àireamh nas ìsle na 3, cha b’fhiach bearradh a dhèanamh
        $bearrBarrHtml = '';
        if ($bearr) { $bearrBarrHtml =  "<span onclick=bearrToggle('d$d')><span class=bearrAir title='$T_Briog_gus_am_faicinn'>▼</span><span class=bearrDheth>▲</span></span>"; }

        $nBearrte = $nTaisbean = 0;
        $dTableHtml = $dClass = '';
        foreach ($row2Arr as $row2) {
            extract($row2);
            $meitHtml = SM_Bunadas::meitHtml($meit);
            $doichHtml = SM_Bunadas::doichHtml($doich);
            if ($deasaich) {
                $cianaDeasaichHtml = "<span onclick='atharrCiana($d,$f2,$ciana-1)' style='font-weight:bold;font-size:120%'>-</span> "
                                   . "<span onclick='atharrCiana($d,$f2,$ciana-0.1)'>-</span> "
                                   . "<span onclick='atharrCiana($d,$f2,$ciana+0.1)'>+</span> "
                                   . "<span onclick='atharrCiana($d,$f2,$ciana+1)' style='font-weight:bold;font-size:120%'>+</span> ";
                $meitDeasaichHtml = "<span onclick='atharrMeit($d,$f2,-3)'>≪</span> "
                                  . "<span onclick='atharrMeit($d,$f2,-2)'>≺</span> "
                                  . "<span onclick='atharrMeit($d,$f2,-1)'>≼</span> "
                                  . "<span onclick='atharrMeit($d,$f2,0)'>–</span> "
                                  . "<span onclick='atharrMeit($d,$f2,1)'>≽</span> "
                                  . "<span onclick='atharrMeit($d,$f2,2)'>≻</span> "
                                  . "<span onclick='atharrMeit($d,$f2,3)'>≫</span≻";
               $fDeasaichHtml = "<a href='d.php?d=$d&amp;f=$f2'><img src='/icons-smo/peann.png' title='$T_Atharr_nasg_le_drong' alt='Deasaich'></a>"
                                             .   " <img src='/icons-smo/curAs.png' onclick=\"sguabFbhoD($f2,$d)\" title='$T_Sguab_as_an_drong' alt='Sguab'>";
               $fDeasaichHtml = "<td>$fDeasaichHtml<span class=cianDeasaich>$cianaDeasaichHtml</span><span class=meitDeasaich>$meitDeasaichHtml</span></td>";
            }
            $saighead = '';
            if ($f2==$f) {
                $trclass = ' class=soillsich';
                $saighead = '⮕';
                if      ($ciana==0) { $dClass = ' ciana0';    }
                 elseif ($meit==2)  { $dClass = ' meit2';     }
                 elseif ($meit==-2) { $dClass = ' meit2neg';  }
                 elseif ($meit==3)  { $dClass = ' meit3';     }
                $nTaisbean++;
            } elseif (!$bearr) {
                $trclass = '';
                $nTaisbean++;
            } elseif ( ($meit==1 && $nTaisbean>=10) || ($meit==2 && $nTaisbean>=6) || ($meit==3 && $nTaisbean>=4) ) {
                $trclass = ' class=bearr';
                $nBearrte++;
            } else {
                $trclass = '';
                $nTaisbean++;
            }
            $cianaHtml = ( $ciana>0 ? $ciana : "<b style='color:black'>$ciana</b>" );
            $focal2Enc = urlencode($focal2);
            $dTableHtml .=  "<tr$trclass><td><a href='//multidict.net/multidict/?sl=$t2&amp;word=$focal2Enc' rel=nofollow>"
                             ."<img src='dealbhan/multidict.png' style='margin-right:0.2em' alt='' title='$T_Lorg_le_Multidict'></a>$saighead</td><td>"
                             . SM_Bunadas::fHTML($f2)
                             . "</td><td>$meitHtml</td><td style='color:grey;font-size:80%'>$cianaHtml$doichHtml</td>$fDeasaichHtml</tr>\n";
        }
        if ($nBearrte>0) {
            $bearrBunHtml = "<span class=bearrAir title='$T_Briog_gus_am_faicinn'>·· ▼ ·· <span class=bearrFios>+ $nBearrte $T_a_bharrachd</span></span>"
                          . "<span class=bearrDheth>&nbsp;&nbsp; ▲</span>";
            $dTableHtml .= "<tr><td></td><td colspan=3 onclick=bearrToggle('d$d')>$bearrBunHtml</td></tr>\n";
        }
        $dronganHtml .= <<<END_drongHtml
<div class='drong$dClass' id='d$d'>
<div class=dCeann><b><a href='d.php?d=$d'>$T_Drong $d</a></b>$dDeasaichHtml &nbsp; <span class=topar title='$T_topar'>($topar)</span> $bearrBarrHtml</div>
<div class=dColainn>
<table>
$dTableHtml
</table></div>
</div>
END_drongHtml;
    }

    if ($deasaich) { $javascriptDeasachaidh = <<<END_DnD_JAVASCRIPT
      //Javascript airson slaod-is-leig
        var drongStart, dDrag, shiftKey, ctrlKey;
        function findAncestor (el, cls) {
          //Cleachd “closest” an àite seo, nuair a bhios e mu dheireadh thall aig IE agus Edge
            while ((el = el.parentElement) && !el.classList.contains(cls));
            return el;
        }
        function handleDragStart(e) {
             drongStart = findAncestor(e.target,'drong');
             if (drongStart) { dDrag = drongStart.id.substring(1); }
              else           { dDrag = -1; }
             var name = e.target.getAttribute('data-name');
             e.dataTransfer.setData('text/x-bunadas', name);
             e.effectAllowed = 'copyMove';
             if (e.shiftKey) { shiftKey = true; } else { shiftKey = false; }
             if (e.ctrlKey)  { ctrlKey  = true; } else { ctrlKey  = false; }
        }
        function handleDragEnter(e) {
            if (this!=drongStart) { this.classList.add('over'); }
        }
        function handleDragLeave(e) {
            this.classList.remove('over');
        }
        function handleDragOver(e) {
            if (e.preventDefault) { e.preventDefault(); }
            e.dataTransfer.dropEffect = 'copy';
            if (shiftKey || ctrlKey || e.shiftKey || e.ctrlKey ) { e.dataTransfer.dropEffect = 'move'; }
        }
        function handleDrop(e) {
            if (e.stopPropogation) { e.stopPropogation(); }
            if (e.preventDefault) { e.preventDefault(); }
            var fDrag = e.dataTransfer.getData('text/x-bunadas').substring(1);
            var dDrop = this.id.substring(1);
            if (this!=drongStart) {
                var url = '$bunadasurl/ajax/DnD.php?fDrag=' + fDrag + '&dDrop=' + dDrop;
                if (e.dataTransfer.dropEffect == 'move' || e.shiftKey || e.ctrlKey) { url += '&dDrag=' + dDrag; }
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", url, false);
                xmlhttp.send();
                var resp = xmlhttp.responseText;
                if (resp!='OK') { alert('$T_Error_in DnD: ' + resp); }
                location.reload();
            }
        }
        function handleDragEnd(e) {
            e.dataTransfer.clearData();
            shiftKey = false;
            ctrlKey  = false;
        }
        function deasaichDnD() {
            var drongan = document.getElementsByClassName("drong");
            [].forEach.call(drongan, function(drong) {
                drong.addEventListener('drop',      handleDrop,      false);
                drong.addEventListener('dragenter', handleDragEnter, false);
                drong.addEventListener('dragleave', handleDragLeave, false);
                drong.addEventListener('dragover',  handleDragOver,  false);
            });
            var draggables = document.querySelectorAll('div.f[draggable=true]');
            [].forEach.call(draggables, function(draggable) {
                draggable.addEventListener('dragstart', handleDragStart, false);
            });
          }
        function sguabFbhoD(f,d) {
        //Javascript airson facal f a sguabadh bho drong d
            var url = '$bunadasurl/ajax/sguabFbhoD.php?f=' + f + '&d=' + d;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open('GET', url, false);
            xmlhttp.send();
            var resp = xmlhttp.responseText;
            if (resp!='OK') { alert('$T_Error_in sguabFbhoD: ' + resp); }
            location.reload();
        }
        function sguabLit(f,l) {
            var url = '$bunadasurl/ajax/sguabLit.php?f=' + f + '&l=' + l;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open('GET', url, false);
            xmlhttp.send();
            var resp = xmlhttp.responseText;
            if (resp!='OK') { alert('$T_Error_in sguabLit: ' + resp); }
            location.reload();
        }
        function sguabImrad(f,i) {
            var url = '$bunadasurl/ajax/sguabImrad.php?f=' + f + '&i=' + i;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open('GET', url, false);
            xmlhttp.send();
            var resp = xmlhttp.responseText;
            if (resp!='OK') { alert('$T_Error_in sguabImrad: ' + resp); }
            location.reload();
        }
        function sguabDict(f,i) {
            var url = '$bunadasurl/ajax/sguabDict.php?f=' + f + '&i=' + i;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open('GET', url, false);
            xmlhttp.send();
            var resp = xmlhttp.responseText;
            if (resp!='OK') { alert('$T_Error_in sguabDict: ' + resp); }
            location.reload();
        }
        function atharrMeit(d,f,m) {
            var url = '$bunadasurl/ajax/atharrMeit.php?d=' + d + '&f=' + f + '&m=' + m;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open('GET', url, false);
            xmlhttp.send();
            var resp = xmlhttp.responseText;
            if (resp!='OK') { alert('$T_Error_in atharrMeit: ' + resp); }
            location.reload();
        }
        function atharrCiana(d,f,c) {
            if (c<0) { c = 0; }
            var url = '$bunadasurl/ajax/atharrCiana.php?d=' + d + '&f=' + f + '&c=' + c;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open('GET', url, false);
            xmlhttp.send();
            var resp = xmlhttp.responseText;
            if (resp!='OK') { alert('$T_Error_in atharrCiana: ' + resp); }
            location.reload();
        }
        function sguabDrong(d) {
            var drong = document.getElementById('d'+d);
            drong.classList.add('sguab');
            setTimeout( function () { //Timeout a dhèanamh cinnteach gum bi an classList.add ri fhaicinn
                if (confirm('$T_Cuir_as_don_drong?')) {
                    var xhr = new XMLHttpRequest();
                    xhr.onload = function() {
                        var resp = this.responseText;
                        if (resp!='OK') { alert('$T_Error_in sguabDrong\\r\\n\\r\\n'+resp); return; }
                        drong.remove();
                    }
                    xhr.open('GET', 'ajax/sguabDrong.php?d='+d);
                    xhr.send();
                } else {
                    drong.classList.remove('sguab');
                }
            }, 40);
        }
END_DnD_JAVASCRIPT;
        $onload = " onload='deasaichDnD();'";
    }

    $stordataCss = SM_Bunadas::stordataCss();
    $html = <<<END_HTML
<!DOCTYPE html>
<html lang="$hl">
<head>
    <meta charset="UTF-8">
    <meta name="google" content="notranslate">
    <title>Bunadas: $T_Fios_mu_fhacal $f</title>
    <link rel="StyleSheet" href="/css/smo.css">$stordataCss
    <link rel="StyleSheet" href="snas.css.php">
    <style>
        div.drong              { background-color:#ffe; clear:both; margin:0.8em 0; border:2px solid #338; border-radius:0.6em; max-width:45em; }
        div.drong table        { border-collapse:collapse; }
        div.drong tr.soillsich { background-color:#ff8; }
        div.drong tr.soillsich:hover { background-color:#fea; }
        div.drong tr.bearr     { display:none; }
        div.drong.bearrDheth tr.bearr { display:table-row; }
        div.drong tr:hover     { background-color:#fee; }
        div.drong table td     { padding:1px 1px; }
        div.drong tr td:nth-child(3) { min-width:1.1em; }
        div.drong tr td:nth-child(4) { min-width:1.6em; }
        div.drong tr td:nth-child(5) { padding-left:1.5em; }
        div.sguab         { margin:0.4em 0; border:6px solid red; border-radius:7px; background-color:#fdd; padding:0.7em; }
        div.sguab a       { font-size:112%; background-color:#55a8eb; color:white; font-weight:bold; padding:3px 10px; border:0; border-radius:8px; text-decoration:none; }
        div.sguab a:hover { background-color:blue; }
        div.sguab a.sguab       { background-color:#f84; }
        div.sguab a.sguab:hover { background-color:red; font-weight:bold; }
        a.putan { padding:1px 5px; text-decoration:none; border:1px solid blue; border-radius:7px }
        a.putan:not(:hover) { background-color:#ddf; }
        fieldset.lex          { clear:both; margin:0.8em 0; border:1px solid; padding:0.4em 0.4em 0 1em; background-color:#bbb; font-size:60%; }
        fieldset.lex legend   { background-color:#555; color:white; font-size:110%; font-weight:bold; }
        fieldset.lex p.tiotal { margin:0;font-size:80%;font-weight:bold }
        fieldset.imrad        { clear:both; margin:1em 0.5em 1em 3em; padding:0.1em; background-color:#ddf8e8; font-size:80%; }
        fieldset.imrad legend { background-color:#555; color:white; font-size:90%; font-weight:bold; margin-left:1em; }
        fieldset.imrad ul     { margin:0; }
        li.curImrad { margin-top:8px; margin-bottom:0; list-style-type:none; }
        div.dCeann { border-radius:0.5em 0.5em 0 0;  border-bottom:1px solid #669; background-color:#cdf; padding:0.1em 0 0 0.6em; }
        div.dCeann img { padding:0em  0.5em; }
        div.dColainn { margin-top:0.3em; border-radius: 0 0 0.6em 0.6em; padding-left:0.3em; }
        div.ciana0 div.dCeann  { background-color:#ece; }
        div.drong.meit2        { background-color:#e0ffe0; font-size:95%; }
        div.drong.meit2neg     { background-color:#fcf; }
        div.drong.meit3        { background-color:#eee; font-size:75%; }
        div.drong.meit3 div.dCeann { background-color:#aaa; }
        table#fiost { clear:both; margin:0.4em 0 0.2em 0; border-collapse:collapse; font-size:90%; }
        table#fiost tr { vertical-align:top; }
        table#fiost td { padding:0.1em 0; }
        table#fiost span.lab { font-weight:normal; font-size:80%; color:#666; }
        span.topar { font-size:80%; color:#bbb; }
        span.cianDeasaich { padding-left:1.5em; color:#8b7; }
        span.meitDeasaich { padding-left:1.5em; color:#77e; }
        span.cianDeasaich > span:hover,
        span.meitDeasaich > span:hover { background-color:blue; color:yellow; cursor:default; }
        span.bearrFios { font-style:italic; font-size:75%; }
        span.cdTick { color:green; font-size:150%; }
        img.dublaich:hover { background-color:#99f; }
        div.drong span.bearrAir   { display:inline; }
        div.drong span.bearrDheth { display:none;   }
        div.drong.bearrDheth span.bearrAir   { display:none;   }
        div.drong.bearrDheth span.bearrDheth { display:inline; }
    </style>
    <script>
        function bearrToggle(d) {
            var drong = document.getElementById(d);
            if (drong.classList.contains('bearrDheth'))
                  { drong.classList.remove('bearrDheth'); }
             else { drong.classList.add('bearrDheth');    }
        }
$javascriptDeasachaidh
    </script>
</head>
<body$onload>

$navbar
<div class="smo-body-indent" style="max-width:70em">

$fSguabHtml
<a href="./"><img src="dealbhan/bunadas64.png" style="float:left;border:1px solid black;margin:0 2em 2em 0" alt=""></a>
$fiosHtml

$dronganHtml
$lexHtml
$litHtml
$imradHtml
$dictHtml

</div>
$navbar

</body>
</html>
END_HTML;

    echo $html;

  } catch (exception $e) { echo $e; }
?>

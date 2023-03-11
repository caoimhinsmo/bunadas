<?php
  if (!include('autoload.inc.php'))
    header("Location:https://claran.smo.uhi.ac.uk/mearachd/include_a_dhith/?faidhle=autoload.inc.php");
  header('Cache-Control:max-age=0');

  $nmax = 10;
  $bodyHtml = $torFocalHtml = $torLitHtml = '';

  try {
      $myCLIL = SM_myCLIL::singleton();
      if (!SM_Bunadas::ceadSgriobhaidh()) { $myCLIL->diultadh(''); }
      $myCLIL->dearbhaich();
  } catch (Exception $e) {
      $bodyHtml = $e;
  }

  $T = new SM_T('bunadas/lomaich');
  $hl = $T::hl0();
  $tiotal = 'Lomaich focal gu focal_ci agus lit gu lit_ci';

  $smid = $myCLIL->id;
  $navbar = SM_Bunadas::navbar($T->domhan);
  $stordataCss = SM_Bunadas::stordataCSS();

  if (!$bodyHtml) {
    $stordataConnector = SM_Bunadas::stordataConnector();
    $DbBun = $stordataConnector::singleton('rw');

    $stmtFocalSEL = $DbBun->prepare('SELECT f, t, focal, focal_ci FROM bunf ORDER BY t,focal');
    $stmtFocalUPD = $DbBun->prepare('UPDATE bunf SET focal_ci=:lom WHERE f=:f');
    $stmtFocalSEL->execute();
    $torFocal = $stmtFocalSEL->fetchAll(PDO::FETCH_ASSOC);
    $nAtharr = 0;
    foreach ($torFocal as $r) {
        extract($r);
        $focal_lom = SM_Bunadas::lomm($focal);
        if ($focal_lom<>$focal_ci) {
            $stmtFocalUPD->execute( [':f'=>$f, ':lom'=>$focal_lom] );
            $nAtharr++;
            if ($nAtharr <= $nmax)
              { $torFocalHtml .= "<tr><td>$t</td><td>$focal</td><td>$focal_ci</td><td>→ $focal_lom</td></tr>\n"; }
            elseif ($nAtharr == $nmax+1)
              { $torFocalHtml .= "<tr><td>[...]</td></tr>\n"; }
        }
    }
    if ($torFocalHtml) { $torFocalHtml = <<<END_TorFocalHtml
      <table class='tor'>
      $torFocalHtml
      </table>
      <p>Chaidh $nAtharr atharrachaidhean a dhèanamh</p>
      END_TorFocalHtml;
    } else { $torFocalHtml = "<p>Cha robh dad ri dhèanamh</p>\n"; }

    $stmtLitSEL = $DbBun->prepare('SELECT l, lit, lit_ci FROM bunfLit ORDER BY lit');
    $stmtLitUPD = $DbBun->prepare('UPDATE bunfLit SET lit_ci=:lom WHERE l=:l');
    $stmtLitSEL->execute();
    $torLit = $stmtLitSEL->fetchAll(PDO::FETCH_ASSOC);
    $nAtharr = 0;
    foreach ($torLit as $r) {
        extract($r);
        $lit_lom = SM_Bunadas::lomm($lit);
        if ($lit_lom<>$lit_ci) {
            $stmtLitUPD->execute( [':l'=>$l, ':lom'=>$lit_lom] );
            $nAtharr++;
            if ($nAtharr <= $nmax)
              { $torLitHtml .= "<tr><td>$lit</td><td>$lit_ci</td><td>→ $lit_lom</td></tr>\n"; }
            elseif ($nAtharr == $nmax+1)
              { $torLitHtml .= "<tr><td>[...]</td></tr>\n"; }
        }
    }
    if ($torLitHtml) { $torLitHtml = <<<END_TorLitHtml
      <table class='tor'>
      $torLitHtml
      </table>
      <p>Chaidh $nAtharr atharrachaidhean a dhèanamh</p>
      END_TorLitHtml;
    } else { $torLitHtml = "<p>Cha robh dad ri dhèanamh</p>\n"; }

    $bodyHtml = <<<END_bodyHtml
      <a href="./"><img src="dealbhan/bunadas64.png" style="float:left;border:1px solid black;margin:0 2em 2em 0" alt=""></a>
      <h1 class=smo>$tiotal</h1>
      <h2 style='clear:both'>Table bunf</h2>
      $torFocalHtml
      <h2>Table bunfLit</h2>
      $torLitHtml
      END_bodyHtml;
  }

  echo <<<EODHtmlEis
    <!DOCTYPE html>
    <html lang="$hl">
    <head>
        <meta charset="UTF-8">
        <meta name="google" content="notranslate">
        <meta name="robots" content="noindex,nofollow">
        <title>Bunadas: $tiotal</title>
        <link rel="StyleSheet" href="/css/smo.css">
        <link rel="StyleSheet" href="snas.css.php">$stordataCss
        <style>
           table.tor { border-collapse:collapse; margin:1em; }
           table.tor td { padding:1px 3px; }
        </style>
    </head>
    <body>
    $navbar
    <div class="smo-body-indent">

    $bodyHtml

    </div>
    $navbar
    </body>
    </html>
    EODHtmlEis
?>

<?php
//CHAN EIL SEO AG OBAIR FHATHAST

  if (!include('autoload.inc.php'))
    header("Location:https://claran.smo.uhi.ac.uk/mearachd/include_a_dhith/?faidhle=autoload.inc.php");

// Gabhaidh am prògram seo facal sean-Ghàidhlig, agus nì e ath-threòrachadh gu www.dil.ie/browse/show/nnnnn,
// le àireamh nnnnn a tha iomchaidh gus am facal fhéin (is dòcha) agus faclan a tha faisg air a thaisbeanadh.
// Chan eil e a’ buntainn ri Bunadas, ach a-mhàin gu bheil e a’ dèanamh feum den fhiosrachadh a th’aig Bunadas mun t-sean-Ghàidhlig agus eDIL

  $bundb = SM_BunadasPDO::singleton();
  $q = $_REQUEST['q'];
  if (empty($q)) { throw new Exception('Mearachd ann an eDILbrowse.php: Tha am prògram seo feumach air parameter q='); }
  $stmt = $bundb->prepare("SELECT focal,word FROM bunf,bunfDict"
                         ." WHERE bunf.t='sga' AND bunf.f=bunfDict.f AND bunf.focal<:q"
                         ." ORDER BY focal DESC LIMIT 1");
  $stmt->execute([':q'=>$q]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  extract($row);
  $word = substr($word,1,-1);
  $location = "http://www.dil.ie/browse/show/$word";
  header("Location:$location");
//  echo "$focal $word";

?>

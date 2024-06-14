<?php
include 'autoload.inc.php';

function focal($f) {
    $focalHTML = SM_Bunadas::fHTML($f,0);
    $focalHTML = "<span class=focal>$focalHTML</span>";
    return $focalHTML;
}

$ieur_kwo      = focal(51129);
$ieur_tkey     = focal(62995);
$ieur_tkineti  = focal(63503);
$celt_cu       = focal(6448);
$celt_Kunowalos= focal(66359);
$sga_cu        = focal(8900);
$sga_cuallacht = focal(37134);
$ga_cu         = focal(2942);
$ga_cuallacht  = focal(19661);
$gd_cu         = focal(4237);
$cy_ci         = focal(901);
$cy_corgi      = focal(52067);
$cy_milgi      = focal(1482);
$cy_trychchwn  = focal(118468);
$germ_hundaz   = focal(66326);
$ang_hund_dog  = focal(66327);
$ang_hund_100  = focal(61658);
$ang_grighund  = focal(126109);
$en_compose    = focal(63508);
$en_hound      = focal(2261);
$de_Hund       = focal(1915);
$de_Dachshund  = focal(58556);
$de_Dachs      = focal(58554);
$la_conpono    = focal(63507);
$la_pono       = focal(63505);
$la_sino       = focal(63504);

$HTML = <<<END_HTML
<!DOCTYPE html>
<html lang="gd">
<head>
    <meta charset="UTF-8">
    <title>Bunadas: a network database of cognate words, with emphasis on Celtic</title>
    <link rel="StyleSheet" href="/css/smo.css" type="text/css">
    <link rel="StyleSheet" href="../../snas.css.php" type="text/css">
    <style>
        div.p { margin:1em 0; }
        span.focal { font-size:75%; }
        img.fig { padding:0.2em; border:2px solid; }
        figcaption { font-size:85%; font-style:italic }
    </style>
</head>
<body style="font-size:125%;max-width:72em">

<ul class="smo-navlist">
<li><a href="/toisich/" title="Sabhal Mór Ostaig - prìomh dhuilleag (le dà bhriog)">SMO</a></li>
<li><a href="/teanga/" title="Goireasan iol-chànanach aig SMO">Teanga</a></li>
<li><a href="/teanga/bunadas/" title="Bunadas - stòras de fhacail cho-dhàimheil">Bunadas</a>
</ul>
<div class="smo-body-indent" style="max-width:72em">

<h1 class="smo">Bunadas: a network database of cognate words, with emphasis on Celtic</h1>

<div style="margin:0 4em;font-style:italic">
<p>Bunadas is a network database of cognate words, freely available as a WWW resource1.  It contains so far about 100,000 words in about 40 Indo-European languages ancient and modern, going back to PIE itself, and including 70,000 in the Celtic languages.</p>

<p>Cognate words are useful for language learning, especially vocabulary. They provide insight into the basic underlying meanings of words, and into the history of languages, peoples and technologies. Etymological dictionaries typically provide long, but rather random and very incomplete lists of cognates, with lots of inefficient duplication between dictionaries, and small languages often lack any good  etymological dictionary at all. It is more efficient to assemble together the information for many languages at once. However, the tabular, rectangular structure typically used for short illustrative lists of cognates simply does not scale up. Bunadas uses instead a network structure, which enables “genealogical trees” of cognates to be generated on the fly. This paper describes some vital aspects of its design, and gives some thoughts on its future.</p>

<p>This paper is best read while simultaneously trying out <a href="/">Bunadas</a> itself.</p>
</div>

<h2>An example tree</h2>

<div class=p>Let’s jump straight in with an example of the kind of cognate tree which Bunadas can generate.  The screenshot below shows the tree starting from the Proto-Indo-European word $ieur_kwo ‘dog’.</div>

<figure>
    <img src="fig1.png" class=fig>
    <figcaption>Figure 1: A tree starting from the Proto-Indo-European word $ieur_kwo</figcaption>
</figure>

<div class=p>The tree shows descendants (reflexes) of $ieur_kwo, such as Proto-Celtic $celt_cu, Old Irish $sga_cu, Scottish Gaelic $gd_cu, Proto-Germanic $germ_hundaz, Old English $ang_hund_dog, and English $en_hound.  Each word in Bunadas has two, or occasionally three, components.  First comes a standard language tag such as sga or gd (taken from <a href="https://en.wikipedia.org/wiki/ISO_639-1">ISO 639-1</a> where available, or else <a href="https://en.wikipedia.org/wiki/ISO_639-3">ISO 639-3</a>, with occasional ad-hoc additions for reconstructed proto languages).  Importantly for human usability, this is colour-coded to reflect the language family: green for Celtic, black for Germanic, red for Romance, blue for Slavic, bronze for Greek. Next comes the actual spelling of the word, and again this is colour-coded to reflect finer distinctions.  The general progression is from wish-washy white or gray colours for the proto languages, progressing to stronger colours for the modern languages.</div>

<div class=p>Finally there can be a third component, a disambiguator to distinguish homographs.  We see this in the Old English word $ang_hund_dog for example, which has been given the disambiguator ‘dog’, because there is another word $ang_hund_100 meaning ‘hundred’.  For languages which have a single very authoritative dictionary, such as Welsh (<a href="https://geiriadur.ac.uk/gpc/gpc.html">GPC</a>) or Old Irish (<a href="https://dil.ie">DIL</a>), Bunadas uses the disambiguator from this dictionary, but in other cases it can use any arbitrary text string which will serve the purpose.  This disambiguation of homographs is vital to make Bunadas work, and is something which Wiktionary is still not very good at.  Internally, Bunadas works using numeric ids for words and is therefore not confused by homographs, but these ids are not much seen by users and the disambiguators are therefore vital for keeping users and editors from being confused and going wrong.</div>


<h2>Words and clusters</h2>

<div class=p>The trees which Bunadas displays are perhaps its most impressive feature, but Bunadas does not in fact store anything in tree form.  Its basic building blocks are words and clusters of words.  Using the word-cluster-word connections, it connects the words into a network, a network which is not a tree, and which can and does contain lots of cycles.  When asked, though, to display a tree starting from say $ieur_kwo, Bunadas walks the network and produces a minimal spanning-tree of words cognate to ḱwṓ.</div>

<div class=p>A “cluster” in Bunadas is just a particular group of words which are all related to one another etymologically (a definition which includes not only groups of words from different languages, but also groups of morphological derivatives within a language).  Clusters can and do overlap, and they can be used in whatever way the compilor(s) and editor(s) of Bunadas find convenient. To see how clusters work, let’s click on the word $ang_hund_dog.  This produces the webpage shown below.</div>

<figure>
    <img src="fig2.png" class=fig>
    <figcaption>Figure 2: The word $ang_hund_dog showing the clusters it belongs to.</figcaption>
</figure>

<div class=p>At the very top of the page, there is a fuzzy M on a yellow background.  This connects to a dictionary lookup of the word via <a href="https://multidict.net/multidict">Multidict</a>.  Multidict has a database of information on lots of online dictionaries, including etymological dictionaries, in lots of languages, together with the parameters which enable it to link through to them transparently.  To the right of the yellow M, there is a [W] favicon which connects to a <a href="https://www.wiktionary.org/">Wiktionary</a> lookup of the word.  Thus we see that Bunadas affords excellent connections to other resources.</p>

<div class=p>Following that at the top of the page are the properties stored for the word $ang_hund_dog in the Bunadas database.  At the very bottom of the page is a grey section “Lexically similar words”, showing hypergraphs, homographs and hypographs (if any), but this is just additional information which might be of use to users and editors and is nothing to do with Bunadas itself.</p>

<div class=p>The section in the middle, showing the clusters, is what is important for the structure of Bunadas.  We see that our word $ang_hund_dog belongs to three clusters.  The first connects it with its modern English reflex $en_hound.  The second connects it with another Old English word $ang_grighund.  The third puts it in a cluster of words descended from Proto-Germanic $germ_hundaz.</p>

<div class=p>The numbers, 0 or 1, shown after the words in the clusters are a metric indicating the distance of the word from the “centre” of the cluster.  Normally we try to pick some word to be at the centre of the cluster, at distance 0.  This would normally be the word in the proto language if all the other words are descendants of it; or the basic stem word if the other words are morphological variants of it.  It is not necessary to have a “centre” word, though.  A cluster of cognate words with no known antecedent could show them all as distance 1 from the cluster, and they would then each be distance 1+1 = 2 from each other.  The metric is not restricted to values 0 or 1.  It can be any number at all, such as 2, or 4.3, and this can be useful when we know that two words are related, but probably rather distantly.  Bunadas is not normally very sensitive to the distance metric, because the important thing is the connectivity, and mostly the metric is just left as 1.  However, tweaking the metric a bit, from 1 to 1.1 or to 0.9, can be useful when we want to tweak the tree to show word derivation via a particular path, such as $sga_cu ⭢ $sga_cuallacht ⭢ $ga_cuallacht (synchronic in Old Irish, followed by diachronic to Modern Irish), in preference to $sga_cu ⭢ $ga_cu ⭢ $ga_cuallacht (diachronic to Irish, followed by synchronic in Modern Irish).</div>

<div class=p>Note that the way the trees are constructed, as minimal spanning trees calculated by walking through the network and minimizing the total metric distance, means that if we were to duplicate a cluster, this would make no difference whatsoever to the trees.  This was a design decision early on in the design of Bunadas.  An alternative approach would be to say that if words are shown as related in two different clusters, perhaps derived from two different information sources, then this provides stronger evidence and the words should be more strongly linked.  Rejecting this alternative approach and choosing to use minimal spanning trees has proven in practice to be a good decision.</div>

<div class=p>We see that in the second cluster shown in Figure 2, $ang_hund_dog is linked to $ang_grighund.  Why then does $ang_grighund not appear in the tree shown in Figure 1?  The answer lies in the ≻ symbol shown after <i>grīġhund</i> in the cluster.  This symbol means that <i>grīġhund</i> is made up of two (or more) main components, and <i>hund</i> is only one of them.</div>

<div class=p>If we want to see $ang_grighund in the tree, we have to switch on the option “Show super-elements”.  The result is shown in Figure 3 below.

<figure>
    <img src="fig3.png" class=fig>
    <figcaption>Figure 3: Tree with “Show super-elements” switched on</figcaption>
</figure>

<div class=p>Figure 3 also illustrates some other features of Bunadas.</div>

<div class=p>Hovering over a word causes the part of speech and gloss for the word to pop up, in this case “[nm] greyhound”.</div>

<div class=p>The word $cy_trychchwn is preceded by two red question marks, and hovering over them will display “probability 0.6”.  It is sometimes uncertain as to whether words are related, and Bunadas can take this uncertainty into account by attaching a probability to whether a word rightly belongs to a cluster.  When generating trees, Bunadas naively multiplies any probabilities it encounters, and if the resulting probability drops to 0.5 or lower, it stops there and goes no further along that particular path.  So for example if there is a probability 0.6 that word A is an ancestor of word B, and a probability 0.7 that word B is an ancestor of word C, then Bunadas naively assumes that there is a probability 0.6 × 0.7 = 0.42 that word A is related to word C, and therefore it does not (unless there is other evidence) show word C or its descendants in the tree it generates starting from word A, because the connection is too dubious.</div>

<div class=p>The word $celt_Kunowalos has a (* after it, as do four other words.  This is because I have “pruned” the tree at these points, compressing branches to reduce clutter and fit the tree into a reasonably sized figure. Any branch can be pruned by clicking the language tag of the headword, and can be “unpruned” by clicking again or by clicking the * symbol.  The pruning is “remembered” in the URL, which is very useful when passing Bunadas tree URLs to other people as illustrations of particular points.</p>

<div class=p>As well as the option “Show super-elements” in Bunadas trees, there is an option “Show sub-elements”.  But here Bunadas has to be very careful!  If both options are switched on, it will happily go down to sub-elements when constructing trees and then back up again: from $cy_corgi to $cy_ci to $cy_milgi for example, which is fine because the words are all related.  However, the Bunadas algorithm does not allow itself to go up and then back down!  Otherwise it would go from $de_Hund to $de_Dachshund to $de_Dachs and claim wrongly that $de_Hund and $de_Dachs were related.</p>

<div class=p>In addition to the ≻ symbol, Bunadas has two other symbols which are important in indicating the type of relationship between words, namely the symbols ≫ and ≽.  The ≫ symbol is for showing that one “word” (or prefix or suffix) is only a very minor component of another word, while conversely the ≽ symbol is for showing that two words are substantially the same, that one is a very major component of the other.  Thus, when linking words within a language, the ≽ symbol is typically used when linking a word with its root word, while the ≫ symbol is typically used when linking it to minor morphemes such as prefixes and suffixes.  In analyzing the English word en:only, for example, it could be linked to the suffix en:-ly using the ≫ symbol, and linked to the English word en:one using the ≽ symbol.  When constructing trees, Bunadas by default treats words linked by the ≽ symbol as being substantially the same: the rule “no going up then back down” which it applies to the ≻ symbol, it does not by default apply to the ≽ symbol.</div>

<div class=p>When constructing trees, Bunadas does not normally follow ≫ links at all – otherwise it would construct many false links via trivial prefixes and suffixes.   The ≫ symbal can also, by the way, be used to record that a word is a calque of a word in another language.  Thus the Old Irish <i>día lúain</i> ‘Monday’, for example, is derived from the native words <i>día</i> and <i>lúan</i>, and the relationship is shown with the ≻ symbol.  It is a calque of Latin <i>diēs Lūnae</i>, and this connection can be shown with the ≫ symbol, eunsuring that it is not followed when constructing trees.</div>

<div class=p>The ≻ symbol is most often used when words have combined into one by concatenation or similar, as in English <i>seafarer</i>, German <i>Seefahrer</i>, or Proto-Celtic <i>tegoslougom</i>.  However, it can also be used where two words which are near homonyms have merged into one.</div>

<div class=p>Another situation in which the ≻ symbol may be used is where a word may have come partially via one route, partially via another – such as where an Old Irish word may have come partially from an Old Norse word but partially from a similar Old English word, and both of these have in any case come from the same Proto-Germanic word.  In this case, it is possible to get the best of both worlds by linking the Old Irish word using ≻ to the Old Norse and Old English words, but also linking     it directly to the Proto-Germanic ancestor, maybe setting the distance metric here as 2.  Or we might want to give it probability 0.5 as as having come from Old Norse, 0.5 from Old English, while linking it with certainty to the Proto-Germanic ancestor.</div>

<div class=p>Most of the time it is obvious which symbol is appropriate when linking words together.  Sometimes, though, it is not certain whether it is best to break a word down into two equal-status components using ≻ for each; or whether to apply ≽ to one and ≫ to the other, and if so which of them should be considered the major component (which will therefore appear in trees) and which the minor.  It is important for anyone editing Bunadas to maintain consistency, and if say, an Old French word is broken down in a particular way, then the Modern French word should be broken down in the same way.</div>

<div class=p>The idea of a tree of descendants can go “wrong”, or at least exhibit somewhat pathological behavior. Take, for example, the tree of descendants for PIE tḱey-. In all the descendants, we can at least see some reflex of the ‘tḱ’ from the PIE root – except in the branch derived from Latin sinō and pōnō.</div>

<div class=p style="margin-left:2em">
$ieur_tkey ⭢ $ieur_tkineti ⭢ $la_sino ⭢ $la_pono ⭢ $la_conpono ⭢ $en_compose
</div>

<div class=p>The ‘s’ of Latin sinō comes from the ‘tḱ’ of tḱey-, but this has disappeared in pōnō after prefixing by po-, and pōnō has absolutely nothing left of the original tḱey-; everything it contains comes from prefixes and suffixes added later. This is even more extreme by the time we reach English “compose”. On each step of the way from “tḱey-” to “compose”, each word has clearly been derived from the word immediately before it, and yet no smidgeon of tḱey- can be found in the word “compose”. Other examples can be found, such as PIE gʰed- ⭢ English “prison” (as well as the more transparent English “get”).  Fortunately, this situation does not occur often enough to be a big problem, and the trees generated by Bunadas are nearly always informative and meaningful.</div>

<div class=p>There is a question as to whether we need the concept of “cluster” at all, or whether it would be better to relate words directly to one another, going word-word rather than word-cluster-word.  There are advantages and disadvantages to each approach.  From a purely theoretical point of view, both approaches are equivalent and can be converted into one another.  Word-word connections are obviously a special case of small clusters.  And clusters can be broken down automatically into word-word connections, albeit rather a lot of them in the case of a large cluster having no “centre” word.  Having direct word-word connections would simplify the programming a bit, perhaps simplify the logic a bit, and would speed up the computations slightly. The clusters, though, are very useful to human editors, and facilitate meaningful groupings which are easier to assess and to manage.  The Bunadas editing facilities allow words to be drag-and-dropped from cluster to cluster, which is very useful.</div>

<div class=p>The Bunadas editing facilities can be tried out by anyone who is interested, simply by swapping to the bunTest database in the dropdown on the main Bunadas page.  The Bunadas programs are all publicly available on <a href="https://github.com/caoimhinsmo/bunadas">Github</a> to anyone who is interested. The <a href="../../cloning">/cloning webpage</a> gives details, and even includes a moderately up-to-date dump of the entire Bunadas database.  The Bunadas user interface is available in a dozen languages so far, and there is a good translation interface so it would be easy to add still more interface languages.  As can be seen from Github, the programs are written in PHP, with MariaDB (or MySQL) as the backend relational database, and with JavaScript/AJAX used to help provide a responsive user interface.</div>

<h2>Orthography, and which wordform to use for Bunadas words</h2>

<div class=p>It is important for Bunadas to be consistent about orthography so that the same word is not added to Bunadas multiple times, to the confusion of users.  Bunadas nearly always uses the <a href="https://en.wiktionary.org/wiki/Category:Wiktionary_language_considerations">orthographic guidelines defined by Wiktionary</a> for the various languages.  This is particularly important for the reconstructed proto-languages, where no historic spelling system exists and diverse systems have been used by different authorities and authors. Wiktionary has created detailed orthographic guidelines for example for <a href="https://en.wiktionary.org/wiki/Wiktionary:About_Proto-Indo-European">Proto-Indo-European</a>, <a href="https://en.wiktionary.org/wiki/Wiktionary:About_Proto-Celtic">Proto-Celtic</a>, <a href="https://en.wiktionary.org/wiki/Wiktionary:About_Proto-Celtic">Proto-Brythonic</a> and <a href="https://en.wiktionary.org/wiki/Wiktionary:About_Proto-Germanic">Proto-Germanic</a>.  For languages where Wiktionary sometimes uses more detailed orthography, sometimes less detailed, Bunadas takes care to use the more detailed orthography.  This is the case for Ancient Greek, for example, where the particular entries have detailed diacritics marking breathings, short vowels, etc, but the internal links in Wiktionary may use less detailed diacritics.</div>

<div class=p>At present Old Irish is an exception to the rule that Bunadas follows Wiktionary spelling guidelines.  Here Bunadas generally follows the spelling in DIL, the Dictionary of the Irish Language.  This is because DIL is so authoritative and so readily available online, but most of all because of the huge contribution to Bunadas derived from the <i>Innéacs Nua-Ghaeilge don DIL</i>, about 13,000 Old-Irish–Modern-Irish pairs.  In particular, this means that Bunadas currently uses the hyphen (-) rather than the raised dot (·) to show the “joint” of the verbal complex.  It is expected that Bunadas will move at some stage to using the Wiktionary orthography for Old Irish.  This will not, though, cause the link with DIL will be lost, because each Old Irish word in Bunadas is already linked to its numeric entry number in DIL.</div>

<div class=p>Just as important as consistency in orthography, is consistency regarding which wordform to use for Bunadas words – whether, for example, to use the first-person-singular for verbs, or else the third-person-singular, or singular-imperative, or infinitive.  Here again, Bunadas follows the Wiktionary preference for each particular language: the first-singular for Latin verbs, for example; but the infinitive for French and Old French verbs.  Wiktionary does in fact also try to include brief entries for the infinitive of Latin verbs, first-singular of French verbs, etc, and indeed for nearly all other grammatical forms, but its preferred form is clear for each language.  Bunadas goes for much less morphological granularity than Wiktionary does, so as to avoid clutter which would be unhelpful to the user.  To illustrate from English, Bunadas would be happy to include both the verb <i>state</i> and the noun <i>statement</i>, but it would certainly not include verbforms <i>stating</i>, <i>stated</i> and <i>states</i>, whereas Wiktionary includes all of these. This difference in morphological granularity means that whereas Wiktionary can link a French verb (in the infinitive) to the Latin infinitive from which it is derived, Bunadas links it to the Latin first-person-singular; and whereas Wiktionary can link a French noun to the Latin accusative from which it is derived, Bunadas links it to the Latin noun in the nominative.</div>

<div class=p>In the case of Modern Irish, the need to standardize to the singular-imperative of verbs required a major conversion excercise.  The singular-imperative is used by Wikipedia and by most dictionaries, but unfortunately the third-singular is the form which was used by the <i>Innéacs Nua-Ghaeilge</i>.</div>

<div class=p>In the case of suppletive verbs or suppletive nouns, the idea of sticking to a standard wordform for each language breaks down.  The English past tense <i>went</i>, for example, cannot be simply covered by the verb <i>go</i> as in many dictionaries; it requires a separate entry in Bunadas.  The choice of which wordform to use to represent a group of suppletive forms often has to be made on an ad-hoc basis.</div>

<h2>What Bunadas does and does not do</h2>

<div class=p>What Bunadas does do is to exploit connectivity – in a big way!  If word A is etymologically related to word B, and word B is etymologically related to word C, then word A is etymologically related to word C, and so on. There is no need to store separately the information that A is etymologically related to C.  This avoids the duplication and avoids a lot of the gaps which occur in etymological dictionaries.</div>

<div class=p>What Bunadas does not do, just to be very clear about it, is to concern itself with how or why or even in what direction A is etymologically related to B: whether A is inherited from B, or is a modern borrowing of B, or vice versa, or whether they are both derived separately from a common ancestor.  Bunadas can link A with B in all these different circumstances.</div>

<div class=p>Of course, Bunadas can, and very often does, give clues about how A might be related to B.  If A is a Latin word at the centre (metric distance 0) of a cluster which also contains B and other modern Romance words, this is a very strong clue that B is derived from A rather than the other way round.  If a French word B is linked straight to a Latin word A, while another French word D is linked via Middle French and Old French words to A, then this indicates strongly that French word D is inherited, while B may or may not be a modern borrowing.  As more words in intermediate languages are added to Bunadas, these clues become stronger, but they are still just clues.  Bunadas has a free-text comments field for each word where information about derivation could be added.  All these things, though, are peripheral to Bunadas.  They are not its core functionality, which is about connectivity.</div>

<div class=p>Bunadas contains no information at all about sound laws: about how an inherited Modern French word D, for example, might have been shaped by going through the mangle of Middle French and Old French and Vulgar Latin sound changes.  It is conceivable that soundlaw information might somehow someday be “bolted on” to Bunadas, but this is not planned or envisaged in the near future.</div>

<h2>The future</h2>

<div class=p>Where does Bunadas go from here?  Obviously adding more words in more languages would help.  Adding more words would make the trees more cluttered, but this could be alleviated by improving the filtering/pruning facilities: by introducing filtering by language family for example.</div>

<div class=p>Bunadas was initially populated by about 5000 words from the <a href="https://www.smo.uhi.ac.uk/gaidhlig/faclair/scc/">Stòr-fhaclan Co-dhàimheil Ceilteach</a> (Celtic Cognates Database), a project which had become moribund because its rectangular structure, languages×wordgroups, was too inflexible and made adding data too difficult.  To this were added about 12,000 Old-Irish–Modern-Irish wordpairs from the Innéacs Nua-Ghaeilge don DIL which Kevin Scannell has put online as <a href="https://cadhan.com/droichead/">Droichead DIL</a>.  Bunadas also contains about 21,000 Manx words and wordforms and cognates (mostly Irish), a kind donation from Kevin Scannell, although these have not yet been fully integrated into the system.  All the other thousands of words have been added laboriously by hand, using resources such as <a href="https://geiriadur.ac.uk/">GPC</a> for Welsh and <a href="https://dil.ie/">DIL</a> for Irish, but most of them, especially for the non-Celtic languages, are copied from information in <a href="https://en.wiktionary.org">Wiktionary</a>.  This work continues, even though Bunadas is not currently (and never has been) a funded project.</div>

<div class=p>100,000 words is a good start, but is a drop in the ocean compared to all the words in all the languages of the world.  By adding more words to it, Bunadas could be turned into a useful resource for not just the Celtic languages, but lots of other languages too.  An obvious question is, if so much of the data is being copied over from Wiktionary, would it not be better to scrape data automatically from Wiktionary, since this is all in the public domain?</div>

<div class=p>This thought has already occurred to various very competent data scientists who have constructed facilities based on etymological data scraped from Wiktionary (facilities such as <a href="http://www.lexvo.com/">Lexvo</a>, <a href="https://www.rabbitique.com">Rabbitique</a> and <a href="https://cooljugator.com/etymology">Etymologeek</a>).  The results so far are useful, have more words and more languages than Bunadas has, but they have nothing to compare with the impressive, broad trees constructed by Bunadas.  The problem is that even though the etymological information contained in Wiktionary is generally very good and is improving by the week, the way it is structured is dire.  Wiktionary does not give unique ids to words, so links between words are based on spelling and can be broken if the spelling is changed.  Wiktionary does not distinguish properly between homographs.  It piles all the homographs, both between languages and within languages, onto the one webpage.  Wiktionary currently says, for example, that English <i><a href="https://en.wiktionary.org/wiki/bole">bole</a></i> ‘tree-trunk’ is from Old Norse <i><a href="https://en.wiktionary.org/wiki/bolr">bolr</a></i>, and that <i>bolr</i> is from PIE <i><a href="https://en.wiktionary.org/wiki/Reconstruction:Proto-Indo-European/b%CA%B0el-">bʰel-</a></i>, but it does not clarify which of the four different PIE roots <i>bʰel-</i></a> it means: the link just leads to the four of them.</div>

<div class=p>The long-term solution I believe lies in <a href="https://ordia.toolforge.org">Wikidata Lexical Data</a>.  The various Wikipedias, especially for smaller languages, are increasingly starting to automatically incorporate data from Wikidata, which is a common database of information of all kinds, and Wikidata Lexical Data is its extension into lexicography.  The words in Wikidata Lexical Data do have proper unique identifiers, ‘L’ numbers (such as <a href="https://ordia.toolforge.org/L6419">L6419</a> for English <i>hound</i>), corresponding to Wikidata’s ‘Q’ numbers.  The long-term aim, I believe, should be for etymological data to be shared in Wikidata Lexical Data, from where it can be accessed and used by all the various Wiktionaries, ru.wiktionary.org, fr.wiktionary.org, etc, as well as en.wiktionary.org, and used also by Bunadas and other such facilities.  Looking at Wikidata Lexical Data as it stands at present, though, it has a ways to go before it is ready for this.  It has not yet fully embraced the essential idea of separating out etymologically distinct homographs as distinct words.  It lacks the categorization of types of word components which Bunadas expresses using the ≽  ≻  ≫ symbols.  It looks as if it will be several years at least before Wikidata Lexical Data is ready to provide a foundation for the etymological information expressed in Bunadas and in the various Wiktionaries.  So in the meantime Bunadas can continue its present course, providing useful facilities especially for the Celtic languages, and exploring what will be possible and useful in an etymological facility for all languages once the data foundation is there.</div>

</div>
<ul class="smo-navlist">
<li><a href="/toisich/" title="Sabhal Mór Ostaig - prìomh dhuilleag (le dà bhriog)">SMO</a></li>
<li><a href="/teanga/" title="Goireasan iol-chànanach aig SMO">Teanga</a></li>
<li><a href="/teanga/bunadas/" title="Bunadas - stòras de fhacail cho-dhàimheil">Bunadas</a>
</ul>

<div class="smo-latha">2024-03-28 <a href="/~caoimhin/cpd.html">CPD</a></div>
</body>
</html>
END_HTML;

echo $HTML;
?>

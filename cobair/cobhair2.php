<!DOCTYPE html>
<html lang="gd">
<head>
    <meta charset="UTF-8">
    <title>Bunadas: Cobhair 2</title>
    <link rel="StyleSheet" href="/css/smo.css" type="text/css">
    <link rel="StyleSheet" href="snas.css" type="text/css">
</head>
<body style="font-size:125%;max-width:72em">

<ul class="smo-navlist">
<li><a href="/toisich/" title="Sabhal Mór Ostaig - prìomh dhuilleag (le dà bhriog)">SMO</a></li>
<li><a href="/teanga/" title="Goireasan iol-chànanach aig SMO">Teanga</a></li>
<li><a href="/teanga/bunadas/" title="Bunadas - stòras de fhacail cho-dhàimheil">Bunadas</a>
</ul>
<div class="smo-body-indent" style="max-width:72em">

<h1 class="smo">Bunadas: Help</h1>

<p>Bunadas is basically a network database of cognate words, not just words in modern languages but also words (both attested and reconstructed) in extinct languages, with the emphasis currently very much on the Celtic language family.  The links it records (together with a distance metric, 1 by default) are usually between close cognates, and it is left to the computer to walk the network
to find more distant cognates.</p>

<p>For convenience of editing, the links are not direct word-word links, but rather the words are grouped in cognate “clusters”, and all linking is of the form
word-cluster-word-cluster-word-...</p>

<p>Documentation is currently almost non-existant, unfortunately, so you just have to guess your way aound.  Hovering over things sometimes gives some “tooltip” help.  Hovering over a word shows the gloss (usally an English gloss) if one exists.</p>

<p>The editing facilities are good, and can be tried out by anyone on an out-of-date copy of the database simply by switching from “bunadas” to “bunTest” on the dropdown on the bottom-right of the main page.  Words can be dragged and dropped from group to group (on all browsers except Internet Explorer), grabbing the word by the language tag.  Straight drag copies the word, Ctrl+drag moves the word.  Clicking on a word takes you to the page for the word, which shows any clusters it is in, any alternative spellings, sometimes IPA, sometimes comments, etc.</p>

<p>The “Neighbourhood” button is probably the best thing about Bunadas.  It explores the network to find all the cognates of a word, and it shows them as a minimum spanning tree.  For clearest results, it is usually best to then click on the PIE root and then click “Neighbourhood” once more.  In the neighbourhood display, clicking the language tag for a word will close (or reopen) that branch of the tree to let you avoid clutter when you need to.</p>

<p>Here is a <a href="../fc.php?f=73833">wordcount</a> for each language which Bunadas deals with at present.</p>

<p style="margin:0.3em;border:1px solid #333;border-radius:0.6em;padding:0.5em;color:#333;font-size:80%">The idea of a tree of descendants can go “wrong”, or at least exhibit somewhat pathological behaviour.  Look at the <a href="/teanga/bunadas/fc.php?f=62995">neighbourhood tree for PIE tḱey</a>-, for example.  In all the descendants, you can at least see some reflex of the ‘tḱ’ from the PIE root - except in the branch near the bottom of the page derived from Latin sinō and pōnō.  The ‘s’ of sinō comes from the ‘tḱ’ of tḱey-, but this has disappeared in pōnō after prefixing by po-, and pōnō has absolutely nothing left of the original tḱey-; everything comes from prefixes and suffixes added later.  This is even more extreme by the time we reach English “compose”.  On each step of the way from “tḱey-” to “compose”, each word has clearly been derived from the word immediately before it, and yet no smidgeon of tḱey- can be found in the word “compose”. Fortunately, this situation does not occur often enough to be a big problem.</p>

<p>Bunadas has a multilingual interface, currently available in twelve languages,
<a href="/teanga/bunadas/?hl=br">Brezhoneg</a>,
<a href="/teanga/bunadas/?hl=da">Dansk</a>,
<a href="/teanga/bunadas/?hl=de">Deutsch</a>,
<a href="/teanga/bunadas/?hl=en">English</a>,
<a href="/teanga/bunadas/?hl=fr">Français</a>,
<a href="/teanga/bunadas/?hl=ga">Gaeilge</a>,
<a href="/teanga/bunadas/?hl=gd">Gàidhlig</a>,
<a href="/teanga/bunadas/?hl=it">Italiano</a>,
<a href="/teanga/bunadas/?hl=lt">Lietuvių</a>,
<a href="/teanga/bunadas/?hl=pt">Portuguès</a>,
<a href="/teanga/bunadas/?hl=sh">Srpskohrvatsk</a>, and
<a href="/teanga/bunadas/?hl=bg">Български</a>.
You can switch interface language via the dropdown at the top of any page, or you can link straight to the interface in any language by using a url with an ‘hl’ (host language) paramter such as <a href="/teanga/bunadas/?hl=en">https://www.smo.uhi.ac.uk/teanga/bunadas/?hl=en</a>.

<p>Send comments, ideas and questions to <a href="//www.smo.uhi.ac.uk/~caoimhin/">Caoimhín Ó Donnaíle</a>, caoimhin@smo.uhi.ac.uk</p>

</div>
<ul class="smo-navlist">
<li><a href="/toisich/" title="Sabhal Mór Ostaig - prìomh dhuilleag (le dà bhriog)">SMO</a></li>
<li><a href="/teanga/" title="Goireasan iol-chànanach aig SMO">Teanga</a></li>
<li><a href="/teanga/bunadas/" title="Bunadas - stòras de fhacail cho-dhàimheil">Bunadas</a>
</ul>

<div class="smo-latha">2019-09-04 <a href="/~caoimhin/cpd.html">CPD</a></div>
</body>
</html>

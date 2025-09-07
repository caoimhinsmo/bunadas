<?php
header('Content-type: text/css');

echo <<<EOD
@charset "UTF-8";

.fios { color:green; font-size:80%; }

div.f { display:inline-block; font-size:111%; }
div.f a:hover { text-decoration:none; }
div.f > div { float:left; }
div.f > div:nth-child(1) { min-width:2em; text-align:center; border:1px solid black; border-top-left-radius:5px; border-bottom-left-radius:5px; }
div.f > div:nth-child(2) { border:1px solid; border-left:0px; border-top-right-radius:5px; border-bottom-right-radius:5px; background-color:white; padding-left:1px; white-space:nowrap; }
div.f > div:nth-child(3) { font-size:40%; color:#333; }
div.f > div:nth-child(2) > a { padding:3px 3px 2px 3px; white-space:nowrap; font-size:90%; }

div.f[data-lang="ieur"] > div:nth-child(1) { background-color:#999; border-color:black; color:white; }
div.f[data-lang="celt"] > div:nth-child(1) { background-color:#6a6; border-color:green; color:white; }
div.f[data-lang="xtg"] > div:nth-child(1)  { background-color:green; border-color:green; color:#f99; }
div.f[data-lang="sga"] > div:nth-child(1),
div.f[data-lang="mga"] > div:nth-child(1),
div.f[data-lang="ga"] > div:nth-child(1),
div.f[data-lang="gd"] > div:nth-child(1),
div.f[data-lang="gv"] > div:nth-child(1)   { background-color:green; border-color:green; color:white; }
div.f[data-lang="brit"] > div:nth-child(1),
div.f[data-lang="owl"] > div:nth-child(1),
div.f[data-lang="wlm"] > div:nth-child(1),
div.f[data-lang="cy"] > div:nth-child(1),
div.f[data-lang="oco"] > div:nth-child(1),
div.f[data-lang="cnx"] > div:nth-child(1),
div.f[data-lang="kw"] > div:nth-child(1),
div.f[data-lang="obt"] > div:nth-child(1),
div.f[data-lang="xbm"] > div:nth-child(1),
div.f[data-lang="br"] > div:nth-child(1)   { background-color:green; border-color:green; color:yellow; }
div.f[data-lang="germ"] > div:nth-child(1),
div.f[data-lang="ang"] > div:nth-child(1),
div.f[data-lang="enm"] > div:nth-child(1),
div.f[data-lang="en"] > div:nth-child(1),
div.f[data-lang="sco"] > div:nth-child(1),
div.f[data-lang="wger"] > div:nth-child(1),
div.f[data-lang="nl"] > div:nth-child(1),
div.f[data-lang="de"] > div:nth-child(1)   { background-color:black; color:white; }
div.f[data-lang="non"] > div:nth-child(1),
div.f[data-lang="sv"] > div:nth-child(1),
div.f[data-lang="da"] > div:nth-child(1)   { background-color:black; color:pink; }
div.f[data-lang="la"] > div:nth-child(1),
div.f[data-lang="pt"] > div:nth-child(1),
div.f[data-lang="es"] > div:nth-child(1),
div.f[data-lang="ca"] > div:nth-child(1),
div.f[data-lang="fro"] > div:nth-child(1),
div.f[data-lang="frm"] > div:nth-child(1),
div.f[data-lang="fr"] > div:nth-child(1),
div.f[data-lang="it"] > div:nth-child(1)   { background-color:red; border-color:red; color:white; }
div.f[data-lang="slav"] > div:nth-child(1),
div.f[data-lang="uk"] > div:nth-child(1),
div.f[data-lang="ru"] > div:nth-child(1)   { background-color:blue; border-color:blue; color:white; }
div.f[data-lang="pl"] > div:nth-child(1),
div.f[data-lang="cs"] > div:nth-child(1)   { background-color:blue; border-color:blue; color:pink; }
div.f[data-lang="lt"] > div:nth-child(1)   { background-color:#56f; border-color:green; color:white; }
div.f[data-lang="grc"] > div:nth-child(1)  { background-color:#761; border-color:#871; color:white; }
div.f > div:nth-child(2) a:visited { color:blue; }
div.f > div:nth-child(2) a:hover   { color:yellow; }
div.f[data-lang="ieur"] > div:nth-child(2) { background-color:#fff; border-color:black; }
div.f[data-lang="celt"] > div:nth-child(2) { background-color:#fff; border-color:red; }
div.f[data-lang="xtg"] > div:nth-child(2)  { background-color:#fdd; border-color:red; }
div.f[data-lang="sga"] > div:nth-child(2)  { background-color:#dfd; border-color:green; }
div.f[data-lang="mga"] > div:nth-child(2)  { background-color:#afa; border-color:green; }
div.f[data-lang="ga"] > div:nth-child(2)   { background-color:#8f8; border-color:green; }
div.f[data-lang="gd"] > div:nth-child(2)   { background-color:#ddf; border-color:blue; }
div.f[data-lang="gv"] > div:nth-child(2)   { background-color:#fdd; border-color:red; }
div.f[data-lang="brit"] > div:nth-child(2) { background-color:#fed; border-color:red; }
div.f[data-lang="owl"] > div:nth-child(2)  { background-color:#fde; border-color:red; }
div.f[data-lang="wlm"] > div:nth-child(2)  { background-color:#fde; border-color:red; }
div.f[data-lang="cy"] > div:nth-child(2)   { background-color:#fce; border-color:red; }
div.f[data-lang="oco"] > div:nth-child(2)  { background-color:#fdc; border-color:red; }
div.f[data-lang="cnx"] > div:nth-child(2)  { background-color:#fec; border-color:red; }
div.f[data-lang="kw"] > div:nth-child(2)   { background-color:#ffa; border-color:red; }
div.f[data-lang="obt"] > div:nth-child(2)  { background-color:#eee; border-color:red; }
div.f[data-lang="xbm"] > div:nth-child(2)  { background-color:#dfdfdf; border-color:red; }
div.f[data-lang="br"] > div:nth-child(2)   { background-color:#ddd; border-color:red; }
div.f[data-lang="germ"] > div:nth-child(2) { background-color:#fff; border-color:red; }
div.f[data-lang="non"] > div:nth-child(2)  { background-color:#edf; border-color:#c00; }
div.f[data-lang="sv"] > div:nth-child(2)   { background-color:#fb7; border-color:#f00; }
div.f[data-lang="da"] > div:nth-child(2)   { background-color:#fad; border-color:#f00; }
div.f[data-lang="ang"] > div:nth-child(2)  { background-color:#ddb; border-color:#990; }
div.f[data-lang="enm"] > div:nth-child(2)  { background-color:#ee7; border-color:#990; }
div.f[data-lang="en"] > div:nth-child(2)   { background-color:#ff3; border-color:#220; }
div.f[data-lang="sco"] > div:nth-child(2)  { background-color:#ccf; border-color:blue; }
div.f[data-lang="wger"] > div:nth-child(2) { background-color:#fcd; border-color:blue; }
div.f[data-lang="nl"] > div:nth-child(2)   { background-color:#fbf; border-color:black; }
div.f[data-lang="de"] > div:nth-child(2)   { background-color:#fb5; border-color:black; }
div.f[data-lang="la"] > div:nth-child(2)   { background-color:#f6f6f6; border-color:#909; }
div.f[data-lang="fro"] > div:nth-child(2)  { background-color:#fdf; border-color:#64f; }
div.f[data-lang="frm"] > div:nth-child(2)  { background-color:#ddf; border-color:#5d4cff; }
div.f[data-lang="fr"] > div:nth-child(2)   { background-color:#bbf; border-color:#55f; }
div.f[data-lang="es"] > div:nth-child(2)   { background-color:#fcb; border-color:red; }
div.f[data-lang="pt"] > div:nth-child(2)   { background-color:#bfb; border-color:red; }
div.f[data-lang="ca"] > div:nth-child(2)   { background-color:#ffa; border-color:red; }
div.f[data-lang="it"] > div:nth-child(2)   { background-color:#bdb; border-color:red; }
div.f[data-lang="slav"] > div:nth-child(2) { background-color:#fff; border-color:grey; }
div.f[data-lang="pl"] > div:nth-child(2)   { background-color:#fee; border-color:red; }
div.f[data-lang="cs"] > div:nth-child(2)   { background-color:#fee; border-color:blue; }
div.f[data-lang="uk"] > div:nth-child(2)   { background-color:#efe; border-color:green; }
div.f[data-lang="ru"] > div:nth-child(2)   { background-color:#fff; border-color:blue; }
div.f[data-lang="lt"] > div:nth-child(2)   { background-color:#fff; border-color:green; }

option[value=ieur] { background-color:#888; color:white; }
option[value=celt] { background-color:#6a6; color:red; }
option[value=xtg]  { background-color:green; color:red; }
option[value=sga],
option[value=mga],
option[value=ga],
option[value=gd],
option[value=gv]   { background-color:green; color:white; }
option[value=brit],
option[value=owl],
option[value=wlm],
option[value=cy],
option[value=oco],
option[value=cnx],
option[value=kw],
option[value=br],
option[value=obt],
option[value=xbm]  { background-color:green; color:yellow; }
option[value=germ],
option[value=ang],
option[value=enm],
option[value=en],
option[value=sco],
option[value=wger],
option[value=nl],
option[value=de]   { background-color:black; color:white; }
option[value=non],
option[value=sv],
option[value=da]   { background-color:black; color:pink; }
option[value=la],
option[value=pt],
option[value=es],
option[value=ca],
option[value=fro],
option[value=frm],
option[value=fr],
option[value=it]   { background-color:red; color:white; }
option[value=slav],
option[value=pl],
option[value=cs],
option[value=uk],
option[value=ru]   { background-color:blue; color:white; }
option[value=lt]   { background-color:#65f; color:white; }
option[value=grc]  { background-color:#871; color:white; }
EOD;
?>

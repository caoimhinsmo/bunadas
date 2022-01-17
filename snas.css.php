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

div.f > div:nth-child(1):lang(ieur) { background-color:#888; border-color:black; color:white; }
div.f > div:nth-child(1):lang(celt) { background-color:#6a6; border-color:green; color:white; }
div.f > div:nth-child(1):lang(xtg)  { background-color:green; border-color:green; color:#f99; }
div.f > div:nth-child(1):lang(sga),
div.f > div:nth-child(1):lang(mga),
div.f > div:nth-child(1):lang(ga),
div.f > div:nth-child(1):lang(gd),
div.f > div:nth-child(1):lang(gv)   { background-color:green; border-color:green; color:white; }
div.f > div:nth-child(1):lang(brit),
div.f > div:nth-child(1):lang(owl),
div.f > div:nth-child(1):lang(wlm),
div.f > div:nth-child(1):lang(cy),
div.f > div:nth-child(1):lang(oco),
div.f > div:nth-child(1):lang(cnx),
div.f > div:nth-child(1):lang(kw),
div.f > div:nth-child(1):lang(obt),
div.f > div:nth-child(1):lang(xbm),
div.f > div:nth-child(1):lang(br)   { background-color:green; border-color:green; color:yellow; }
div.f > div:nth-child(1):lang(germ),
div.f > div:nth-child(1):lang(ang),
div.f > div:nth-child(1):lang(enm),
div.f > div:nth-child(1):lang(en),
div.f > div:nth-child(1):lang(sco),
div.f > div:nth-child(1):lang(wger),
div.f > div:nth-child(1):lang(de)   { background-color:black; color:white; }
div.f > div:nth-child(1):lang(non),
div.f > div:nth-child(1):lang(sv),
div.f > div:nth-child(1):lang(da)   { background-color:black; color:pink; }
div.f > div:nth-child(1):lang(la),
div.f > div:nth-child(1):lang(pt),
div.f > div:nth-child(1):lang(es),
div.f > div:nth-child(1):lang(ca),
div.f > div:nth-child(1):lang(fro),
div.f > div:nth-child(1):lang(frm),
div.f > div:nth-child(1):lang(fr),
div.f > div:nth-child(1):lang(it)   { background-color:red; border-color:red; color:white; }
div.f > div:nth-child(1):lang(slav),
div.f > div:nth-child(1):lang(be),
div.f > div:nth-child(1):lang(ru)   { background-color:blue; border-color:blue; color:white; }
div.f > div:nth-child(1):lang(pl),
div.f > div:nth-child(1):lang(cs)   { background-color:blue; border-color:blue; color:pink; }
div.f > div:nth-child(1):lang(lt)   { background-color:#56f; border-color:green; color:white; }
div.f > div:nth-child(1):lang(grc)  { background-color:#871; border-color:#871; color:white; }
div.f > div:nth-child(2):lang(ieur) { background-color:#fff; border-color:black; }
div.f > div:nth-child(2):lang(celt) { background-color:#fff; border-color:red; }
div.f > div:nth-child(2):lang(xtg)  { background-color:#fdd; border-color:red; }
div.f > div:nth-child(2):lang(sga)  { background-color:#dfd; border-color:green; }
div.f > div:nth-child(2):lang(mga)  { background-color:#afa; border-color:green; }
div.f > div:nth-child(2):lang(ga)   { background-color:#8f8; border-color:green; }
div.f > div:nth-child(2):lang(gd)   { background-color:#ddf; border-color:blue; }
div.f > div:nth-child(2):lang(gv)   { background-color:#fdd; border-color:red; }
div.f > div:nth-child(2):lang(brit) { background-color:#fed; border-color:red; }
div.f > div:nth-child(2):lang(owl)  { background-color:#fde; border-color:red; }
div.f > div:nth-child(2):lang(wlm)  { background-color:#fde; border-color:red; }
div.f > div:nth-child(2):lang(cy)   { background-color:#fce; border-color:red; }
div.f > div:nth-child(2):lang(oco)  { background-color:#fdc; border-color:red; }
div.f > div:nth-child(2):lang(cnx)  { background-color:#fec; border-color:red; }
div.f > div:nth-child(2):lang(kw)   { background-color:#ffa; border-color:red; }
div.f > div:nth-child(2):lang(obt)  { background-color:#eee; border-color:red; }
div.f > div:nth-child(2):lang(xbm)  { background-color:#dfdfdf; border-color:red; }
div.f > div:nth-child(2):lang(br)   { background-color:#ddd; border-color:red; }
div.f > div:nth-child(2):lang(germ) { background-color:#fff; border-color:red; }
div.f > div:nth-child(2):lang(non)  { background-color:#fdf; border-color:#c00; }
div.f > div:nth-child(2):lang(sv)   { background-color:#fb7; border-color:#f00; }
div.f > div:nth-child(2):lang(da)   { background-color:#fad; border-color:#f00; }
div.f > div:nth-child(2):lang(ang)  { background-color:#ddb; border-color:#990; }
div.f > div:nth-child(2):lang(enm)  { background-color:#bb9; border-color:#990; }
div.f > div:nth-child(2):lang(en)   { background-color:#ff9; border-color:#220; }
div.f > div:nth-child(2):lang(sco)  { background-color:#ccf; border-color:blue; }
div.f > div:nth-child(2):lang(wger)  { background-color:#f7b; border-color:blue; }
div.f > div:nth-child(2):lang(de)   { background-color:#f99; border-color:black; }
div.f > div:nth-child(2):lang(la)   { background-color:#f6f6f6; border-color:#909; }
div.f > div:nth-child(2):lang(fro)  { background-color:#fdf; border-color:#64f; }
div.f > div:nth-child(2):lang(frm)  { background-color:#ddf; border-color:#5d4cff; }
div.f > div:nth-child(2):lang(fr)   { background-color:#bbf; border-color:#55f; }
div.f > div:nth-child(2):lang(es)   { background-color:#fcb; border-color:red; }
div.f > div:nth-child(2):lang(pt)   { background-color:#bfb; border-color:red; }
div.f > div:nth-child(2):lang(ca)   { background-color:#ffa; border-color:red; }
div.f > div:nth-child(2):lang(it)   { background-color:#bdb; border-color:red; }
div.f > div:nth-child(2):lang(slav) { background-color:#fff; border-color:grey; }
div.f > div:nth-child(2):lang(pl)   { background-color:#fee; border-color:red; }
div.f > div:nth-child(2):lang(cs)   { background-color:#fee; border-color:blue; }
div.f > div:nth-child(2):lang(be)   { background-color:#efe; border-color:green; }
div.f > div:nth-child(2):lang(ru)   { background-color:#fff; border-color:blue; }
div.f > div:nth-child(2):lang(lt)   { background-color:#fff; border-color:green; }

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
option[value=be],
option[value=ru]   { background-color:blue; color:white; }
option[value=lt]   { background-color:#65f; color:white; }
option[value=grc]  { background-color:#871; color:white; }
EOD;
?>

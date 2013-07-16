<head>
<meta http-equiv="Content-Language" content="de">
<title>BZFS Start-script Builder</title>
	<style type="text/css">
			body { background-color: #B0C0F0; }
			h1 { color: #000080; }
			fieldset { border-color:#0410AE; padding:.5em; }
			a { font-size: 110%; text-decoration:none; display: block; color:#0000FF; background-color:#DAE2F6; }
			a:link.selected { display: block; color:#000000; background-color:#BED0EA; }
			a:visit.selected { display: block; color:#000000; background-color:#BED0EA; }
			a:hover.selected { display: block; color:#000000; background-color: #BED0EA; }
			a:link.unselected { display: block; color:#0000FF; background-color:#9FB5E0; }
			a:visit.unselected { display: block; color:#0000FF; background-color:#7090D0; }
			a:hover.unselected { display: block; color:#000000; background-color: #BED0EA; }
			a:link.build { display: block; color:#0000FF; background-color:#9FB5E0; }
			a:visit.build { display: block; color:#0000FF; background-color:#7090D0; }
			a:hover.build { display: block; color:#000000; background-color: #BED0EA; }
			legend { font-size: 110%; line-height: 1.5; }
			
			
.input{
font-weight:bold;
color:#0000FF;
background-color:#9FB5E0;
}
.input:hover{
font-weight:bold;
border-style:  3;
border-style:  ridge;
color:#000000; 
background-color: #BED0EA; 
}


		</style>
			<script language="javascript">

function show(layer_ref){

if (document.all) { //IS IE 4 or 5 (or 6 beta)
eval( "document.all." + layer_ref + ".style.visibility = 'visible'");
}
if (document.layers) { //IS NETSCAPE 4 or below
document.layers[layer_ref].visibility = 'visible';
}
if (document.getElementById && !document.all) {
maxwell_smart = document.getElementById(layer_ref);
maxwell_smart.style.visibility = 'visible';
}

if (document.all) { //IS IE 4 or 5 (or 6 beta)
eval( "document.all." + layer_ref + ".style.position = 'relative'");
}
if (document.layers) { //IS NETSCAPE 4 or below
document.layers[layer_ref].position = 'relative';
}
if (document.getElementById && !document.all) {
maxwell_smart = document.getElementById(layer_ref);
maxwell_smart.style.position = 'relative';
}

}

function hide(layer_ref){

if (document.all) { //IS IE 4 or 5 (or 6 beta)
eval( "document.all." + layer_ref + ".style.visibility = 'hidden'");
}
if (document.layers) { //IS NETSCAPE 4 or below
document.layers[layer_ref].visibility = 'hidden';
}
if (document.getElementById && !document.all) {
maxwell_smart = document.getElementById(layer_ref);
maxwell_smart.style.visibility = 'hidden';
}

if (document.all) { //IS IE 4 or 5 (or 6 beta)
eval( "document.all." + layer_ref + ".style.position = 'absolute'");
}
if (document.layers) { //IS NETSCAPE 4 or below
document.layers[layer_ref].position = 'absolute';
}
if (document.getElementById && !document.all) {
maxwell_smart = document.getElementById(layer_ref);
maxwell_smart.style.position = 'absolute';
}

}

</SCRIPT>

</head>
<?PHP
	function antis($text){
	return str_replace("\\\\","\\",$text);
	}
	$os=$_POST['os'];
	if($os == "Linux"){
	echo '<body onLoad="hide(\'win\');show(\'lin\');">';
	$vl="selected";
	} else {
	echo '<body onLoad="hide(\'lin\');show(\'win\');">';
		$v2="selected";
	}
	
?>
	
	
	<?PHP include('menu.php');?>
	<h1>BZFS Start-script Builder</h1>
	<form method="POST" action="start.php">
	<fieldset style="padding: 2"><legend>Config</legend><center>
<div align="center">
	<table border="0" width="100%" id="table1" style="border-collapse: collapse">
		<tr>
			<td style="width:200px;">OS:</td>
			<td><select size="1" name="os" style="width:200px;">
			<option value="Windows" onClick="hide('lin');show('win');" <? echo $v2;?>>Windows</option>
			<option value="Linux" onClick="hide('win');show('lin');" <? echo $vl;?>>Linux</option>
			</select></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="3"><hr></td>
		</tr>
		<tr>
			<td colspan="3">
			<div id="lin" name="lin">
			<table border="0" width="100%" id="table1" style="border-collapse: collapse">
			<tr>
			<td style="width:200px;">Standart CONFIG:</td>
			<td><input type="text" name="sconf" size="20" style="width:100%;" value="<? echo antis($_POST['sconf']);?>"></td>
			<td>z.B.: /home/destroyer/5000/4team_links.conf</td>
		</tr>
		<tr>
			<td>CONFIG Ordner:</td>
			<td><input type="text" name="confo" size="20" style="width:100%;" value="<? echo antis($_POST['confo']);?>"></td>
			<td>z.B.: /home/destroyer/5000/</td>
		</tr>
		<tr>
			<td>Server AdiminPW:</td>
			<td><input type="text" name="adminpw" size="20" style="width:100%;" value="<? echo antis($_POST['adminpw']);?>"></td>
			<td>z.B.: 123&nbsp;&nbsp; (fürs ausschalten des Server)</td>
		</tr>
		<tr>
			<td>Server Port:</td>
			<td><input type="text" name="port" size="20" style="width:100%;" value="<? echo antis($_POST['port']);?>"></td>
			<td>z.B.: 5000 (fürs ausschalten des Server)</td>
		</tr>
		<tr>
			<td>Server Log´s:</td>
			<td><input type="text" name="logo" size="20" style="width:100%;" value="<? echo antis($_POST['logo']);?>"></td>
			<td>z.B.: /home/destroyer/LOGS_5000/</td>
		</tr>
		<tr>
		<td colspan="3"><fieldset><legend align="left">Howto Use?</legend><font face="System">sh start conf.conf<br>or<br>sh start&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (for standart)</font></fieldset></td>
		</tr>
		</table>
		</div>	</td></tr>
		<tr>
			<td colspan="3">
			<div id="win" name="win">
			<table border="0" width="100%" id="table1" style="border-collapse: collapse">
<tr>
			<td style="width:200px;">Config</td>
			<td><input type="text" name="Config" size="20" style="width:100%;" value="<? echo antis($_POST['Config']);?>"></td>
			<td>z.B.: L:\BZFlag2.0.8\conf.conf</td>
		</tr>
		<tr>
			<td>Bzfs ordner</td>
			<td><input type="text" name="bzfs" size="20" style="width:100%;" value="<? echo antis($_POST['bzfs']);?>"></td>
			<td>z.B.: L:\BZFlag2.0.8\</td>
		</tr>
				<tr>
			<td>Server AdiminPW:</td>
			<td><input type="text" name="adminpw" size="20" style="width:100%;" value="<? echo antis($_POST['adminpw']);?>"></td>
			<td>z.B.: 123&nbsp;&nbsp; (fürs ausschalten des Server)</td>
		</tr>
		<tr>
			<td>Server Port:</td>
			<td><input type="text" name="port" size="20" style="width:100%;" value="<? echo antis($_POST['port']);?>"></td>
			<td>z.B.: 5000 (fürs ausschalten des Server)</td>
		</tr>
		<tr>
		<td colspan="3"><fieldset><legend align="left">Howto Use?</legend><font face="System">start.bat</font></fieldset></td>
		</tr>
		</table></div>
		</td>
		</tr>
	</table>
</div><center><input name="send" type="hidden" value="1"><input class="input" type="submit" value="Make" name="B1">
	</center>
	</center></fieldset>
	</form>
	<?PHP
	if($_POST['send'] == "1"){
	$os=$_POST['os'];
	$sconf=$_POST['sconf'];
	$confo=$_POST['confo'];
	$adminpw=$_POST['adminpw'];
	$port=$_POST['port'];
	$logo=$_POST['logo'];
	$bzfs=$_POST['bzfs'];
	$Config=$_POST['Config'];
	if(!$adminpw) $adminpw="Hir kommt das admin pw hin:)";
	
	if($os == "Linux"){
	$ooooooooooo = "";
	} else {
	$ooooooooooo = ".bat";
	}
echo '<fieldset ><legend align="left">'.$os.' output start'.$ooooooooooo.'</legend>';
echo '#Make @http://groupdb.links.bzflag.eu/<br>
';
if($os == "Linux"){
echo '#!/bin/bash <br>
clear<br>
if [ $1 ];then <br>
CONFIG=$1 <br>
else <br>
CONFIG="'.$sconf.'"
fi<br>
<br>
if [ -f $CONFIG ];then <br>
echo find $CONFIG ...<br>
else <br>
<br>
CONFIGa="'.$confo.'$CONFIG"<br>
<br>
if [ -f $CONFIGa ];then<br>
<br>
CONFIG="$CONFIGa"<br>
else<br>
echo $CONFIG nicht gefunden starte standart...<br>
CONFIG="'.$sconf.'"<br>
fi<br>
<br>
fi<br>
echo Starte: $CONFIG!<br>
echo The server restart... <br>
bzadmin MAPCHANGER:ADMIN@localhost:'.$port.' "/password '.$adminpw.'" "/say Please rejoin..." "/say Server load $CONFIG..." "/say The server restart..." "/shutdownserver"  <br>
echo wait 5 sec..<br>
sleep 1<br>
echo wait 4 sec..<br>
sleep 1<br>
echo wait 3 sec..<br>
sleep 1<br>
echo wait 2 sec..<br>
sleep 1<br>
echo wait 1 sec..<br>
sleep 1<br>
<br>
echo $CONFIG Is starting... <br>
bzfs -conf $CONFIG  2>&1 > '.$logo.'LOGFILE.`date +%d-%m-%Y-%H-%M` & <br>
echo bzfs -conf $CONFIG<br>
echo $CONFIG Is startet!<br>
<br>';

}
if($os == "Windows"){

echo '@echo off<br>
color 0a<br>
Title "Bzflag Server! Port '.$port.' conf.conf"<br>
echo Server:localhost:'.$port.'<br>
cd "'.antis($bzfs).'"<br>
<br>
bzadmin.exe  MAPCHANGER:ADMIN@localhost:'.$port.' "/password '.$adminpw.'" "/say Please rejoin..." "/say Server load '.antis($Config).'..." "/say The server restart..." "/shutdownserver"<br>
<br>
echo localhost:'.$port.' off<br>
<br>
bzfs -conf '.antis($Config).'<br>
cmd<br>';

}
echo '</fieldset>';
}
?>
	
<font face="System" size="2">Make by Links<br>
(c) by Links Clan</font>
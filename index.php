<head>
<meta http-equiv="Content-Language" content="de">
<title>BZFS groupdb Builder</title>
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
			
</head>
	<body>
	
	<?PHP include('menu.php');?>
	<h1>BZFS groupdb Builder</h1>
	<form method="POST" action="./"><?PHP
/*

*/
$perms = array("actionMessages","adminMessageReceive","adminMessageSend","antiban","antideregister","antikick","antikill","antipoll","antipollban","antipollkick","antipollkill","ban","banlist","countdown","date","endGame","flagHistory","flagMaster","flagMod","idlestats","info","kick","kill","lagwarn","listPerms","masterban","mute","playerList","poll","pollBan","pollFlagReset","pollKick","pollKill","pollSet","privateMessage","record","rejoin","removePerms","replay","requireIdentify","say","sendHelp","setAll","setPerms","setVar","shortBan","showOthers","shutdownServer","spawn","superkill","talk","unban","unmute","veto","viewReports","vote");

$permsb = array("Allowed to use /me","Player receives messages sent to the admin channel","Player may send messages to the admin channel","Player is immune to /ban","Player cannot be deregistered with /deregister","Player is immune to /kick","Player is immune to /kill","Player is immune to /poll","Player is immune banning with /poll","Player is immune kicking with /poll","Player is immune killing with /poll","Player may ban other players with /ban","Player may list active bans with /banlist","Player may issue /countdown","Player may query the date and time from the server with /date","Player may issue /endgame","Player allowed to use /flaghistory","Player allowed to use /flag give and /flag take","Player allowed to use /flag","Player allowed to use /idlestats","","Player allowed to use /kick","Player allowed to use /kill","Player may use /lagwarn to query or set lagwarn variable","","Player may use /masterban","Player may use /mute","Player may use /playerlist","Player may use /poll","Player may use /poll ban","Player may use /poll flagreset","Player may use /poll kick","Player may use /poll kill","Player may use /poll set","Player may send private messages with '.'","Player may use /record","Allows instant rejoin, regardless of _rejoinTime","May remove permissions from players","Player allowed to use /replay","Registered callsigns must identify before they are allowed to spawn","Player allowed to use /say","Player allowed to use /sendhelp","Grants all set* perms","May grant permissions to players","Player allowed ot use /set","Allowed bans with limited durations only","May use /showgroup on other callsigns","Player allowed to use /shutdownserver","Join game as a player. Observers don't need this permission.","Player allowed to use /superkill","Allows player to send messages.","Player may use /unban","Player may use /unmute","Player may use /veto","Player may use /viewreports","Player may use /vote");
?>
<script language="javascript"> 
		function getchecked(name){
		return document.getElementsByName(name)[0].checked;
		}
		function checkedo(name){
		var onoff = true;
		if(getchecked(name) == true)onoff=false;
		    document.getElementsByName(name)[0].checked = onoff;
		}
		</script>		
		<script language="javascript"> 
		function checkedall(){
		<?
		for($x=0;$x < count($perms);$x++){
		echo 'checkedo("'.$perms[$x].'");
		';
		}
		?>
		}
		
		function alloff(){
		<?
		for($x=0;$x < count($perms);$x++){
echo'document.getElementsByName("'.$perms[$x].'")[0].checked = false;
		';
		}
		?>
		 
		}
		</script>		
		<script language="javascript"> 
		function Observers(){
		checkedo("actionMessages");
		checkedo("adminMessageSend");
		checkedo("countdown");
		checkedo("poll");
		checkedo("pollKick");
		checkedo("pollSet");
		checkedo("pollKill");
		checkedo("pollFlagReset");
		checkedo("privateMessage");
		checkedo("talk");
		checkedo("vote");
		}
		
		function user(){
		Observers();
		checkedo("spawn");
		}
		
		function COPS(){
		user();
		checkedo("kick");
		checkedo("shortban");
		checkedo("banlist");
		}
		
		function USERADMIN(){
		COPS();
		checkedo("ban");
		checkedo("unban");
		}
		
		function ADMIN(){
		checkedall();
		checkedo("antiban");
		checkedo("antideregister");
		checkedo("antipoll");
		checkedo("antipollban");
		checkedo("antipollkick");
		checkedo("antipollkill");
		checkedo("flagMod");
		checkedo("masterban");
		checkedo("setPerms");
		checkedo("shutdownServer");
		checkedo("superkill");
		checkedo("veto");
		}
		 
</script>
<?PHP
echo '<fieldset style="padding: 2"><legend>Standart´s</legend><center>';
echo '<input class="input" type="button" value="ALL ON" name="B2" onclick="alloff();checkedall();" style="width:12.5%;">';
echo '<input class="input" type="button" value="ALL OFF" name="B2" onclick="alloff();" style="width:12.5%;">';
echo '<input class="input" type="button" value="Observers" name="B2" onclick="alloff();Observers();" style="width:12.5%;">';
echo '<input class="input" type="button" value="USER" name="B2" onclick="alloff();user();" style="width:12.5%;">';
echo '<input class="input" type="button" value="COPS" name="B2" onclick="alloff();COPS();" style="width:12.5%;">';
echo '<input class="input" type="button" value="USERADMIN" name="B2" onclick="alloff();USERADMIN();" style="width:12.5%;">';
echo '<input class="input" type="button" value="ADMIN" name="B2" onclick="alloff();ADMIN();" style="width:12.5%;">';
echo '<input class="input" type="button" value="OWNER" name="B2" onclick="alloff();checkedall();" style="width:12.5%;">';
echo '</center></fieldset>';
echo '<fieldset><legend align="left">groupdb</legend>';
echo '<table border="0" id="table1" style="border-collapse: collapse" width="100%>';
echo '<tr>
				<td nowrap align="left">Group Name:</td>
				<td nowrap align="left" colspan="4"><input type="text" name="groupname" size="20" value="'.$_POST['groupname'].'"></td>
			</tr>
			<tr>
				<td nowrap align="center" colspan="3"><hr></td>
			</tr>';
for($x=0;$x < count($perms);$x++){
$checked ="";
$permsname = $perms[$x];
if($_POST[$permsname] == "+") $checked ="checked";

		echo '	<tr>
				<td nowrap align="left">'.$permsname.'</td>
				<td nowrap align="center">
				<input type="checkbox" name="'.$permsname.'" value="+" '.$checked.'></td>
				<td nowrap align="left">'.$permsb[$x].'</td>
			</tr>';
			}
echo '<tr>
				<td nowrap align="center" colspan="3"><hr></td>
			</tr></table>';
echo '<center><input name="send" type="hidden" value="1"><input class="input" type="submit" value="Make" name="B1">
	</center>';
	
echo '</fieldset>';

if($_POST['send'] == "1"){
echo '<fieldset ><legend align="left">groupdb output</legend>';
echo '#Make @http://groupdb.links-clan.net/<br>
';
if($_POST['groupname']) echo $_POST['groupname'].': '; else  echo 'group.name: ';

for($x=0;$x < count($perms);$x++){
$permsname = $perms[$x];
$sets[$permsname] = "-";
if($_POST[$permsname] == "+") $sets[$permsname] = "+";
echo $sets[$permsname].strtoupper($permsname).' ';
}

	
echo '</fieldset>';
}
?>


	
	
</form>
<font face="System" size="2">Make by Links<br>
(c) by Links Clan</font>
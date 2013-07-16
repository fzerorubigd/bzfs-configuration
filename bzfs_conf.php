<html>
	<head>
		<title>BZFS Configuration Builder</title>
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
		<script language="JavaScript">
			var flags = new Array(	"V", "QT", "OO", "F", "MG", "GM", "L", "R", "SB",
						"IB", "ST", "T", "N", "SH", "SR", "SW", "PZ", "G",
						"JP", "ID", "CL", "US", "MQ", "SE", "TH", "BU", "WG",
                                                "CB", "LT", "RT", "FO", "RO", "M", "B", "JM", "WA", "NJ",
                                                "TR", "BY", "RC", "A" );

			function ableControls()
			{
				var mainform = document.forms["main"];
				var ctf = (mainform.game_style.value == "ctf") || (mainform.game_style.value == 'bc');
				var freeForAll = (mainform.game_style.value == "ffa");

				var rabbit = (mainform.game_style.value == "rc");
				mainform.world_type.disabled = mainform.game_style.value == "bc";
				if (mainform.world_type.disabled)
					mainform.world_type.checked = false;
				mainform.allow_teleporters.disabled = mainform.world_type.checked;
				mainform.world_file.disabled = !mainform.world_type.checked;
				mainform.randomly_orient_buildings.disabled = mainform.world_type.checked;
				mainform.random_building_heights.disabled = mainform.world_type.checked;
				mainform.density.disabled = (mainform.world_type.checked);
				mainform.rabbit_selection.disabled = !rabbit;
				var el = document.getElementById( "team_flags" );
				el.style.display = ctf ? "block" : "none";
				return true;
			}

			function buildConfig()
			{
				var d;
				var commentWritten;
				try
				{
					var console = window.open("","_blank","width=600,height=300,resizable");
					console.document.open("text/html");
					d = console.document;
					var mainform = document.forms["main"];

					d.writeln("<html><body><p>");
					d.writeln("#This is a bzfs configuration file.<br/>");
					d.writeln("#Copy and paste into a simple text file and name it like <i>sample.conf</i>.<br/>");
					d.writeln("#Use it like <code>bzfs -conf <i>sample.conf</i></code><br/><br/>");

					if (mainform.port.value != 5154) {
						d.writeln("#Initial port clients connect on<br/>");
						d.writeln("-p " + mainform.port.value + "<br/><br/>");
					}

					if (mainform.udp_required.checked) {
						d.writeln("#Require UDP<br/>");
						d.writeln("-requireudp<br/><br/>");
					}

					if (mainform.listen_interface.value.length > 0) {
						d.writeln("#Listen on this network interface<br/>");
						d.writeln("-i " + mainform.listen_interface.value + "<br/><br/>");
					}

					if (mainform.public_description.value.length > 0) {
						d.writeln("#Public description for the server<br/>");
						d.writeln("-public \"" + mainform.public_description.value + "\"<br/><br/>");
					}

					if (mainform.public_address.value.length > 0) {
						d.writeln("#Public network address for the server<br/>");
						d.writeln("-publicaddr " + mainform.public_address.value + "<br/><br/>");
					}

					if (mainform.public_list_server.value.length > 0) {
						d.writeln("#Public List server to register with<br/>")
						d.writeln("-publiclist " + mainform.public_list_server.value + "<br/><br/>");
					}

					if (mainform.server_message.value.length > 0) {
						d.writeln("#Server Message displayed when player joins<br/>");
						d.writeln("-srvmsg \"" + mainform.server_message.value + "\"<br/><br/>");
					}

					if (!mainform.respond_pings.checked) {
						d.writeln("#Server will not respond to pings<br/>");
						d.writeln("-q<br/><br/>");
					}

					if (mainform.sync_time.checked) {
						d.writeln("#Synchronize time of day on all clients<br/>");
						d.writeln("-synctime<br/><br/>");
					}

					if (mainform.lag_warn_time.value != 0) {
						d.writeln("#Lag Warning threshold time [ms]<br/>");
						d.writeln("-lagwarn " + mainform.lag_warn_time.value + "<br/><br/>");
					}

					if (mainform.lag_drop_time.value != 0) {
						d.writeln("#Drop player after this many lag warnings<br/>");
						d.writeln("-lagdrop " + mainform.lag_drop_time.value + "<br/><br/>");
					}

					if (mainform.ban_list.value.length > 0) {
						d.writeln("#Ban players based on ip addresses<br/>");
						d.writeln("-ban \"" + mainform.ban_list.value + "\"<br/><br/>");
					}

					if (mainform.ban_file.value.length > 0) {
						d.writeln("#Ban File<br/>");
						d.writeln("-banfile \"" + mainform.ban_file.value + "\"<br/><br/>");
					}

					if (mainform.idle_kick_time.value != 0) {
						d.writeln("#Idle Kick Threshold [s]<br/>");
						d.writeln("-maxidle " + mainform.idle_kick_time.value + "<br/><br/>");
					}

					if (!mainform.team_killers_die.checked) {
						d.writeln("#Player does not die when killing a teammate<br/>");
						d.writeln("-tk<br/><br/>");
					}

					if (mainform.team_killer_kick_ratio.value != 0) {
						d.writeln("#Team killer to wins percentage (1-100) above which player is kicked<br/>");
						d.writeln("-tkkr " + mainform.team_killer_kick_ratio.value + "<br/><br/>");
					}

					if (mainform.speed_kick.value != 112.5) {
						d.writeln("#Speed percent over normal speed to auto kick<br/>");
						d.writeln("-speedtol " + mainform.speed_kick.value + "<br/><br/>");
					}

					if (mainform.bad_words.value.length > 0) {
						d.writeln("#Bad Words filter file specification<br/>");
						d.writeln("-badwords " + mainform.bad_words.value + "<br/><br/>");
					}

					if (mainform.advertisement_message.value.length > 0) {
						d.writeln("#Message that is broadcast every 15 minutes<br/>");
						d.writeln("-admsg \"" + mainform.advertisement_message.value + "\"<br/><br/>");
					}


					if (mainform.print_score.checked) {
						d.writeln("#Write score to stdout whenever it changes<br/>");
						d.writeln("-printscore<br/><br/>");
					}

					if (mainform.disable_bots.checked) {
						d.writeln("#Disable robots and the ROGER autopilot<br/>");
						d.writeln("-disableBots<br/><br/>");
					}

					if (mainform.help_msgs.value.length > 0) {
						d.writeln("#Help Messages file specification<br/>");
						d.writeln("-helpmsg \"" + mainform.help_msgs.value + "\" about <br/><br/>");
					}

					if (mainform.time.value.length > 0) {
						d.writeln("#Set time limit on each game [s]<br/>");
						d.writeln("-time " + mainform.time.value + "<br/><br/>");
					}

					if (mainform.time_manual.checked) {
						d.writeln("#Countdown for timed games has to be started with /countdown<br/>");
						d.writeln("-timemanual<br/><br/>");
					}

					if (mainform.report_file.value.length > 0) {
						d.write("#File to which to write user reports<br/>");
						d.write("-reportfile \"" + mainform.report_file.value + "\"<br/><br/>");
					}

					if (mainform.report_pipe.value.length > 0) {
						d.write("#Program to which to pipe user reports<br/>");
						d.write("-reportpipe \"" + mainform.report_pipe.value + "\"<br/><br/>");
					}

					if (mainform.debug_level.value != 0) {
						d.writeln("#Increase debugging level<br/>");
						d.write("-");
						for (i = 0; i < mainform.debug_level.value; i++)
							d.write("d");
						d.writeln("<br/><br/>");
					}

					if (mainform.password.value.length > 0) {
						d.writeln("#Administrator's password<br/>");
						d.writeln("-password \"" + mainform.password.value + "\"<br/><br/>");
					}

					if (mainform.passdb.value.length > 0) {
						d.writeln("#File that stores user passwords<br/>");
						d.writeln("-passdb \"" + mainform.passdb.value + "\"<br/><br/>");
					}

					if (mainform.groupdb.value.length > 0) {
						d.writeln("#File that stores group privileges<br/>");
						d.writeln("-groupdb \"" + mainform.groupdb.value + "\"<br/><br/>");
					}

					if (mainform.userdb.value.length > 0) {
						d.writeln("#File that stores user privileges<br/>");
						d.writeln("-userdb \"" + mainform.userdb.value + "\"<br/><br/>");
					}

					if (mainform.filtercallsigns.checked) {
						d.writeln("#Filter callsigns to disallow inappropriate user names<br/>");
						d.writeln("-filterCallsigns<br/><br/>");
					}

					if (mainform.filterchat.checked) {
						d.writeln("#Filter chat messages<br/>");
						d.writeln("-filterChat<br/><br/>");
					}

					if (mainform.filtersimple.checked) {
						d.writeln("#Perform simple exact matches with the bad word list<br/>");
						d.writeln("-filterSimple<br/><br/>");
					}

					if (mainform.votepercent.value != 50.1) {
						d.writeln("#Percentage of players required to affirm a poll<br/>");
						d.writeln("-poll votePercentage=" + mainform.votepercent.value + "<br/><br/>");
					}

					if (mainform.votesrequired.value != 3) {
						d.writeln("#Minimum count of votes required to make a vote valid<br/>");
						d.writeln("-poll votesRequired=" + mainform.votesrequired.value + "<br/><br/>");
					}

					if (mainform.votetime.value != 60) {
						d.writeln("#maximum amount of time a player has to vote on a poll in seconds<br/>");
						d.writeln("-poll voteTime=" + mainform.votetime.value + "<br/><br/>");
					}

					if (mainform.vetotime.value != 20) {
						d.writeln("#Maximum seconds an authorized user has to cancel a poll<br/>");
						d.writeln("-poll vetoTime=" + mainform.vetotime.value + "<br/><br/>");
					}

					if (mainform.voterepeattime.value != 300) {
						d.writeln("#Minimum seconds required before a player may request another vote<br/>");
						d.writeln("-poll voteRepeatTime=" + mainform.voterepeattime.value + "<br/><br/>");
					}

					if (mainform.game_style.value == "ctf") {
						d.writeln("#Capture the flag game style<br/>");
						d.writeln("-c<br/><br/>");
					}
					else if (mainform.game_style.value == 'bc') {
						d.writeln("#Balanced world Capture the flag game style<br/>");
						d.writeln("-cr<br/><br/>");
					}
					else if (mainform.game_style.value == 'rc') {
						d.writeln("#Rabbit chase game style<br/>");
						d.writeln("-rabbit " + mainform.rabbit_selection.value + "<br/><br/>");
					}

					if (mainform.world_type.checked && (mainform.world_file.value.length > 0)) {
						d.writeln("#World file to load<br/>");
						d.writeln("-world \"" + mainform.world_file.value + "\"<br/><br/>");
					}

					if (!mainform.density.disabled && (mainform.density.value != 5)) {
						d.writeln("#Random world density<br/>");
						d.writeln("-density " + mainform.density.value + "<br/><br/>");
					}

					if (mainform.flags_on_buildings.checked) {
						d.writeln("#Flags can exist on buildings<br/>");
						d.writeln("-fb<br/><br/>");
					}

					if (mainform.spawn_on_buildings.checked) {
						d.writeln("#Tanks can spawn on buildings<br/>");
						d.writeln("-sb<br/><br/>");
					}

					if ((!mainform.randomly_orient_buildings.disabled) && mainform.randomly_orient_buildings.checked) {
						d.writeln("#Randomly orient buildings<br/>");
						d.writeln("-b<br/><br/>");
					}

					if ((!mainform.random_building_heights.disabled) && mainform.random_building_heights.checked) {
						d.writeln("#Random height buildings<br/>");
						d.writeln("-h<br/><br/>");
					}

					if (mainform.exit_one_game.checked) {
						d.writeln("#Serve one game and exit<br/>");
						d.writeln("-g<br/><br/>");
					}

					if (mainform.world_size.value != 400) {
						d.writeln("#World size in meters<br/>");
						d.writeln("-worldsize " + mainform.world_size.value + "<br/><br/>");
					}

					if (mainform.maximum_players.value != 40) {
						d.writeln("#Maximum number of players n, or max players per team n,n,n,n,n,n<br/>");
						d.writeln("-mp " + mainform.maximum_players.value + "<br/><br/>");
					}

					if (mainform.maximum_team_score.value > 0) {
						d.writeln("#Maximum Team score limit on game<br/>");
						d.writeln("-mts " + mainform.maximum_team_score.value + "<br/><br/>");
					}

					if (mainform.maximum_player_score.value > 0) {
						d.writeln("#Maximum Player score limit on game<br/>");
						d.writeln("-mps " + mainform.maximum_player_score.value + "<br/><br/>");
					}

					if (mainform.mandatory_superflags.value != 16) {
						d.writeln("#Number of superflags that must exist at all times<br/>");
						d.writeln("+s " + mainform.mandatory_superflags.value + "<br/><br/>");
					}

					if (mainform.allowed_superflags.value != 16) {
						d.writeln("#Number of superflags that may exist at any time<br/>");
						d.writeln("-s " + mainform.allowed_superflags.value + "<br/><br/>");
					}

					if ((!mainform.allow_teleporters.disabled) && mainform.allow_teleporters.checked) {
						d.writeln("#Allow random teleporters<br/>");
						d.writeln("-t<br/><br/>");
					}

					if (mainform.insert_antidote_flags.checked) {
						d.writeln("#Insert antidote superflags<br/>");
						d.writeln("-sa<br/><br/>");
					}

					if (mainform.teamflagzap_timeout.value != 30) {
						d.writeln("#Time to keep team flag around after last member has left [s]<br/>");
						d.writeln("-tftimeout " + mainform.teamflagzap_timeout.value + "<br/><br/>");
					}

					if (mainform.vars.value.length > 0) {
						d.writeln("#File that stores world parameter variable overrides<br/>");
						d.writeln("-vars \"" + mainform.vars.value + "\"<br/><br/>");
					}

					if (mainform.allow_jumping.checked) {
						d.writeln("#Tanks can jump<br/>");
						d.writeln("-j<br/><br/>");
					}

					if (mainform.allow_handicap.checked) {
						d.writeln("#Weaker tanks are given a handicap advantage<br/>");
						d.writeln("-handicap<br/><br/>");
					}

					if (mainform.allow_richochet.checked) {
						d.writeln("#Ordinance richochets<br/>");
						d.writeln("+r<br/><br/>");
					}

					if (mainform.max_concurrent_shots.value != 1) {
						d.writeln("#Maximum concurrent shots<br/>");
						d.writeln("-ms " + mainform.max_concurrent_shots.value + "<br/><br/>");
					}

					if (mainform.maximum_acceleration.checked) {
						d.writeln("#Limit Acceleration<br/>");
						d.writeln("-a<br/><br/>");
					}

					if (mainform.bad_flag_shake_time.value > 0) {
						d.writeln("#Bad Flag shake time [s]<br/>");
						d.writeln("-st " + mainform.bad_flag_shake_time.value + "<br/><br/>");
					}

					if (mainform.bad_flag_shake_wins.value > 0) {
						d.writeln("#Bad Flag shake wins<br/>");
						d.writeln("-sw " + mainform.bad_flag_shake_wins.value + "<br/><br/>");
					}

					if (mainform.auto_team.checked) {
						d.writeln("#Auto Team assignments<br/>");
						d.writeln("-autoTeam<br/><br/>");
					}

					if ((mainform.game_style.value == "ctf") || (mainform.game_style.value == "bc")) {
						commentWritten = false;
						if (mainform.extra_team_flag.value > 0) {
							if (!commentWritten) {
								d.writeln("#Extra Team flags<br/>");
								commentWritten = true;
							}
							d.write("+f team");
							if (mainform.extra_team_flag.value > 1)
								d.write("{"+mainform.extra_team_flag.value+"}");
							d.write(" ");
						}
						if (mainform.red_team_flag.value > 0) {
							if (!commentWritten) {
								d.writeln("#Extra Team flags<br/>");
								commentWritten = true;
							}
							d.write("+f R*");
							if (mainform.red_team_flag.value > 1)
								d.write("{"+mainform.red_team_flag.value+"}");
							d.write(" ");
						}
						if (mainform.green_team_flag.value > 0) {
							if (!commentWritten) {
								d.writeln("#Extra Team flags<br/>");
								commentWritten = true;
							}
							d.write("+f G*");
							if (mainform.green_team_flag.value > 1)
								d.write("{"+mainform.green_team_flag.value+"}");
							d.write(" ");
						}
						if (mainform.blue_team_flag.value > 0) {
							if (!commentWritten) {
								d.writeln("#Extra Team flags<br/>");
								commentWritten = true;
							}
							d.write("+f B*");
							if (mainform.blue_team_flag.value > 1)
								d.write("{"+mainform.blue_team_flag.value+"}");
							d.write(" ");
						}
						if (mainform.purple_team_flag.value > 0) {
							if (!commentWritten) {
								d.writeln("#Extra Team flags<br/>");
								commentWritten = true;
							}
							d.write("+f P*");
							if (mainform.purple_team_flag.value > 1)
								d.write("{"+mainform.purple_team_flag.value+"}");
							d.write(" ");
						}

						d.writeln("<br/><br/>");

					}

					commentWritten = false;
					if (mainform.good_mand_flag.value > 0) {
						if (!commentWritten) {
							d.writeln("#Mandatory flags<br/>");
							commentWritten = true;
						}

						d.write("+f good");
						if (mainform.good_mand_flag.value > 1)
							d.write("{"+mainform.good_mand_flag.value+"}");
						d.write(" ");
					}

					if (mainform.bad_mand_flag.value > 0) {
						if (!commentWritten) {
							d.writeln("#Mandatory flags<br/>");
							commentWritten = true;
						}
						d.write("+f bad");
						if (mainform.bad_mand_flag.value > 1)
							d.write("{"+mainform.bad_mand_flag.value+"}");
						d.write(" ");
					}

					for (var i = 0; i < flags.length; i++) {
						var el = flags[i].toLowerCase() + "_mand_flag";
						var cnt = mainform.elements[el].value;
						if (cnt > 0) {
							if (!commentWritten) {
								d.writeln("#Mandatory flags<br/>");
								commentWritten = true;
							}
							d.write("+f " + flags[i]);
							if (cnt > 1)
								d.write("{"+cnt+"}");
							d.write(" ");
						}
					}
					d.writeln("<br/><br/>");

					commentWritten = false;
					if (mainform.bad_forbid_flag.checked > 0) {
						if (!commentWritten) {
							d.writeln("#Forbidden flags<br/>");
							commentWritten = true;
						}
						d.write("-f bad ");
					}

					if (mainform.good_forbid_flag.checked > 0) {
						if (!commentWritten) {
							d.writeln("#Forbidden flags<br/>");
							commentWritten = true;
						}
						d.write("-f good ");
					}

					for (var i = 0; i < flags.length; i++) {
						var el = flags[i].toLowerCase() + "_forbid_flag";
						if (mainform.elements[el].checked) {
							if (!commentWritten) {
								d.writeln("#Forbidden flags<br/>");
								commentWritten = true;
							}
							d.write("-f " + flags[i] + " ");
						}
					}
					d.writeln("<br/><br/>");

					commentWritten = false;
					for (var i = 0; i < flags.length; i++) {
						var el = flags[i].toLowerCase() + "_limit_flag";
						if (mainform.elements[el].value.length > 0) {
							if (!commentWritten) {
								d.writeln("#Flag Shot Limits<br/>");
								commentWritten = true;
							}
							d.write("-sl " + flags[i] + " " + mainform.elements[el].value + " ");
						}
					}
					d.writeln("<br/><br/>");

					d.writeln("</p></body></html>");

					d.close();
				}
				catch (e)
				{
					d.writeln("Problem building configuration file: " + e.toString());
				}
				return;
			}

			var seldiv = "server";
			function changeDiv(newdiv)
			{
				var el;
				el = document.getElementById( seldiv );
				el.style.display = "none";
				el = document.getElementById( seldiv + "_ctl" );
				el.className = "unselected";
				el = document.getElementById( newdiv );
				el.style.display = "block";
				el = document.getElementById( newdiv + "_ctl" );
				el.className = "selected";
				seldiv = newdiv;
				return;
			}
		</script>
	</head>
	<body>
	<?PHP include('menu.php');?>
		<h1>BZFS Configuration Builder</h1>
		<form method="post" name="main" encType="multipart/form-data" onLoad="return ableControls()">
			<div id="controls" style="visibility: visible;">
				<table width="100%" align="center">
					<tr>
						<td align="center" width="16%"><a class="selected" id="server_ctl" href='javascript:changeDiv("server")'>Server</a></td>
						<td align="center" width="16%"><a class="unselected" id="administration_ctl" href='javascript:changeDiv("administration")'>Administration</a></td>
						<td align="center" width="16%"><a class="unselected" id="world_ctl" href='javascript:changeDiv("world")'>World</a></td>
						<td align="center" width="16%"><a class="unselected" id="tank_ctl" href='javascript:changeDiv("tank")'>Tank</a></td>
						<td align="center" width="16%"><a class="unselected" id="flag_ctl" href='javascript:changeDiv("flag")'>Flags</a></td>
						<td align="center" width="16%"><a class="build" href='javascript:buildConfig()'>Build Configuration</a></td>
					</tr>
				</table>
				<hr/>
			</div>
			<div id="server" style="display:block;">
				<fieldset>
					<legend>Server information</legend>
					<table width="100%">
						<tr>
							<td>Port</td>
							<td><input type="text" name="port" value="5154" size="30" title="Initial port clients connect on"/></td>
						</tr>
						<tr>
							<td>UDP Required</td>
							<td>
								<input type="checkbox" name="udp_required" title="Specify how UDP protocol is used"/>
							</td>
							<td>Listen On Interface</td>
							<td><input type="text" name="listen_interface" size="30" title="Listen on this network interface"/></td>
						</tr>
						<tr>
							<td>Public Description</td>
							<td><input type="text" name="public_description" size="30" title="Public description for the server"/></td>
							<td>Public Address</td>
							<td><input type="text" name="public_address" size="30" title="Public network address for the server"/></td>
						</tr>
						<tr>
							<td>Use Public List Server</td>
							<td><input type="text" name="public_list_server" size="30" title="Public List server to register with"/></td>
							<td>Server Message</td>
							<td><input type="text" name="server_message" size="30" title="Server Message displayed when player joins"/></td>
						</tr>
						<tr>
							<td>Respond to Pings</td>
							<td>
								<input type="checkbox" name="respond_pings" onClick="return ableControls()" title="Whether or not Server will respond to pings" CHECKED/>
							</td>
							<td>Synchronize Time</td>
							<td>
								<input type="checkbox" name="sync_time" title="Synchronize time of day on all clients"/>
							</td>
						</tr>
					</table>
				</fieldset>
			</div>
			<div id="administration" style="display:none;">
				<fieldset>
					<legend>Administration Information</legend>
					<table width="100%">
						<tr>
							<td>Lag Warn Time</td>
							<td><input type="text" name="lag_warn_time" value="0" size="30" title="Lag Warning threshold time [ms]"/></td>
							<td>Lag Warn Drop Count</td>
							<td><input type="text" name="lag_drop_time" value="0" size="30" title="Drop player after this many lag warnings"/></td>
						</tr>
						<tr span="2">
							<td>Ban List</td>
							<td colspan="3"><input type="text" name="ban_list" size="100" title="Ban players based on ip addresses"/></td>
						</tr>
						<tr span="2">
							<td>Ban File</td>
							<td colspan="3"><input type="file" name="ban_file" size="100" title="Ban file"/></td>
						</tr>
						<tr>
							<td>Idle Kick Time</td>
							<td><input type="text" name="idle_kick_time" value="0" size="30" title="Idle Kick Threshold [s]"/></td>
							<td>Team Killers Die</td>
							<td>
								<input type="checkbox" name="team_killers_die" title="Whether or not Player dies when killing a teammate" CHECKED/>
							</td>
						</tr>
						<tr>
							<td>Team Killer Kick Ratio</td>
							<td><input type="text" name="team_killer_kick_ratio" value="0" size="30" title="Team killer to wins percentage (1-100) above which player is kicked"/></td>
							<td> Excess Speed Kick Percent</td>
							<td><input type="text" name="speed_kick" value="112.5" size="30" title="Percent over normal speed to auto kick"/></td>
						</tr>
						<tr span="2">
							<td>Advertisement Message</td>
							<td colspan="3"><input type="text" name="advertisement_message" size="100" title="Message that is broadcast every 15 minutes"/></td>
						</tr>
						<tr>
							<td>Print Score</td>
							<td><input type="checkbox" name="print_score" title="Write score to stdout whenever it changes"/></td>
							<td>Help Message file</td>
							<td><input type="file" name="help_msgs" title="Show file contents on command '/help about'"/></td>
						</tr>
						<tr>
							<td>Time</td>
							<td><input type="text" name="time" size="30" title="Set time limit on each game [s]"/></td>
							<td>Time Manual</td>
							<td><input type="checkbox" name="time_manual" title="Whether or not Countdown for timed games has to be started with /countdown"/></td>
						</tr>
						<tr>
							<td>Report File</td>
							<td><input type="file" name="report_file" title="File in which to store user reports"/></td>
							<td>Report Pipe</td>
							<td><input type="file" name="report_pipe" title="Program to which to pipe user reports"/></td>
						<tr>
							<td>Debug Level</td>
							<td>
								<select name="debug_level" value="0" title="Set debugging level">
									<option value="0">None</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
								</select>
							</td>
							<td>Password</td>
							<td><input type="text" name="password" size="30" title="Administrator's password"/></td>
						</tr>
						<tr>
							<td>Bad Word File</td>
							<td><input type="file" name="bad_words" title="Bad Words filter file specification"/></td>
							<td>Password Database</td>
							<td><input type="file" name="passdb" title="File that stores user passwords"/></td>
						</tr>
						<tr>
							<td>Filter Callsigns</td>
							<td><input type="checkbox" name="filtercallsigns" title="Filter callsigns to disallow inappropriate user names"/></td>
							<td>User Privilege Database</td>
							<td><input type="file" name="userdb" title="File that stores user privileges"/></td>
						</tr>
						<tr>
							<td>Filter Chat</td>
							<td><input type="checkbox" name="filterchat" title="Filter chat messages"/></td>
							<td>Group Privilege Database</td>
							<td><input type="file" name="groupdb" title="File that stores group privileges"/></td>
						</tr>
						<tr>
							<td>Filter Simple</td>
							<td><input type="checkbox" name="filtersimple" title="Perform simple exact matches with the bad word list"/></td>
							<td>Disable bots and autopilot</td>
							<td><input type="checkbox" name="disable_bots" title="Disable robots and ROGER autopilot"/></td>
						</tr>
						<tr>
							<td>Vote Percent</td>
							<td><input type="text" name="votepercent" value="50.1" size="30" title="Percentage of players required to affirm a poll"/></td>
							<td>Votes Required</td>
							<td><input type="text" name="votesrequired" value="3" size="30" title="Minimum count of votes required to make a vote valid"/></td>
						</tr>
						<tr>
							<td>Vote Time</td>
							<td><input type="text" name="votetime" value="60" size="30" title="maximum amount of time a player has to vote on a poll in seconds"/></td>
							<td>Veto Time</td>
							<td><input type="text" name="vetotime" value="20" size="30" title="Maximum seconds an authorized user has to cancel a poll"/></td>
						</tr>
						<tr>
							<td>Vote Repeat Time</td>
							<td><input type="text" name="voterepeattime" value="300" size="30" title="Minimum seconds required before a player may request another vote"/></td>
						</tr>
					</table>
				</fieldset>
			</div>
			<div id="world" style="display:none;">
				<fieldset>
					<legend>World Information</legend>
					<table width="100%">
						<tr>
							<td>Game Style</td>
							<td>
								<select name="game_style" value="ffa" onClick="return ableControls()" title="Free for all or Capture the flag game style">
									<option value="ffa">Free for All</option>
									<option value="ctf">Capture the Flag</option>
									<option value="bc">Uniform world Capture the Flag</option>
									<option value="rc">Rabbit Chase</option>
								</select>
							</td>
							<td>World File</td>
							<td colspan="2">
								<input type="checkbox" name="world_type" onClick="return ableControls()" title="Whether or not the world is based on a file"/>
								<input type="file" name="world_file" title="World file to load" disabled/>
							</td>
						</tr>
						<tr>
							<td>Building Density</td>
							<td>
								<select name="density" value="5" title="Building Density" onClick="return ableControls()">
									<option value="5">5 (default)</option>
									<option value="0">0</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
								</select>
							</td>
							<td>Rabbit Selection</td>
							<td>
								<select name="rabbit_selection" value="score" title="Rabbit Selection Algorithm" disabled>
									<option value="score">Top Score</option>
									<option value="killer">Killer</option>
									<option value="random">Random</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Flags on Buildings</td>
							<td>
								<input type="checkbox" name="flags_on_buildings" title="Whether or not flags can exist on buildings"/>
							</td>
							<td>Spawn on Buildings</td>
							<td><input type="checkbox" name="spawn_on_buildings"  title="Tanks can spawn on buildings"/></td>
						</tr>
						<tr>
							<td>Randomly Orient Buildings</td>
							<td>
								<input type="checkbox" name="randomly_orient_buildings" title="Whether or not buildings will be rotated randomly"/>
							</td>
							<td>Randomly Building Heights</td>
							<td>
								<input type="checkbox" name="random_building_heights" title="Whether or not buildings will have random heights"/>
							</td>
						</tr>
						<tr>
							<td>Exit after one game</td>
							<td>
								<input type="checkbox" name="exit_one_game" title="Whether or not the server shuts down after one game"/>
							</td>
						</tr>
						<tr>
							<td>World Size</td>
							<td>
								<input type="text" name="world_size" value="400" size="30" title="Size in meters of world"/>
							</td>
							<td>Maximum Players</td>
							<td><input type="text" name="maximum_players" value="40" size="30" title="Maximum number of players who can join (n), or max players per team (n,n,n,n,n,n)"/></td>
						</tr>
						<tr>
							<td>Maximum Team Score</td>
							<td><input type="text" name="maximum_team_score" value="0" size="30" title="Team score at which the game will end"/></td>
							<td>Maximum Player Score</td>
							<td><input type="text" name="maximum_player_score" value="0" size="30" title="Player score at which the game will end"/></td>
						</tr>
						<tr>
							<td>Mandatory SuperFlags</td>
							<td><input type="text" name="mandatory_superflags" value="16" size="30" title="Number of flags that exist at all times"/></td>
							<td>Allowed SuperFlags</td>
							<td><input type="text" name="allowed_superflags" value="16" size="30" title="Maximum Number of flags that can exist at any time"/></td>
						</tr>
						<tr>
							<td>Allow Teleporters</td>
							<td>
								<input type="checkbox" name="allow_teleporters" title="Whether or not teleporters will be generated"/>
							</td>
							<td>Insert Antidote flags</td>
							<td>
								<input type="checkbox" name="insert_antidote_flags" title="Whether or not antidote flags will be inserted"/>
							</td>
						</tr>
						<tr>
							<td>Team flag zap timeout</td>
							<td><input type="text" name="teamflagzap_timeout" value="30" size="30" title="Time to keep team flag after all members have left [s]"/></td>
							<td>World Property Variables file</td>
							<td><input type="file" name="vars" title="File that stores world variable overrides"/></td>
						</tr>
					</table>
				</fieldset>
			</div>
			<div id="tank" style="display:none;">
				<fieldset>
					<legend>Tank information</legend>
					<table width="100%">
						<tr>
							<td>Allow Jumping</td>
							<td>
								<input type="checkbox" name="allow_jumping" title="Whether or not tanks can jump without a flag"/>
							</td>
							<td>Allow Richochet</td>
							<td>
								<input type="checkbox" name="allow_richochet" title="Whether or not bullets richochet without a flag"/>
							</td>
							<td>Provide Handicap Advantage</td>
							<td>
								<input type="checkbox" name="allow_handicap" title="Whether or not weaker tanks are given a handicap advantage"/>
							</td>
						</tr>
						<tr>
							<td>Max Concurrent Shots</td>
							<td><input type="text" name="max_concurrent_shots" value="1" size="30" title="Maximum number of shots a tank shoots at one time"/></td>
							<td>Maximum Acceleration</td>
							<td>
								<input type="checkbox" name="maximum_acceleration" title="Whether or not tank acceleration is limited"/>
							</td>
						</tr>
						<tr>
							<td>Bad Flag Shake Time</td>
							<td><input type="text" name="bad_flag_shake_time" value="0" size="30" title="Bad Flag shake time [s]"/></td>
							<td>Bad Flag Shake Wins</td>
							<td><input type="text" name="bad_flag_shake_wins" value="0" size="30" title="Bad Flag shake wins"/></td>
						</tr>
						<tr>
							<td>Auto Team Assignment</td>
							<td><input type="checkbox" name="auto_team" title="Server auto balances game by picking teams for joining players"/>
						</tr>
					</table>
				</fieldset>
			</div>
			<div id="flag" style="display:none;">
				<fieldset>
					<legend>Flag Information</legend>
					<div id="team_flags" style="display:none">
						<fieldset>
							<legend>Extra Team Flags</legend>
							<table width="100%">
								<tr>
									<td align="right">(team)</td><td><input type="text" name="extra_team_flag" value="0" size="3" title="Add extra team flags to all teams"/></td>
								</tr>
								<tr>
									<td align="right">Red</td><td><input type="text" name="red_team_flag" value="0" size="3" title="Add extra team flags to the red team"/></td>
									<td align="right">Green</td><td><input type="text" name="green_team_flag" value="0" size="3" title="Add extra team flags to the green team"/></td>
									<td align="right">Blue</td><td><input type="text" name="blue_team_flag" value="0" size="3" title="Add extra team flags to the blue team"/></td>
									<td align="right">Purple</td><td><input type="text" name="purple_team_flag" value="0" size="3" title="Add extra team flags to the purple team"/></td>
								</tr>
							</table>
						</fieldset>
					</div>
					<fieldset>
						<legend>Mandatory Flags</legend>
						<table width="100%">
							<tr>
								<td align="right">(good)</td><td><input type="text" id="gd" name="good_mand_flag" value="0" size="3" title="All good flags"/></td>
								<td align="right">(bad)</td><td><input type="text" id="bd" name="bad_mand_flag" value="0" size="3" title="All bad flags"/></td>
							</tr>
							<tr>
								<td align="right">(V)</td><td><input type="text" name="v_mand_flag" value="0" size="3" title="High Speed"/></td>
								<td align="right">(QT)</td><td><input type="text" name="qt_mand_flag" value="0" size="3" title="Quick Turn"/></td>
								<td align="right">(OO)</td><td><input type="text" name="oo_mand_flag" value="0" size="3" title="Oscillating Overthruster"/></td>
								<td align="right">(F)</td><td><input type="text" name="f_mand_flag" value="0" size="3" title="Rapid Shot"/></td>
								<td align="right">(MG)</td><td><input type="text" name="mg_mand_flag" value="0" size="3" title="Machine Gun"/></td>
								<td align="right">(GM)</td><td><input type="text" name="gm_mand_flag" value="0" size="3" title="Guided Missile"/></td>
							</tr>
							<tr>
								<td align="right">(L)</td><td><input type="text" name="l_mand_flag" value="0" size="3" title="Laser"/></td>
								<td align="right">(R)</td><td><input type="text" name="r_mand_flag" value="0" size="3" title="Richochet"/></td>
								<td align="right">(SB)</td><td><input type="text" name="sb_mand_flag" value="0" size="3" title="Super Bullet"/></td>
								<td align="right">(IB)</td><td><input type="text" name="ib_mand_flag" value="0" size="3" title="Invisible Bullet"/></td>
								<td align="right">(ST)</td><td><input type="text" name="st_mand_flag" value="0" size="3" title="Stealth"/></td>
								<td align="right">(T)</td><td><input type="text" name="t_mand_flag" value="0" size="3" title="Tiny"/></td>
							</tr>
							<tr>
								<td align="right">(N)</td><td><input type="text" name="n_mand_flag" value="0" size="3" title="Narrow"/></td>
								<td align="right">(SH)</td><td><input type="text" name="sh_mand_flag" value="0" size="3" title="Shield"/></td>
								<td align="right">(SR)</td><td><input type="text" name="sr_mand_flag" value="0" size="3" title="Steam Roller"/></td>
								<td align="right">(SW)</td><td><input type="text" name="sw_mand_flag" value="0" size="3" title="Shock Wave"/></td>
								<td align="right">(PZ)</td><td><input type="text" name="pz_mand_flag" value="0" size="3" title="Phantom Zone"/></td>
								<td align="right">(G)</td><td><input type="text" name="g_mand_flag" value="0" size="3" title="Genocide"/></td>
							</tr>
							<tr>
								<td align="right">(JP)</td><td><input type="text" name="jp_mand_flag" value="0" size="3" title="Jumping"/></td>
								<td align="right">(ID)</td><td><input type="text" name="id_mand_flag" value="0" size="3" title="Identify"/></td>
								<td align="right">(CL)</td><td><input type="text" name="cl_mand_flag" value="0" size="3" title="Cloaking"/></td>
								<td align="right">(US)</td><td><input type="text" name="us_mand_flag" value="0" size="3" title="Useless"/></td>
								<td align="right">(MQ)</td><td><input type="text" name="mq_mand_flag" value="0" size="3" title="Masquerade"/></td>
								<td align="right">(SE)</td><td><input type="text" name="se_mand_flag" value="0" size="3" title="Seer"/></td>
							</tr>
							<tr>
								<td align="right">(TH)</td><td><input type="text" name="th_mand_flag" value="0" size="3" title="Thief"/></td>
								<td align="right">(BU)</td><td><input type="text" name="bu_mand_flag" value="0" size="3" title="Burrow"/></td>
								<td align="right">(WG)</td><td><input type="text" name="wg_mand_flag" value="0" size="3" title="Wings"/></td>
								<td align="right">(A)</td><td><input type="text" name="a_mand_flag" value="0" size="3" title="Agility"/></td>
							</tr>
							<tr>
								<td align="right">(CB)</td><td><input type="text" name="cb_mand_flag" value="0" size="3" title="Colorblind"/></td>
								<td align="right">(&lt;-)</td><td><input type="text" name="lt_mand_flag" value="0" size="3" title="Left turn only"/></td>
								<td align="right">(-&gt;)</td><td><input type="text" name="rt_mand_flag" value="0" size="3" title="Right turn only"/></td>
								<td align="right">(FO)</td><td><input type="text" name="fo_mand_flag" value="0" size="3" title="Forward only"/></td>
								<td align="right">(RO)</td><td><input type="text" name="ro_mand_flag" value="0" size="3" title="Reverse only"/></td>
								<td align="right">(M)</td><td><input type="text" name="m_mand_flag" value="0" size="3" title="Momentum"/></td>
								<td align="right">(B)</td><td><input type="text" name="b_mand_flag" value="0" size="3" title="Blindness"/></td>
								<td align="right">(JM)</td><td><input type="text" name="jm_mand_flag" value="0" size="3" title="Jamming"/></td>
							</tr>
							<tr>
								<td align="right">(WA)</td><td><input type="text" name="wa_mand_flag" value="0" size="3" title="Wide Angle"/></td>
								<td align="right">(NJ)</td><td><input type="text" name="nj_mand_flag" value="0" size="3" title="No Jumping"/></td>
								<td align="right">(TR)</td><td><input type="text" name="tr_mand_flag" value="0" size="3" title="Trigger Happy"/></td>
								<td align="right">(BY)</td><td><input type="text" name="by_mand_flag" value="0" size="3" title="Bouncy"/></td>
								<td align="right">(RC)</td><td><input type="text" name="rc_mand_flag" value="0" size="3" title="Reverse Controls"/></td>
							</tr>
						</table>
					</fieldset>
					<fieldset>
						<legend>Forbidden Optional Flags</legend>
						<table width="100%">
							<tr>
								<td align="right">(bad)</td><td><input type="checkbox" name="bad_forbid_flag" title="All bad flags"/></td>
								<td align="right">(good)</td><td><input type="checkbox" name="good_forbid_flag" title="All good flags"/></td>
							</tr>
							<tr>
								<td align="right">(V)</td><td><input type="checkbox" name="v_forbid_flag" title="High Speed"/></td>
								<td align="right">(QT)</td><td><input type="checkbox" name="qt_forbid_flag" title="Quick Turn"/></td>
								<td align="right">(OO)</td><td><input type="checkbox" name="oo_forbid_flag" title="Oscillating Overthruster"/></td>
								<td align="right">(F)</td><td><input type="checkbox" name="f_forbid_flag" title="Rapid Shot"/></td>
								<td align="right">(MG)</td><td><input type="checkbox" name="mg_forbid_flag" title="Machine Gun"/></td>
							</tr>
							<tr>
								<td align="right">(GM)</td><td><input type="checkbox" name="gm_forbid_flag" title="Guided Missile"/></td>
								<td align="right">(L)</td><td><input type="checkbox" name="l_forbid_flag" title="Laser"/></td>
								<td align="right">(R)</td><td><input type="checkbox" name="r_forbid_flag" title="Richochet"/></td>
								<td align="right">(SB)</td><td><input type="checkbox" name="sb_forbid_flag" title="Super Bullet"/></td>
								<td align="right">(IB)</td><td><input type="checkbox" name="ib_forbid_flag" title="Invisible Bullet"/></td>
							</tr>
							<tr>
								<td align="right">(ST)</td><td><input type="checkbox" name="st_forbid_flag" title="Stealth"/></td>
								<td align="right">(T)</td><td><input type="checkbox" name="t_forbid_flag" title="Tiny"/></td>
								<td align="right">(N)</td><td><input type="checkbox" name="n_forbid_flag" title="Narrow"/></td>
								<td align="right">(SH)</td><td><input type="checkbox" name="sh_forbid_flag" title="Shield"/></td>
								<td align="right">(SR)</td><td><input type="checkbox" name="sr_forbid_flag" title="Steam Roller"/></td>
							</tr>
							<tr>
								<td align="right">(SW)</td><td><input type="checkbox" name="sw_forbid_flag" title="Shock Wave"/></td>
								<td align="right">(PZ)</td><td><input type="checkbox" name="pz_forbid_flag" title="Phantom Zone"/></td>
								<td align="right">(G)</td><td><input type="checkbox" name="g_forbid_flag" title="Genocide"/></td>
								<td align="right">(JP)</td><td><input type="checkbox" name="jp_forbid_flag" title="Jumping"/></td>
								<td align="right">(ID)</td><td><input type="checkbox" name="id_forbid_flag" title="Identify"/></td>
							</tr>
							<tr>
								<td align="right">(CL)</td><td><input type="checkbox" name="cl_forbid_flag" title="Cloaking"/></td>
								<td align="right">(US)</td><td><input type="checkbox" name="us_forbid_flag" title="Useless"/></td>
								<td align="right">(MQ)</td><td><input type="checkbox" name="mq_forbid_flag" title="Masquerade"/></td>
								<td align="right">(SE)</td><td><input type="checkbox" name="se_forbid_flag" title="Seer"/></td>
								<td align="right">(TH)</td><td><input type="checkbox" name="th_forbid_flag" title="Thief"/></td>
							</tr>
							<tr>
								<td align="right">(BU)</td><td><input type="checkbox" name="bu_forbid_flag" title="Burrow"/></td>
								<td align="right">(WG)</td><td><input type="checkbox" name="wg_forbid_flag" title="Wings"/></td>
								<td align="right">(A)</td><td><input type="checkbox" name="a_forbid_flag" title="Agility"/></td>
							</tr>
							<tr>
							<tr>
								<td align="right">(CB)</td><td><input type="checkbox" name="cb_forbid_flag" title="Colorblind"/></td>
								<td align="right">(&lt;-)</td><td><input type="checkbox" name="lt_forbid_flag" title="Left turn only"/></td>
								<td align="right">(-&gt;)</td><td><input type="checkbox" name="rt_forbid_flag" title="Right turn only"/></td>
								<td align="right">(FO)</td><td><input type="checkbox" name="fo_forbid_flag" title="Forward only"/></td>
								<td align="right">(RO)</td><td><input type="checkbox" name="ro_forbid_flag" title="Reverse only"/></td>
								<td align="right">(M)</td><td><input type="checkbox" name="m_forbid_flag" title="Momentum"/></td>
								<td align="right">(B)</td><td><input type="checkbox" name="b_forbid_flag" title="Blindness"/></td>
							</tr>
							<tr>
								<td align="right">(JM)</td><td><input type="checkbox" name="jm_forbid_flag" title="Jamming"/></td>
								<td align="right">(WA)</td><td><input type="checkbox" name="wa_forbid_flag" title="Wide Angle"/></td>
								<td align="right">(NJ)</td><td><input type="checkbox" name="nj_forbid_flag" title="No Jumping"/></td>
								<td align="right">(TR)</td><td><input type="checkbox" name="tr_forbid_flag" title="Trigger Happy"/></td>
								<td align="right">(BY)</td><td><input type="checkbox" name="by_forbid_flag" title="Bouncy"/></td>
								<td align="right">(RC)</td><td><input type="checkbox" name="rc_forbid_flag" title="Reverse Controls"/></td>
							</tr>
						</table>
					</fieldset>
					<fieldset>
						<legend>Flag Shot Limits</legend>
						<table width="100%">
							<tr>
								<td align="right">(V)</td><td><input type="text" size="5" name="v_limit_flag" title="High Speed"/></td>
								<td align="right">(QT)</td><td><input type="text" size="5" name="qt_limit_flag" title="Quick Turn"/></td>
								<td align="right">(OO)</td><td><input type="text" size="5" name="oo_limit_flag" title="Oscillating Overthruster"/></td>
								<td align="right">(F)</td><td><input type="text" size="5" name="f_limit_flag" title="Rapid Shot"/></td>
								<td align="right">(MG)</td><td><input type="text" size="5" name="mg_limit_flag" title="Machine Gun"/></td>
							</tr>
							<tr>
								<td align="right">(GM)</td><td><input type="text" size="5" name="gm_limit_flag" title="Guided Missile"/></td>
								<td align="right">(L)</td><td><input type="text" size="5" name="l_limit_flag" title="Laser"/></td>
								<td align="right">(R)</td><td><input type="text" size="5" name="r_limit_flag" title="Richochet"/></td>
								<td align="right">(SB)</td><td><input type="text" size="5" name="sb_limit_flag" title="Super Bullet"/></td>
								<td align="right">(IB)</td><td><input type="text" size="5" name="ib_limit_flag" title="Invisible Bullet"/></td>
							</tr>
							<tr>
								<td align="right">(ST)</td><td><input type="text" size="5" name="st_limit_flag" title="Stealth"/></td>
								<td align="right">(T)</td><td><input type="text" size="5" name="t_limit_flag" title="Tiny"/></td>
								<td align="right">(N)</td><td><input type="text" size="5" name="n_limit_flag" title="Narrow"/></td>
								<td align="right">(SH)</td><td><input type="text" size="5" name="sh_limit_flag" title="Shield"/></td>
								<td align="right">(SR)</td><td><input type="text" size="5" name="sr_limit_flag" title="Steam Roller"/></td>
							</tr>
							<tr>
								<td align="right">(SW)</td><td><input type="text" size="5" name="sw_limit_flag" title="Shock Wave"/></td>
								<td align="right">(PZ)</td><td><input type="text" size="5" name="pz_limit_flag" title="Phantom Zone"/></td>
								<td align="right">(G)</td><td><input type="text" size="5" name="g_limit_flag" title="Genocide"/></td>
								<td align="right">(JP)</td><td><input type="text" size="5" name="jp_limit_flag" title="Jumping"/></td>
								<td align="right">(ID)</td><td><input type="text" size="5" name="id_limit_flag" title="Identify"/></td>
							</tr>
							<tr>
								<td align="right">(CL)</td><td><input type="text" size="5" name="cl_limit_flag" title="Cloaking"/></td>
								<td align="right">(US)</td><td><input type="text" size="5" name="us_limit_flag" title="Useless"/></td>
								<td align="right">(MQ)</td><td><input type="text" size="5" name="mq_limit_flag" title="Masquerade"/></td>
								<td align="right">(SE)</td><td><input type="text" size="5" name="se_limit_flag" title="Seer"/></td>
								<td align="right">(TH)</td><td><input type="text" size="5" name="th_limit_flag" title="Thief"/></td>
							</tr>
							<tr>
								<td align="right">(BU)</td><td><input type="text" size="5" name="bu_limit_flag" title="Burrow"/></td>
								<td align="right">(WG)</td><td><input type="text" size="5" name="wg_limit_flag" title="Wings"/></td>
								<td align="right">(A)</td><td><input type="text" size="5" name="a_limit_flag" title="Agility"/></td>
							</tr>
							<tr>
							<tr>
								<td align="right">(CB)</td><td><input type="text" size="5" name="cb_limit_flag" title="Colorblind"/></td>
								<td align="right">(&lt;-)</td><td><input type="text" size="5" name="lt_limit_flag" title="Left turn only"/></td>
								<td align="right">(-&gt;)</td><td><input type="text" size="5" name="rt_limit_flag" title="Right turn only"/></td>
								<td align="right">(FO)</td><td><input type="text" size="5" name="fo_limit_flag" title="Forward only"/></td>
								<td align="right">(RO)</td><td><input type="text" size="5" name="ro_limit_flag" title="Reverse only"/></td>
								<td align="right">(M)</td><td><input type="text" size="5" name="m_limit_flag" title="Momentum"/></td>
								<td align="right">(B)</td><td><input type="text" size="5" name="b_limit_flag" title="Blindness"/></td>
							</tr>
							<tr>
								<td align="right">(JM)</td><td><input type="text" size="5" name="jm_limit_flag" title="Jamming"/></td>
								<td align="right">(WA)</td><td><input type="text" size="5" name="wa_limit_flag" title="Wide Angle"/></td>
								<td align="right">(NJ)</td><td><input type="text" size="5" name="nj_limit_flag" title="No Jumping"/></td>
								<td align="right">(TR)</td><td><input type="text" size="5" name="tr_limit_flag" title="Trigger Happy"/></td>
								<td align="right">(BY)</td><td><input type="text" size="5" name="by_limit_flag" title="Bouncy"/></td>
								<td align="right">(RC)</td><td><input type="text" size="5" name="rc_limit_flag" title="Reverse Controls"/></td>
							</tr>
						</table>
					</fieldset>
				</fieldset>
			</div>
		</form>
	</body>
</html>
<!--
 Local Variables: ***
 mode:HTML ***
 tab-width: 8 ***
 c-basic-offset: 2 ***
 indent-tabs-mode: t ***
 End: ***
 ex: shiftwidth=2 tabstop=8
-->

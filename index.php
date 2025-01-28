<?php
	$page = $_GET["blork"];
	if(! is_numeric($page)){
		$page = 0;
		$ofs_act = 1000;  // DO NOT CHANGE! hardcode ID offset for nice id string in URL - constant ID is important to share sidequests as URL
		$ofs_loc = 2025;  // DO NOT CHANGE! hardcode ID offset for nice id string in URL - constant ID is important to share sidequests as URL
		$ofs_qst = 1000;  // DO NOT CHANGE! hardcode ID offset for nice id string in URL - constant ID is important to share sidequests as URL
		// todo - random number

		$filepath = "./sidequests.json";
		$dbfile = fopen($filepath, "r") or die("[fix this websites broken file error]");
		$jsonstr = fread($dbfile, filesize($filepath));
		$jsondata = json_decode($jsonstr, true);
		fclose($dbfile);

		if(json_last_error() != JSON_ERROR_NONE) {
	    	echo("[fix this websites db error]");
	    } else {
			$len_act = sizeof($jsondata["activities"]);
			$len_loc = sizeof($jsondata["locations"]);
			$len_qst = sizeof($jsondata["sidequests"]);
			$add_loc = rand(0,1000) > 500; // 50% chance to generate location
			$add_qst = rand(0,1000) > 200; // 20% chance to generate additional sidequest

			$sel_act = rand(0,$len_act-1);
			if($sel_act == 27){  // this is the special case to take the next promt litterally
				$add_loc = 0;
				$add_qst = 0;
			}
			$sel_loc = 7; // default empty
			if($add_loc){
				$sel_loc = rand(0,$len_loc-1);
			}
			$sel_qst = 6; // default empty
			if($add_qst){
				$sel_qst = rand(0,$len_qst-1);
			}

			$blork = $ofs_act + $sel_act . $ofs_loc + $sel_loc . $ofs_qst + $sel_qst;

			header("Location: ./?blork=" . $blork);
			exit();
	    }

	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Sidequest Generator</title>
		<META name="description" content="Need a sidequest for your friend or perhaps your date? We got you!" />
		<meta property="og:title" content="Sidequest Generator"/>
		<meta property="og:site_name" content="For the most seasoned of adventurer."/>
		<link rel='stylesheet' href='./style.css' type='text/css' />
	</head>
	<body>
		<dl>
		<dt>Let's</dt>
		</dl>
		<dl>
			<?php
			$ofs_act = 1000;  // DO NOT CHANGE! hardcode ID offset for nice id string in URL - constant ID is important to share sidequests as URL
			$ofs_loc = 2025;  // DO NOT CHANGE! hardcode ID offset for nice id string in URL - constant ID is important to share sidequests as URL
			$ofs_qst = 1000;  // DO NOT CHANGE! hardcode ID offset for nice id string in URL - constant ID is important to share sidequests as URL

			$blork = $_GET["blork"];
			if(! is_numeric($blork)){
				$blork = 0;
			}
			$idlen = strlen($blork);
			if($idlen != 12){
				echo("<dt>find a something else...</dt>\n");
			} else {
				$filepath = "./sidequests.json";
				$dbfile = fopen($filepath, "r") or die("[fix this websites broken file error]");
				$jsonstr = fread($dbfile, filesize($filepath));
				$jsondata = json_decode($jsonstr, true);
				fclose($dbfile);
				$jsonstatus = json_last_error();
				if($jsonstatus != JSON_ERROR_NONE){
					switch (json_last_error()) {
				        case JSON_ERROR_DEPTH:
				            echo '[fix this websites overflow error]';
				        break;
				        case JSON_ERROR_STATE_MISMATCH:
				            echo '[fix this websites state mismatch error]';
				        break;
				        case JSON_ERROR_CTRL_CHAR:
				            echo '[fix this websites control sequence error]';
				        break;
				        case JSON_ERROR_SYNTAX:
				            echo '[fix this websites syntax error]';
				        break;
				        case JSON_ERROR_UTF8:
				            echo '[fix this websites encoding error]';
				        break;
				        default:
				            echo '[fix this websites error]';
				        break;
				    }
				} else {
					$activities = $jsondata["activities"];
					$locations = $jsondata["locations"];
					$sidequests = $jsondata["sidequests"];
					$len_act = sizeof($activities);
					$len_loc = sizeof($locations);
					$len_qst = sizeof($sidequests);

					$id_act = substr($blork,0,4) - $ofs_act;
					$id_loc = substr($blork,4,4) - $ofs_loc;
					$id_qst = substr($blork,8,4) - $ofs_qst;
					//echo("<dt>" . $id_act .".". $id_loc .".". $id_qst . "</dt>\n"); // debug
					if(($id_act < 0 or $id_loc < 0 or $id_qst < 0 or $id_act > $len_act-1 or $id_loc > $len_loc-1 or $id_qst > $len_qst-1)){
						echo("<dt>find a different idea...</dt>\n");
					} else {
						$activity = $activities[$id_act];
						$location = $locations[$id_loc];
						$sidequest = $sidequests[$id_qst];
						echo($activity . "<br>" . $location . "<br>" . $sidequest . "</dt>\n");
						echo("<dt>");
				    }
				}
		    }
			?>
		</dl>
		<div id='refresh'>
			<p> <a href='./'>This sounds too crazy for me.</a></p>
		</div>
	<!-- 
	<p> <a href='../books.php'>I want to buy your fucking books.</a>
</p> -->
<!--<div id="book">
	<a href="" target="_blank"><img border="0" img src="../book.jpg"></a>
</div>
<div id="order">
	<b>ASDF</b>
	<br>
</div>-->
<div id="famous">
	made by <a href="https://simonmartin.ch" target="_blank">Simon</a>.
</div>

</body>
</html>

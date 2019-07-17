<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
 
<!--- local 
<link rel="stylesheet" href="bootstrap-material-design-4.0.0-beta.4/css/bootstrap-material-design.min.css">
<script src="jquery-3.2.1.min.js"></script>
<script src="popper.js"></script>
<script src="bootstrap-material-design-4.0.0-beta.4/js/bootstrap-material-design.min.js"></script>
--->


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/4.0.2/bootstrap-material-design.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 
<?php
require('php-osc-master/src/OSCClient.php');
require('php-osc-master/src/OSCDatagram.php');
require('php-osc-master/src/OSCMessage.php');
use PhpOSC\OSCClient;
use PhpOSC\OSCMessage;

$get=[];
foreach($_GET as $k => $v) {
  $get[$k] = is_array($_GET[$k]) ? filter_var_array($_GET[$k], FILTER_SANITIZE_STRING) : filter_var($_GET[$k], FILTER_SANITIZE_STRING);
}

for ($i = 1; $i <= 3; $i++) {
	${'ip'.$i} = isset($get["ip".$i]) ? $get["ip".$i] : "";
	${'port'.$i} = isset($get["port".$i]) ? $get["port".$i] : "";
	${'custom'.$i} = isset($get["custom".$i]) ? $get["custom".$i] : "";
	if ( ${'ip'.$i}!="" && ${'port'.$i}!="" && ${'custom'.$i}!="" ) {
		$c = new OSCClient();
		$c->set_destination(${'ip'.$i},${'port'.$i});
		$m= new OSCMessage(${'custom'.$i});
		$c->send($m);
	}
}
if ($ip1=="") $ip1="127.0.0.1";
if ($port1=="") $port1="5000";
if ($custom1=="") $custom1="/millumin/action/stopColumn";

for ($i = 1; $i <= 5; $i++) {
	${'b_'.$i} ="";
	if ( isset($get["b_".$i]) ) {
		if ( $get["b_".$i] !="" ) {
				${'b_'.$i} = intval(  $get["b_".$i] );
		}
	}

	${'ip_'.$i} ="";
	if ( isset($get["ip_".$i]) ) {
		if ( $get["ip_".$i] !="" ) {
			${'ip_'.$i} = strval( $get["ip_".$i] );
		}
	}

	${'port_'.$i} ="";
	if ( isset($get["port_".$i]) ) {
		if ( $get["port_".$i] !="" ) {
			${'port_'.$i} = intval( $get["port_".$i] );
		}
	}
 	
 	if ($i==1 && $ip_1=="") {
		$ip_1 = "127.0.0.1";
  		$port_1 = "5000";
  	}	
 	
 	if ( ${'ip_'.$i}!="" && ${'port_'.$i}!="" ) {
	 	$c = new OSCClient();
	 	$c->set_destination(${'ip_'.$i},${'port_'.$i});
		$m= new OSCMessage("/millumin/action/launchColumn", array(${'b_'.$i}));
	  	$c->send($m);
	}
}
?>

<style>
body {
	padding-top: 1.5rem;
	padding-bottom: 1.5rem;
	background:black;
	color:lightgrey;
}
.header {
	padding-top: 6rem;
	padding-bottom: 4rem;
}
</style>
</head>

<body>
<div class="container">
      <div class="header clearfix">
        <nav>
          <!--ul class="nav nav-pills float-right">
            <li class="nav-item">
              <a class="nav-link active" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact</a>
            </li>
          </ul-->
        </nav>
        <h3 class="text-muted"><a href="index.php">millumin osc controller</a></h3>
      </div>

      <!--div class="jumbotron">
        <h1 class="display-3">Jumbotron heading</h1>
        <p class="lead"></p>
        <p><a class="btn btn-lg btn-success" href="#" role="button">Sign up today</a></p>
      </div-->

      <div class="row marketing">
        <div class="col-lg-6">

<form action="index.php" method="get" id="formgrid">
<table><tr>
<td>ip</td>
<td>port</td>
<td colspan="10"><a href="http://help.millumin.com/?page=01_tutorials_basics/interactions">column</a></td>
</tr>

<?php
for ($i = 1; $i <= 5; $i++) {
	echo '<tr><td><input type="text" name="ip_'.$i.'" value="'.${'ip_'.$i}.'" style="width:120px;color:grey;" class="form-control">';
	echo '</td><td><input type="text" name="port_'.$i.'" value="'.${'port_'.$i}.'" style="width:50px;color:grey;"  class="form-control"></td>';
	for ($ii = 1; $ii <= 10; $ii++) {
  		$btn= (${'b_'.$i}==$ii) ? $btn="btn-outline-danger" : $btn="btn-outline-primary";
  		echo '<td><input type="submit" class="btn '.$btn.'" name="b_'.$i.'" value="'.$ii.'"></td>';
	}
}
?>

</table>
</form>

<form action="index.php" method="get" id="formcustom">
<table><tr>
<td>ip</td>
<td>port</td>
<td><a href="https://github.com/anome/millumin-dev-kit/wiki/OSC-documentation">command</a></td>

<?php
for ($i = 1; $i <= 3; $i++) {
	echo '</tr><tr><td><input type="text"name="ip'.$i.'" value="'.${'ip'.$i}.'" style="width:120px;color:grey" class="form-control"></td>';
	echo '<td><input type="text" name="port'.$i.'" value="'.${'port'.$i}.'" style="width:50px;color:grey;"  class="form-control"></td>';
	echo '<td><input type="text" class="btn btn-outline-primary custom" id="custom'.$i.'" name="custom'.$i.'" value="'.${'custom'.$i}.'" style="width:400px;text-align:left;"></td></tr>';
}
?>

</table>
</form>

<br>


        </div>
      </div>



      <footer class="footer">
        <!--p>© company 2017</p-->
      </footer>

    </div>
</div>

<script>
var myformgrid = document.getElementById('formgrid');
myformgrid.addEventListener('submit', function () {
	var allInputs = myformgrid.getElementsByTagName('input');
	for (var i = 0; i < allInputs.length; i++) {
		var input = allInputs[i];
		if (input.name && !input.value) {
			input.name = '';
		}
	}
});

var myformcustom = document.getElementById('formcustom');
$('[id^=custom]').dblclick(
  function() { 
  	var allInputs = myformcustom.getElementsByTagName('input');
	for (var i = 0; i < allInputs.length; i++) {
		var input = allInputs[i];
		if (input.name && !input.value) {
			input.name = '';
		}
	}
	formcustom.submit();
  }
);
</script>


</body>
</html>
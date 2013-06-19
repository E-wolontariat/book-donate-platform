<div style="text-align:center;">
<table class="Logform" align="center">
	<tr class="trLogform">
		<td class="LogformL">
			Login lub email
		</td>
		<td class="LogformR">
			<input type="text" id="LogFlogin" name="LogFlogin" />
		</td>
	</tr>
	<tr class="trLogform">
		<td class="LogformL">
			Hasło
		</td>
		<td class="LogformR">
			<input type="password" id="LogFpass" name="LogFpass" />
		</td>
	</tr>
</table>
<form id="lFTS" method="post" action="http://<{websiteURL}>/index.php?action=3&pid=<{pid}>"> 
	<input type="hidden" name="FTSlogin" id="FTSlogin" />
	<input type="hidden" name="FTSpass" id="FTSpass" />
</form>
<script type="text/javascript">
function sendLogFrom(){
	tLogin = /^[0-9a-zA-Z]{3,20}$/;
	if(tLogin.test(document.getElementById("LogFlogin").value)){
		document.getElementById("LogFlogin").style.backgroundColor = '#6ef06e';
		document.getElementById("FTSlogin").value = document.getElementById("LogFlogin").value;
		document.getElementById("FTSpass").value = document.getElementById("LogFpass").value;
		document.getElementById("lFTS").submit();
	}
	else{
		document.getElementById("LogFlogin").style.backgroundColor = '#ff6e6e';
		alert("Błędny login");
	}
}
</script>
<img src="http://<{websiteURL}>/images/form_login.png" onClick="sendLogFrom()"/>
</div>
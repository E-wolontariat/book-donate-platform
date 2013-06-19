<div style="text-align:center;">
<table class="Rform" align="center">
	<tr class="trRformCaptcha">
		<td class="RformL">
			Treść komentarza			
		</td>
		<td class="RformR">
			<form id="rFormToSend" method="post" action="http://<{websiteURL}>/index.php?action=4&nid=<{nid}>">
				<textarea id="FTStext" name="FTStext" style="width: 246px; height: 64px;"></textarea>
			</form>
		</td>
	</tr>
</table>
<script type="text/javascript">
function sendCFrom(){
	document.getElementById("rFormToSend").submit();
}
</script>
<img src="http://<{websiteURL}>/images/form_add.png" alt="Dodaj" onClick="sendCFrom()"/>
</div>
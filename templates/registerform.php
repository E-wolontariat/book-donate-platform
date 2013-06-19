<div style="text-align:center;">
<table class="Rform" align="center">
	<tr class="trRform">
		<td class="RformL">
			Typ konta
		</td>
		<td class="RformR">
			<select
				id="RFtype" 
				name="RFtype"
				class="RegRofm" 
			>
				<option value="1">Instytucja potrzebująca książki</option>
				<option selected="selected" value="2">Osoba oddająca książki</option>
			</select>
		</td>
	</tr>
	<tr class="trRform">
		<td class="RformL">
			Login
		</td>
		<td class="RformR">
		<input type="text" id="RFlogin" name="RFlogin" />
		</td>
	</tr>
	<tr class="trRform">
		<td class="RformL">
			Adres emial
		</td>
		<td class="RformR">
		<input type="text" id="RFemail" name="RFemail" />
		</td>
	</tr>
	<tr class="trRform">
		<td class="RformL">
			Hasło
		</td>
		<td class="RformR">
		<input type="password" id="RFpass1" name="RFpass1" />
		</td>
	</tr>
	<tr class="trRform">
		<td class="RformL">
			Potwierdź hasło
		</td>
		<td class="RformR">
		<input type="password" id="RFpass2" name="RFpass2" />
		</td>
	</tr>
	<tr class="trRform">
		<td class="RformL">
			Imię i nazwisko lub nazwa instytucji
		</td>
		<td class="RformR">
		<input type="text" id="RFname" name="RFname" />
		</td>
	</tr>
	<tr class="trRform">
		<td class="RformL">
			Adres (opcjonalne)
		</td>
		<td class="RformR">
		<input type="text" id="RFadress" name="RFadress" value="" />
		</td>
	</tr>
	<tr class="trRform">
		<td class="RformL">
			Miasto
		</td>
		<td class="RformR">
		<input type="text" id="RFcity" name="RFcity" />
		</td>
	</tr>
	<tr class="trRform">
		<td class="RformL">
			Kod pocztowy
		</td>
		<td class="RformR">
		<input type="text" id="RFzipCode" name="RFzipCode" value="XX-XXX"/>
		</td>
	</tr>
	<tr class="trRform">
		<td class="RformL">
			Wojewódźtwo
		</td>
		<td class="RformR">
			<select
				id="RFregion" 
				name="RFregion"
				class="RegRofm" 
			>
				<option value="1">dolnośląskie</option>
				<option value="2">kujawsko-pomorskie</option>
				<option value="3">lubelskie</option>
				<option value="4">lubuskie</option>
				<option value="5">łódzkie</option>
				<option value="6">małopolskie</option>
				<option value="7">mazowieckie</option>
				<option value="8">opolskie</option>
				<option value="9">podkarpackie</option>
				<option value="10">podlaskie</option>
				<option value="11">pomorskie</option>
				<option value="12">śląskie</option>
				<option value="13">świętokrzyskie</option>
				<option value="14">warmińsko-mazurskie</option>
				<option value="15">wielkopolskie</option>
				<option value="16">zachodniopomorskie</option>
				<option value="17" selected="selected">Inne (inny kraj niż Polska)</option>
			</select>
		</td>
	</tr>
	<tr class="trRform">
		<td class="RformL">
			Kraj
		</td>
		<td class="RformR">
		<input type="text" id="RFcountry" name="RFcountry" value="Polska" />
		</td>
	</tr>
	<tr class="trRform">
		<td class="RformL">
			Telefon (opcjonalne)
		</td>
		<td class="RformR">
		<input type="text" id="RFphone" name="RFphone"  value="+48000000000"/>
		</td>
	</tr>
	<tr class="trRformCaptcha">
		<td class="RformL">
			Przepisz kod z obrazka </br>
			<img src="http://<{websiteURL}>/index.php?captcha=image&t=<?php echo time(); ?>" alt="captcha code" />
		</td>
		<td class="RformR">
		<input type="text" id="RFcaptcha" name="RFcaptch" />
		</td>
	</tr>
</table>
<form id="rFormToSend" method="post" action="http://<{websiteURL}>/index.php?action=1&pid=<{pid}>"> 
	<input type="hidden" name="FTSlogin" id="FTSlogin" />
	<input type="hidden" name="FTSpass" id="FTSpass" />
	<input type="hidden" name="FTSemail" id="FTSemail" />
	<input type="hidden" name="FTScaptcha" id="FTScaptcha" />
	<input type="hidden" name="FTSname" id="FTSname" />
	<input type="hidden" name="FTSadress" id="FTSadress" />
	<input type="hidden" name="FTScity" id="FTScity" />
	<input type="hidden" name="FTSphone" id="FTSphone" />
	<input type="hidden" name="FTSzipCode" id="FTSzipCode" />
	<input type="hidden" name="FTScountry" id="FTScountry" />
	<input type="hidden" name="FTStype" id="FTStype" />
	<input type="hidden" name="FTSregion" id="FTSregion" />
</form>
<script type="text/javascript">
function sendRegFrom(){
	tCaptcha = /^[0-9a-zA-Z]{1,}$/;
	if(tCaptcha.test(document.getElementById("RFcaptcha").value)){
		document.getElementById("RFcaptcha").style.backgroundColor = '#6ef06e';
		if(document.getElementById("RFpass1").value != "" && document.getElementById("RFpass2").value == document.getElementById("RFpass1").value){
			document.getElementById("RFpass1").style.backgroundColor = '#6ef06e';
			document.getElementById("RFpass2").style.backgroundColor = '#6ef06e';
			tMail = /^[0-9a-z_.-]+@+[0-9a-z.-ąćśńółęż]+\.[a-z0-9]{2,}$/;
			if(tMail.test(document.getElementById("RFemail").value)){
				document.getElementById("RFemail").style.backgroundColor = '#6ef06e';
				tLogin = /^[0-9a-zA-Z]{3,20}$/;
				if(tLogin.test(document.getElementById("RFlogin").value)){
					document.getElementById("RFlogin").style.backgroundColor = '#6ef06e';
					tCountry = /^[a-zA-ZąćśńółężŻŁÓĆŚŃĄĘ]+[a-ząćśńółę\s]{1,100}$/;
					if(tCountry.test(document.getElementById("RFcountry").value)){
						document.getElementById("RFcountry").style.backgroundColor = '#6ef06e';
						tZipC = /^[0-9-]{1,20}$/;
						if(tZipC.test(document.getElementById("RFzipCode").value)){
							document.getElementById("RFzipCode").style.backgroundColor = '#6ef06e';
							tName = /^[a-zA-z0-9_.-ąćśńółęŁÓĆŚŃĄĘ\s]{1,90}$/;
							if(tName.test(document.getElementById("RFname").value)){
								document.getElementById("RFname").style.backgroundColor = '#6ef06e';
								document.getElementById("FTSlogin").value = document.getElementById("RFlogin").value;
								document.getElementById("FTSpass").value = document.getElementById("RFpass1").value;
								document.getElementById("FTSemail").value = document.getElementById("RFemail").value;
								document.getElementById("FTScaptcha").value = document.getElementById("RFcaptcha").value;
								document.getElementById("FTSname").value = document.getElementById("RFname").value;
								document.getElementById("FTScountry").value = document.getElementById("RFcountry").value;
								document.getElementById("FTSphone").value = document.getElementById("RFphone").value;
								document.getElementById("FTSzipCode").value = document.getElementById("RFzipCode").value;
								document.getElementById("FTScity").value = document.getElementById("RFcity").value;
								document.getElementById("FTSadress").value = document.getElementById("RFadress").value;
								document.getElementById("FTStype").value = document.getElementById("RFtype").value;
								document.getElementById("FTSregion").value = document.getElementById("RFregion").value;
								document.getElementById("rFormToSend").submit();
							}
							else{
								document.getElementById("RFname").style.backgroundColor = '#ff6e6e';
								alert("Błędna nazwa. Można używać tylko liter, cyfr i - oraz .");
							}
						}
						else{
							document.getElementById("RFzipCode").style.backgroundColor = '#ff6e6e';
							alert("Błędny kod pocztowy. Można używać tylko cyfr i -");
						}
					}
					else{
						document.getElementById("RFcountry").style.backgroundColor = '#ff6e6e';
						alert("Błędny kraj. Można używać tylko małych liter oraz dużej litery na początku");
					}
				}
				else{
					document.getElementById("RFlogin").style.backgroundColor = '#ff6e6e';
					alert("Błędny login. Można używać tylko małych i dużych liter oraz cyfr. Minimum 3 znaki");
				}
			}
			else{
				document.getElementById("RFemail").style.backgroundColor = '#ff6e6e';
				alert("Błędny adres email. Adres nie może zawierać dużych liter");
			}
		}
		else{
			document.getElementById("RFpass2").style.backgroundColor = '#ff6e6e';
			document.getElementById("RFpass1").style.backgroundColor = '#ff6e6e';
			alert("Hasła nie zgadzają się");
		}
	}
	else{
		document.getElementById("RFcaptcha").style.backgroundColor = '#ff6e6e';
		alert("Błędny kod z obrazka");
	}			
}
</script>
<img src="http://<{websiteURL}>/images/form_register.png" alt="Zarejestruj" onClick="sendRegFrom()"/>
</div>
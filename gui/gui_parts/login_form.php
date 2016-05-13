<form class="user_form" method="post" style="box-shadow: 5px 5px 10px grey; margin-top: 2%;">
    <table style="width: 100%; height: 100%;border-collapse:collapse; background-color: white; border-radius: 15px">
	<tr>
	    <td style="">
		<div class="sign">
		    <div class="input-mask" style="width: 80%;margin-left: 9%">
			<input type="text" name="usr_txt_n" class="sign_text" id="usr_txt"/>
		    </div>
		    <div class="input-mask" style="width: 80%;margin-left: 9%">
			<input type="password" name="pas_txt_n" class="sign_text" id="pas_txt">
		    </div>
		</div>
		<div class="sign_buttons">
		    <div class="button-mask">
			<button type="submit" class="sign-button" id="prihl_btn">Prihlás</button>
		    </div>
		    <div class="button-mask">
			<button type="button" class="sign-button" style="border-bottom-left-radius: 15px;border-bottom-right-radius: 15px">Registruj</button>
		    </div>
		</div>
		<div class="sign">
		    <div><fb:login-button scope="public_profile,email" onlogin="checkLoginState();"></fb:login-button></div>
		</div>
		<div style="text-align: center;" >
		    <div class="close-user_form" onclick="toggleLogFrm()">x</div>
		</div>
	    </td>
	</tr>
    </table>
</form>
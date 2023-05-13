<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */

//one css for all system.auth.* forms
$APPLICATION->SetAdditionalCSS("/bitrix/css/main/system.auth/flat/style.css");

?>
<div class="page cart">
	<div class="container">
		<div class="row">
			<?$APPLICATION->IncludeComponent(
				"bitrix:breadcrumb",
				"breadcrump_new",
				Array(
					"PATH" => "",
					"SITE_ID" => "s1",
					"START_FROM" => "0"
				)
			);?>
			<h1>Востановить пароль</h1>
			<div class="main-lk">
				<div class="wr-main-lk">
					<div class="col-lg-5 order">
						<br/>
						<br/>
						<?
						if(!empty($arParams["~AUTH_RESULT"])):
							$text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]);
						?>
							<div class="alert <?=($arParams["~AUTH_RESULT"]["TYPE"] == "OK"? "alert-success":"alert-danger")?>"><?=nl2br(htmlspecialcharsbx($text))?></div>
						<?endif?>
						
							<h3 class="bx-title"><?=GetMessage("AUTH_GET_CHECK_STRING")?></h3>
						
							<p class="bx-authform-content-container"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></p>
						
							<form name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
						<?if($arResult["BACKURL"] <> ''):?>
								<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
						<?endif?>
								<input type="hidden" name="AUTH_FORM" value="Y">
								<input type="hidden" name="TYPE" value="SEND_PWD">
						
								<div class="input">
									<label for="">
										<div class="bx-authform-label-container"><?echo GetMessage("AUTH_LOGIN_EMAIL")?></div>
										
									</label>
									<input type="text" name="USER_LOGIN" maxlength="255" value="<?=$arResult["USER_LOGIN"]?>" />
										<input type="hidden" name="USER_EMAIL" />
									<label for="">
										<div class="bx-authform-note-container"><?echo GetMessage("forgot_pass_email_note")?></div>
									</label>
								</div>
						
						<?if($arResult["PHONE_REGISTRATION"]):?>
								<div class="input">
									<label for="">
										<div class="bx-authform-label-container"><?echo GetMessage("forgot_pass_phone_number")?></div>
										
									</label>
									<input type="text" name="USER_PHONE_NUMBER" maxlength="255" value="<?=$arResult["USER_PHONE_NUMBER"]?>" />
									<label for="">
										<div class="bx-authform-note-container"><?echo GetMessage("forgot_pass_phone_number_note")?></div>
									</label>
								</div>
						<?endif?>
						
						<?if ($arResult["USE_CAPTCHA"]):?>
								<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
						
								<div class="input">
									<label for="">
										<div class="bx-authform-label-container"><?echo GetMessage("system_auth_captcha")?></div>
										<div class="bx-captcha"><img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /></div>
									</label>
									<input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off"/>
								</div>
						
						<?endif?>
								<div class="link-b">
									<a href="<?=$arResult["AUTH_AUTH_URL"]?>"><b><?=GetMessage("AUTH_AUTH")?></b></a>
								</div>
								<input type="submit" class="btn-c-lilac" name="send_account_info" value="<?=GetMessage("AUTH_SEND")?>" />
							</form>
						
						</div>
						
						<script type="text/javascript">
						document.bform.onsubmit = function(){document.bform.USER_EMAIL.value = document.bform.USER_LOGIN.value;};
						document.bform.USER_LOGIN.focus();
						</script>
					</div>
				</div>
		</div>
	</div>
</div>

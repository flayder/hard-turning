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

if($arResult["PHONE_REGISTRATION"])
{
	CJSCore::Init('phone_auth');
}
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
			<h1><?=GetMessage("AUTH_CHANGE_PASSWORD")?></h1>
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
						
						<?if($arResult["SHOW_FORM"]):?>
						
						
							<form method="post" action="<?=$arResult["AUTH_URL"]?>" name="bform">
						<?if ($arResult["BACKURL"] <> ''): ?>
								<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
						<? endif ?>
								<input type="hidden" name="AUTH_FORM" value="Y">
								<input type="hidden" name="TYPE" value="CHANGE_PWD">
						
						<?if($arResult["PHONE_REGISTRATION"]):?>
								<div class="input">
									<label for="">
										<div class="bx-authform-label-container"><?echo GetMessage("change_pass_phone_number")?></div>
									</label>
									<input type="text" value="<?=htmlspecialcharsbx($arResult["USER_PHONE_NUMBER"])?>" disabled="disabled" />
										<input type="hidden" name="USER_PHONE_NUMBER" value="<?=htmlspecialcharsbx($arResult["USER_PHONE_NUMBER"])?>" />
								</div>
								<div class="input">
									<label for="">
										<div class="bx-authform-label-container"><?echo GetMessage("change_pass_code")?></div>
									</label>
									<input type="text" name="USER_CHECKWORD" maxlength="255" value="<?=$arResult["USER_CHECKWORD"]?>" autocomplete="off" />
								</div>
						<?else:?>
								<div class="input">
									<label for="">
										<div class="bx-authform-label-container"><?=GetMessage("AUTH_LOGIN")?></div>
									</label>
									<input type="text" name="USER_LOGIN" maxlength="255" value="<?=$arResult["LAST_LOGIN"]?>" />
								</div>
						<?
							if($arResult["USE_PASSWORD"]):
						?>
								<div class="input">
									<label for=""><div class="bx-authform-label-container"><?echo GetMessage("system_change_pass_current_pass")?></div></label>
									<div class="bx-authform-input-container">
						<?if($arResult["SECURE_AUTH"]):?>
										<div class="bx-authform-psw-protected" id="bx_auth_secure_pass" style="display:none"><div class="bx-authform-psw-protected-desc"><span></span><?echo GetMessage("AUTH_SECURE_NOTE")?></div></div>
						
						<script type="text/javascript">
						document.getElementById('bx_auth_secure_pass').style.display = '';
						</script>
						<?endif?>
										<input type="password" name="USER_CURRENT_PASSWORD" maxlength="255" value="<?=$arResult["USER_CURRENT_PASSWORD"]?>" autocomplete="new-password" />
									</div>
								</div>
						<?
							else:
						?>
								<div class="input">
									<label for="">
										<div class="bx-authform-label-container"><?=GetMessage("AUTH_CHECKWORD")?></div>
									</label>
									<input type="text" name="USER_CHECKWORD" maxlength="255" value="<?=$arResult["USER_CHECKWORD"]?>" autocomplete="off" />
								</div>
						<?
							endif;
						?>
						<?endif?>
						
								<div class="input">
									<label for="">
										<div class="bx-authform-label-container"><?=GetMessage("AUTH_NEW_PASSWORD_REQ")?></div>
									</label>

						<?if($arResult["SECURE_AUTH"]):?>
										<div class="bx-authform-psw-protected" id="bx_auth_secure" style="display:none"><div class="bx-authform-psw-protected-desc"><span></span><?echo GetMessage("AUTH_SECURE_NOTE")?></div></div>
						
						<script type="text/javascript">
						document.getElementById('bx_auth_secure').style.display = '';
						</script>
						<?endif?>
										<input type="password" name="USER_PASSWORD" maxlength="255" value="<?=$arResult["USER_PASSWORD"]?>" autocomplete="new-password" />
								</div>
						
								<div class="input">
									<label for="">
										<div class="bx-authform-label-container"><?=GetMessage("AUTH_NEW_PASSWORD_CONFIRM")?></div>
									</label>
						<?if($arResult["SECURE_AUTH"]):?>
										<div class="bx-authform-psw-protected" id="bx_auth_secure_conf" style="display:none"><div class="bx-authform-psw-protected-desc"><span></span><?echo GetMessage("AUTH_SECURE_NOTE")?></div></div>
						
						<script type="text/javascript">
						document.getElementById('bx_auth_secure_conf').style.display = '';
						</script>
						<?endif?>
										<input type="password" name="USER_CONFIRM_PASSWORD" maxlength="255" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" autocomplete="new-password" />
								</div>
						
						<?if ($arResult["USE_CAPTCHA"]):?>
								<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
						
								<div class="input">
									<label for="">
										<div class="bx-authform-label-container"><?echo GetMessage("system_auth_captcha")?></div>
									</label>
									<div class="bx-captcha"><img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /></div>
									<input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off"/>
								</div>
						
						<?endif?>
								<div class="input" style="width: 100%;">
									<label for="">
										
										<div class="bx-authform-description-container">
										<?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?>
									</div>
									</label>
								</div>
								<div class="link-b">
									<a href="<?=$arResult["AUTH_AUTH_URL"]?>"><b><?=GetMessage("AUTH_AUTH")?></b></a>
									
								</div>
								<input type="submit" class="btn-c-lilac" name="change_pwd" value="<?=GetMessage("AUTH_CHANGE")?>" />
						
								
						
							</form>
						
						<script type="text/javascript">
						document.bform.USER_CHECKWORD.focus();
						</script>
						
						<?if($arResult["PHONE_REGISTRATION"]):?>
						
						<script type="text/javascript">
						new BX.PhoneAuth({
							containerId: 'bx_chpass_resend',
							errorContainerId: 'bx_chpass_error',
							interval: <?=$arResult["PHONE_CODE_RESEND_INTERVAL"]?>,
							data:
								<?=CUtil::PhpToJSObject([
									'signedData' => $arResult["SIGNED_DATA"]
								])?>,
							onError:
								function(response)
								{
									var errorNode = BX('bx_chpass_error');
									errorNode.innerHTML = '';
									for(var i = 0; i < response.errors.length; i++)
									{
										errorNode.innerHTML = errorNode.innerHTML + BX.util.htmlspecialchars(response.errors[i].message) + '<br />';
									}
									errorNode.style.display = '';
								}
						});
						</script>
						
						<div class="alert alert-danger" id="bx_chpass_error" style="display:none"></div>
						
						<div id="bx_chpass_resend"></div>
						
						<?endif?>
						
						<?endif;?>
						
					</div>
				</div>
			</div>
		
		</div>
	</div>
</div>


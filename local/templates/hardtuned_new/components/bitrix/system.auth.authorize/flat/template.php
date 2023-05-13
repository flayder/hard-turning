<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$APPLICATION->AddChainItem("Войти в гараж", "");
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
			<h1>Войти в свой гараж</h1>
			<div class="main-lk">
				<div class="wr-main-lk">
					<div class="col-lg-5 order">
						<h2>Пожалуйста, авторизуйтесь</h2>
						<form name="form_auth" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
							<div class="input" style="font-size: 16px;">
								<?
									ShowMessage($arParams["~AUTH_RESULT"]);
									ShowMessage($arResult['ERROR_MESSAGE']);
								?>
							</div>

							<input type="hidden" name="AUTH_FORM" value="Y" />
							<input type="hidden" name="TYPE" value="AUTH" />
							<?if (strlen($arResult["BACKURL"]) > 0):?>
							<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
							<?endif?>
							<?foreach ($arResult["POST"] as $key => $value):?>
							<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
							<?endforeach?>

							<div class="input">
								<label for="">
									Логин
								</label>
								<input type="text" placeholder="Введите логин" name="USER_LOGIN" value="<?=$arResult["LAST_LOGIN"]?>">
							</div>
							<div class="input">
								<label for="">
									Пароль
								</label>
								<input type="password" name="USER_PASSWORD" placeholder="Введите пароль">
							</div>
							<?if($arResult["CAPTCHA_CODE"]):?>
								<tr>
									<td></td>
									<td><input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
									<img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /></td>
								</tr>
								<tr>
									<td class="bx-auth-label"><?echo GetMessage("AUTH_CAPTCHA_PROMT")?>:</td>
									<td><input class="bx-auth-input" type="text" name="captcha_word" maxlength="50" value="" size="15" /></td>
								</tr>
							<?endif;?>
							<div class="link-b">
								<a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>">Забыли пароль?</a>
								<a href="<?=$arResult["AUTH_REGISTER_URL"]?>">Зарегистрироваться</a>
							</div>
							<button type="submit" name="Login" class="btn-c-lilac">
								Войти
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- <script type="text/javascript">
<?if (strlen($arResult["LAST_LOGIN"])>0):?>
try{document.form_auth.USER_PASSWORD.focus();}catch(e){}
<?else:?>
try{document.form_auth.USER_LOGIN.focus();}catch(e){}
<?endif?>
</script> -->

<?if($arResult["AUTH_SERVICES"]):?>
<?
/*$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "",
	array(
		"AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
		"CURRENT_SERVICE" => $arResult["CURRENT_SERVICE"],
		"AUTH_URL" => $arResult["AUTH_URL"],
		"POST" => $arResult["POST"],
		"SHOW_TITLES" => $arResult["FOR_INTRANET"]?'N':'Y',
		"FOR_SPLIT" => $arResult["FOR_INTRANET"]?'Y':'N',
		"AUTH_LINE" => $arResult["FOR_INTRANET"]?'N':'Y',
	),
	$component,
	array("HIDE_ICONS"=>"Y")
);*/
?>
<?endif?>

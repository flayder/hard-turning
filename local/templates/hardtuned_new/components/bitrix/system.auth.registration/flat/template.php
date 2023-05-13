<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$APPLICATION->AddChainItem("Регистрация", "");
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
			<h1>Регистрация</h1>
			<div class="main-lk registration">
				<div class="wr-main-lk row">
					<div class="col-12 bor order">
						<h2>Заполните поля для регистрации</h2>
						<div class="txt-descr">
							Открыв свой гараж, можно будет добавлять несколько авто для подбора нужных аксессуаров и товаров.
						</div>
						<div class="input" style="font-size: 16px;">
							<div class="alert alert-danger" style="display: none;"></div>
							<div class="alert alert-success" style="display: none;"></div>
							<?if(!empty($arParams["~AUTH_RESULT"])):
									$text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]);
								?>
								<div class="alert <?=($arParams["~AUTH_RESULT"]["TYPE"] == "OK"? "alert-success":"alert-danger")?>"><?=nl2br(htmlspecialcharsbx($text))?></div>
							<?endif?>

							<?if($arResult["USE_EMAIL_CONFIRMATION"] === "Y" && is_array($arParams["AUTH_RESULT"]) &&  $arParams["AUTH_RESULT"]["TYPE"] === "OK"):?>
								<div class="alert alert-success"><?echo GetMessage("AUTH_EMAIL_SENT")?></div>
							<?endif;?>

							<?if($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):?>
								<div class="alert alert-warning"><?echo GetMessage("AUTH_EMAIL_WILL_BE_SENT")?></div>
							<?endif?>
						</div>
						<form method="post" action="<?=$arResult["AUTH_URL"]?>" id="REGISTER_FORM" name="bform" enctype="multipart/form-data">
							<?if($arResult["BACKURL"] <> ''):?>
									<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
							<?endif?>
							<!-- <input type="hidden" name="AUTH_FORM" value="Y" />
							<input type="hidden" name="TYPE" value="REGISTRATION" /> -->
						<div class="row" style="margin: 0 -15px;">
							<div class="input col-md-6">
								<label for="">ФИО</label>
								<input type="text" name="USER_NAME" placeholder="Введите ФИО" value="<?=$arResult["USER_NAME"]?>"></div>
							<div class="input col-md-6">
								<label for="">Телефон</label>
								<input type="text" name="USER_PHONE" placeholder="Введите телефон" value="<?=$arResult["USER_PHONE"]?>"></div>
							<div class="input col-md-6">
								<label for="">Электронная почта</label>
								<input type="text" placeholder="Введите почту" name="USER_EMAIL" value="<?=$arResult["USER_EMAIL"]?>"></div>
							<div class="input col-md-6">
								<label for="">Логин</label>
								<input type="text" name="USER_LOGIN" placeholder="Введите логин" value="<?=$arResult["USER_LOGIN"]?>"></div>
							<div class="input col-md-6">
								<label for="">Пароль</label>
								<input type="password" name="USER_PASSWORD" placeholder="Введите пароль" value="<?=$arResult["USER_PASSWORD"]?>"></div>
							<div class="input col-md-6">
								<label for="">Повторите пароль</label>
								<input type="password" name="USER_CONFIRM_PASSWORD" placeholder="Введите пароль"></div>
							<div class="input col-md-12">
								<label for="">Город</label>
								<input type="text" name="CITY" placeholder="Введите город"></div>
							<div class="link-b col-md-12">
								<a href="<?=$arResult["AUTH_AUTH_URL"]?>">Уже есть аккаунт? Войдите</a>
							</div>
						</div>	
						<?if ($arResult["USE_CAPTCHA"] == "Y"):?>
		<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />

		<div class="input">
			<label for="">
				<?=GetMessage("CAPTCHA_REGF_PROMT")?>
			</label>
			<div class="bx-captcha"><img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /></div>
			<div class="bx-authform-input-container">
				<input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off"/>
			</div>
		</div>

<?endif?>
						<button type="submit" name="Register" class="btn-c-lilac">Регистрация</button>
					</div>
					<div class="col-lg-5 col-lg-offset-1 order" style="display: none;">
						<h2>2. Добавьте авто</h2>
						<div class="txt-descr">
							Открыв свой гараж, можно будет добавлять несколько авто для подбора нужных аксессуаров и товаров.
						</div>
						<div class="input">
							<label for="">Марка</label>
							<div class="select">
								<select name="MARK" style="display: none;">
									<option value="">Выберите марку авто</option>
									<?if(!empty($arResult['MARKS'])):?>
										<?foreach ($arResult['MARKS'] as $key => $item):?>
											<option <?if(isset($_SESSION['U_MARKA']) && !empty($_SESSION['U_MARKA']) && $_SESSION['U_MARKA'] == $item['ID']) echo "selected";?> value="<?=$item['ID']?>"><?=$item['NAME']?></option>
										<?endforeach;?>
									<?endif;?>
								</select>
								<div class="pan">
									<span class="val"><?if(isset($_SESSION['U_MARKA']) && isset($arResult['MARKS'][$_SESSION['U_MARKA']])):?><?=$arResult['MARKS'][$_SESSION['U_MARKA']]['NAME']?><?else:?>Выберите марку авто<?endif;?></span> <i class="fas fa-chevron-down"></i>
									<ul>
										<li data-value="">Выберите марку авто</li>
										<?if(!empty($arResult['MARKS'])):?>
											<?foreach ($arResult['MARKS'] as $key => $item):?>
												<li data-value="<?=$item['ID']?>"><?=$item['NAME']?></li>
											<?endforeach;?>
										<?endif;?>
									</ul>
								</div>
							</div>
						</div>
						<div class="input">
							<label for="">Модель</label>
							<div class="select">
								<select name="MODEL" style="display: none;">
									<option value="">Выберите модель авто</option>
									<?if(!empty($arResult['MODEL'])):?>
										<option selected="selected" value="<?=$arResult['MODEL']['ID']?>"><?=$arResult['MODEL']['NAME']?></option>
									<?endif;?>
								</select>
								<div class="pan">
									<span class="val"><?if(!empty($arResult['MODEL']['NAME'])):?><?=$arResult['MODEL']['NAME']?><?else:?>Выберите модель авто<?endif;?></span> <i class="fas fa-chevron-down"></i>
									<ul>
										<li data-value="">Выберите модель авто</li>
										<?if(!empty($arResult['MODEL'])):?>
											<li data-value="<?=$arResult['MODEL']['ID']?>"><?=$arResult['MODEL']['NAME']?></li>
										<?endif;?>
									</ul>
								</div>
							</div>
						</div>
						<div class="input">
							<label for="">Год</label>
							<div class="select">
								<select name="YEAR" style="display: none;">
									<option value="">Выберите год авто</option>
									<?if(!empty($arResult['YEAR'])):?>
										<option selected="selected" value="<?=$arResult['YEAR']['ID']?>"><?=$arResult['YEAR']['NAME']?></option>
									<?endif;?>
								</select>
								<div class="pan">
									<span class="val"><?if(!empty($arResult['YEAR']['NAME'])):?><?=$arResult['YEAR']['NAME']?><?else:?>Выберите год авто<?endif;?></span> <i class="fas fa-chevron-down"></i>
									<ul>
										<li data-value="">Выберите год авто</li>
										<?if(!empty($arResult['YEAR'])):?>
											<li data-value="<?=$arResult['YEAR']['ID']?>"><?=$arResult['YEAR']['NAME']?></li>
										<?endif;?>
									</ul>
								</div>
							</div>
						</div>
						<div class="btn-r-trans" style="display: none;">Добавить фото
							<input type="file" name="AVATAR">
						</div>
					</div>
				</form>
				</div>
			</div>
		</div>
	</div>
</div>
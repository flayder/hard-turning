<?
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
?>

<div class="order">
	<form method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">
		<?=$arResult["BX_SESSION_CHECK"]?>
		<input type="hidden" name="lang" value="<?=LANG?>" />
		<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
		<div class="input" style="font-size: 16px; height: auto;">
			<?if(!empty($arResult["strProfileError"])):?>
				<div class="alert alert-danger" style="width: 90%; margin-left: auto;margin-right: auto;">
					<?ShowError($arResult["strProfileError"]);?>
				</div>
			<?endif;?>
				
			<?
			if ($arResult['DATA_SAVED'] == 'Y'):?>
				<div class="alert alert-success" style="width: 90%; margin-left: auto;margin-right: auto;">
					<?ShowNote(GetMessage('PROFILE_DATA_SAVED'));?>
				</div>
			<?endif;?>
			<script type="text/javascript">
			var opened_sections = [<?
			$arResult["opened"] = $_COOKIE[$arResult["COOKIE_PREFIX"]."_user_profile_open"];
			$arResult["opened"] = preg_replace("/[^a-z0-9_,]/i", "", $arResult["opened"]);
			if (strlen($arResult["opened"]) > 0)
			{
				echo "'".implode("', '", explode(",", $arResult["opened"]))."'";
			}
			else
			{
				$arResult["opened"] = "reg";
				echo "'reg'";
			}
			?>];
			
			
			var cookie_prefix = '<?=$arResult["COOKIE_PREFIX"]?>';
			</script>
		</div>
		<div class="input">
			<div class="col-md-3">
				<label for="">Логин</label>
			</div>
			<div class="col-md-7">
				<div class="txt-info"><?=$arResult["arUser"]["LOGIN"]?></div>
				<input type="text" class="inform" name="LOGIN" placeholder="Введите логин" value="<?=$arResult["arUser"]["LOGIN"]?>"></div>
			<div class="col-md-2">
				<div class="change">изменить</div>
			</div>
		</div>
		<div class="input">
			<div class="col-md-3">
				<label for="">Пароль</label>
			</div>
			<div class="col-md-7">
				<div class="txt-info"></div>
				<input type="text" class="inform" name="PASSWORD" placeholder="Введите пароль" value=""></div>
			<div class="col-md-2">
				<div class="change">изменить</div>
			</div>
		</div>
		<div class="input">
			<div class="col-md-3">
				<label for="">ФИО</label>
			</div>
			<div class="col-md-7">
				<div class="txt-info"><?=$arResult["arUser"]["NAME"]?></div>
				<input type="text" class="inform" name="NAME" placeholder="Введите ФИО" value="<?=$arResult["arUser"]["NAME"]?>"></div>
			<div class="col-md-2">
				<div class="change">изменить</div>
			</div>
		</div>
		<div class="input">
			<div class="col-md-3">
				<label for="">Телефон</label>
			</div>
			<div class="col-md-7">
				<div class="txt-info"><?=$arResult["arUser"]["PERSONAL_PHONE"]?></div>
				<input type="text" class="inform" name="PERSONAL_PHONE" placeholder="Введите телефон" value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>"></div>
			<div class="col-md-2">
				<div class="change">изменить</div>
			</div>
		</div>
		<div class="input">
			<div class="col-md-3">
				<label for="">Электронная почта</label>
			</div>
			<div class="col-md-7">
				<div class="txt-info"><?=$arResult["arUser"]["EMAIL"]?></div>
				<input type="text" class="inform" name="EMAIL" placeholder="Введите электронную почту" value="<?=$arResult["arUser"]["EMAIL"]?>"></div>
			<div class="col-md-2">
				<div class="change">изменить</div>
			</div>
		</div>
		<div class="input">
			<div class="col-md-3">
				<label for="">Город</label>
			</div>
			<div class="col-md-7">
				<div class="txt-info"><?=$arResult["arUser"]["PERSONAL_CITY"]?></div>
				<input type="text" class="inform" name="PERSONAL_CITY" placeholder="Введите город" value="<?=$arResult["arUser"]["PERSONAL_CITY"]?>"></div>
			<div class="col-md-2">
				<div class="change">изменить</div>
			</div>
		</div>
		<div class="btn-p">
			<button type="submit" class="btn-o-lilac">Сохранить</button>
					<input type="hidden" name="save" value="Y" />
		</div>
	</form>
</div>
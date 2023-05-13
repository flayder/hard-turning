<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $USER;

$balls = 0;

if($USER->IsAuthorized()) {
	$rsUsers = CUser::GetList(($by="personal_country"), ($order="desc"), ['ID' => $USER->GetID()]);
	if($USER->IsAdmin()) {
		if($arUser = $rsUsers->Fetch()) {
			$balls = $arUser['UF_BALLS'];
		}
	}
	//print_r($arResult);
}

if($USER->IsAuthorized() || $arParams["ALLOW_AUTO_REGISTER"] == "Y")
{
	if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y")
	{
		if(strlen($arResult["REDIRECT_URL"]) > 0)
		{
			$APPLICATION->RestartBuffer();
			?>
			<script type="text/javascript">
				window.top.location.href='<?=CUtil::JSEscape($arResult["REDIRECT_URL"])?>';
			</script>
			<?
			die();
		}

	}
}

$APPLICATION->SetAdditionalCSS($templateFolder."/style_cart.css");
$APPLICATION->SetAdditionalCSS($templateFolder."/style.css");
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
<a name="order_form"></a>

<div id="order_form_div" class="order-checkout">
<NOSCRIPT>
	<div class="errortext"><?=GetMessage("SOA_NO_JS")?></div>
</NOSCRIPT>

<?
if (!function_exists("getColumnName"))
{
	function getColumnName($arHeader)
	{
		return (strlen($arHeader["name"]) > 0) ? $arHeader["name"] : GetMessage("SALE_".$arHeader["id"]);
	}
}

if (!function_exists("cmpBySort"))
{
	function cmpBySort($array1, $array2)
	{
		if (!isset($array1["SORT"]) || !isset($array2["SORT"]))
			return -1;

		if ($array1["SORT"] > $array2["SORT"])
			return 1;

		if ($array1["SORT"] < $array2["SORT"])
			return -1;

		if ($array1["SORT"] == $array2["SORT"])
			return 0;
	}
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
			<h1>Оформление заказа</h1>
	<?
	if(!$USER->IsAuthorized() && $arParams["ALLOW_AUTO_REGISTER"] == "N")
	{
		if(!empty($arResult["ERROR"]))
		{
			foreach($arResult["ERROR"] as $v)
				echo ShowError($v);
		}
		elseif(!empty($arResult["OK_MESSAGE"]))
		{
			foreach($arResult["OK_MESSAGE"] as $v)
				echo ShowNote($v);
		}

		include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/auth.php");
	}
	else
	{
		if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y")
		{
			if(strlen($arResult["REDIRECT_URL"]) == 0)
			{
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/confirm.php");
			}
		}
		else
		{
			?>
			<script type="text/javascript">

			<?if(CSaleLocation::isLocationProEnabled()):?>

				<?
				// spike: for children of cities we place this prompt
				$city = \Bitrix\Sale\Location\TypeTable::getList(array('filter' => array('=CODE' => 'CITY'), 'select' => array('ID')))->fetch();
				?>

				BX.saleOrderAjax.init(<?=CUtil::PhpToJSObject(array(
					'source' => $this->__component->getPath().'/get.php',
					'cityTypeId' => intval($city['ID']),
					'messages' => array(
						'otherLocation' => '--- '.GetMessage('SOA_OTHER_LOCATION'),
						'moreInfoLocation' => '--- '.GetMessage('SOA_NOT_SELECTED_ALT'), // spike: for children of cities we place this prompt
						'notFoundPrompt' => '<div class="-bx-popup-special-prompt">'.GetMessage('SOA_LOCATION_NOT_FOUND').'.<br />'.GetMessage('SOA_LOCATION_NOT_FOUND_PROMPT', array(
							'#ANCHOR#' => '<a href="javascript:void(0)" class="-bx-popup-set-mode-add-loc">',
							'#ANCHOR_END#' => '</a>'
						)).'</div>'
					)
				))?>);

			<?endif?>

			var BXFormPosting = false;
			function submitForm(val)
			{
				if (BXFormPosting === true)
					return true;

				BXFormPosting = true;
				if(val != 'Y')
					BX('confirmorder').value = 'N';

				var orderForm = BX('ORDER_FORM');
				BX.showWait();

				<?if(CSaleLocation::isLocationProEnabled()):?>
					BX.saleOrderAjax.cleanUp();
				<?endif?>

				BX.ajax.submit(orderForm, ajaxResult);

				return true;
			}

			function ajaxResult(res)
			{
				var orderForm = BX('ORDER_FORM');
				try
				{
					// if json came, it obviously a successfull order submit

					var json = JSON.parse(res);
					BX.closeWait();

					if (json.error)
					{
						BXFormPosting = false;
						return;
					}
					else if (json.redirect)
					{
						window.top.location.href = json.redirect;
					}
				}
				catch (e)
				{
					// json parse failed, so it is a simple chunk of html

					BXFormPosting = false;
					BX('order_form_content').innerHTML = res;

					<?if(CSaleLocation::isLocationProEnabled()):?>
						BX.saleOrderAjax.initDeferredControl();
					<?endif?>
				}

				BX.closeWait();
				BX.onCustomEvent(orderForm, 'onAjaxSuccess');
			}

			function SetContact(profileId)
			{
				BX("profile_change").value = "Y";
				submitForm();
			}
			</script>
			<?if($_POST["is_ajax_post"] != "Y")
			{
				?><form action="<?=$APPLICATION->GetCurPage();?>" method="POST" style="width: 100%;" name="ORDER_FORM" id="ORDER_FORM" enctype="multipart/form-data">
				<?=bitrix_sessid_post()?>
				<div id="order_form_content">
				<?
			}
			else
			{
				$APPLICATION->RestartBuffer();
			}

			if($_REQUEST['PERMANENT_MODE_STEPS'] == 1)
			{
				?>
				<input type="hidden" name="PERMANENT_MODE_STEPS" value="1" />
				<?
			}

			if(!empty($arResult["ERROR"]) && $arResult["USER_VALS"]["FINAL_STEP"] == "Y")
			{
				foreach($arResult["ERROR"] as $v)
					echo ShowError($v);
				?>
				<script type="text/javascript">
					top.BX.scrollToNode(top.BX('ORDER_FORM'));
				</script>
				<?
			}


			?>
			<input type="hidden" value="" name="ORDER_PROP_10">
			<div class="order">
				<div class="wrap">
					<div class="title">Контактные данные</div>
					<div class="col-md-7">
						<?
							//include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/person_type.php");
							include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props.php");
						?>
					</div>
					<div style="clear: both;"></div>
					<div class="title">Комментарий к заказу</div>
					<div class="col-md-7">

						<div class="input">
							<div class="col-md-4">
								<label for="">Ваш комментарий</label>
							</div>
							<div class="col-md-8" data-property-id-row="9">
								<?$APPLICATION->ShowViewContent('comment_property');?>
							</div>
						</div>
					<div style="clear: both;"></div>
						<?if($USER->IsAdmin() && $lost):?>
						<div id="register_garag" style="margin-left: -17px; margin-top: 40px;">
							<div class="input radio">
								<input type="checkbox" id="order_register">
								<label>Зарегистрировать личный кабинет и добавить свой автомобиль в виртуальный гараж</label>
							</div>
							<div class="descr">
								При регистрации Вы получаете накопительные скидки, курирующего личного менеджера, возможность получать новости о новинках тюнинга на Ваш автомобиль. 
							</div>
						</div>

						<div class="main-lk registration">
				<div class="wr-main-lk row">
					<div class="col-lg-12 bor order">
						<h2>1. Заполните поля для регистрации</h2>
						<div class="txt-descr">
							Открыв свой гараж, можно будет добавлять несколько авто для подбора нужных аксессуаров и товаров.
						</div>
						<div class="input" style="font-size: 16px;">
							<div class="alert alert-danger" style="display: none;"></div>
							<div class="alert alert-success" style="display: none;"></div>
						</div>
							<!-- <input type="hidden" name="AUTH_FORM" value="Y" />
							<input type="hidden" name="TYPE" value="REGISTRATION" /> -->
						<div class="input">
							<label for="">Электронная почта</label>
							<input type="text" placeholder="Введите почту" name="USER_EMAIL" value="<?=$_POST["USER_EMAIL"]?>"></div>
						<div class="input">
							<label for="">Логин</label>
							<input type="text" name="USER_LOGIN" placeholder="Введите логин" value="<?=$_POST["USER_LOGIN"]?>"></div>
						<div class="input">
							<label for="">Пароль</label>
							<input type="password" name="USER_PASSWORD" placeholder="Введите пароль" value="<?=$_POST["USER_PASSWORD"]?>"></div>
						<div class="input">
							<label for="">Повторите пароль</label>
							<input type="password" name="USER_CONFIRM_PASSWORD" placeholder="Введите пароль" value="<?=$_POST["USER_CONFIRM_PASSWORD"]?>"></div>
						<div class="clear"></div>
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
						<div class="btn-r-trans">Добавить фото
							<input type="file" name="AVATAR">
						</div>
						<div class="clear"></div>
						<button type="button" name="Register" class="btn-c-lilac">Регистрация</button>
					</div>
			
				</div>
			</div>
		</div>
						<?endif;?>
					</div>
					<div style="clear: both;"></div>
					<div class="table-o">
						<div class="col-md-6 block-o" style="border-bottom: none;">
							<div class="title">Выберите способ доставки</div>
							<?
								include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery.php");
							?>
						</div>
						<div class="col-md-6 block-o" style="border-left: none; border-bottom: none;">
							<div class="title">Выберите способ оплаты</div>
							<?
								include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/paysystem.php");
							?>
						</div>
					</div>
					<div class="col-md-12">
						
					<div class="bottom-p">
						<div class="sum">
							Итоговая стоимость заказа:
							<span style="color: #304C81">
								<?if($_POST['APPLY_BALLS']):
									$discount = 0;
									$order_price = intval($arResult['ORDER_TOTAL_PRICE']);
									$max_price = $order_price * 40 / 100;

									if($balls > $max_price) {
										$discount = $max_price;
									} else {
										$discount = $balls;
									}
									echo number_format ( $order_price - $discount, 0, '', ' ' );
								else:
								?>
									<?=$arResult['ORDER_TOTAL_PRICE_FORMATED']?> 
								<?endif;?>
								руб.
							</span>
						</div>
						<?if($USER->IsAdmin()):?>
							<div class="balls-block">
								Доступное количество баллов: <?=$balls?>
								<?if($balls > 0):?>
									<label for="">
										<input type="checkbox" onclick="submitForm()" name="APPLY_BALLS" <?if($_POST['APPLY_BALLS']):?> checked<?endif;?>>
										<span>Применить существующие баллы (Можете оплатить новый заказ до 40% от суммы заказ)</span>
									</label>
								<?endif;?>
							</div>
						<?endif;?>
						<button type="button" id="ORDER_CONFIRM_BUTTON" class="btn-o-lilac">Оформить заказ</button>
					</div>
					<div class="descr">
						<?$APPLICATION->IncludeComponent(
							"bitrix:main.include",
							"",
							Array(
								"AREA_FILE_SHOW" => "file",
								"AREA_FILE_SUFFIX" => "inc",
								"EDIT_TEMPLATE" => "",
								"PATH" => "/include/order_offer.php"
							)
						);?>
					</div>
								</div>
			</div>
			<?

			//include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/related_props.php");

			//include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/summary.php");
			if(strlen($arResult["PREPAY_ADIT_FIELDS"]) > 0)
				echo $arResult["PREPAY_ADIT_FIELDS"];
			?>
										<input type="hidden" name="confirmorder" id="confirmorder" value="Y">
					<input type="hidden" name="profile_change" id="profile_change" value="N">
					<input type="hidden" name="is_ajax_post" id="is_ajax_post" value="Y">
					<input type="hidden" name="json" value="Y">
			<?if($_POST["is_ajax_post"] != "Y")
			{
				?>

					<input type="hidden" name="ORDER_PRICE" value="<?=$arResult['ORDER_TOTAL_PRICE_FORMATED']?>">
				</form>
				<?
				if($arParams["DELIVERY_NO_AJAX"] == "N")
				{
					?>
					<div style="display:none;"><?$APPLICATION->IncludeComponent("bitrix:sale.ajax.delivery.calculator", "", array(), null, array('HIDE_ICONS' => 'Y')); ?></div>
					<?
				}
			}
			else
			{
				?>
				<input type="hidden" name="ORDER_PRICE" value="<?=$_POST['ORDER_PRICE']?>">
				<script type="text/javascript">
					top.BX('confirmorder').value = 'Y';
					top.BX('profile_change').value = 'N';
				</script>
				<?
				die();
			}
			?>
				
			<?
		}
	}
	?>
	<div style="clear: both;"></div>
</div>
		</div>
	</div>

<?if(CSaleLocation::isLocationProEnabled()):?>

	<div style="display: none">
		<?// we need to have all styles for sale.location.selector.steps, but RestartBuffer() cuts off document head with styles in it?>
		<?$APPLICATION->IncludeComponent(
			"bitrix:sale.location.selector.steps", 
			".default", 
			array(
			),
			false
		);?>
		<?$APPLICATION->IncludeComponent("bitrix:sale.location.selector.search", "new", Array(
	
	),
	false
);?>
	</div>

<?endif?>
</div>
</div>
</div>
<?if(!$USER->IsAuthorized()):?>
	<div class="modal_wrap" id="register_g">
		<div class="wrap-content">
			<div class="close">&times;</div>
			<div class="title">
				Зарегистрировать гараж
			</div>
			<form action="">
				<p style="font-size: 16px;">
					Для того, чтобы зарегистрировать гараж, вы должны пройти регистрацию на сайте.
				</p>
				<a href="/login/?register=yes" class="btn-mod">Зарегистрироваться</a>
				<div style="border: 1px solid #333; margin: 15px 0 10px;"></div>
				<p style="font-size: 16px;">
					Для тех, у кого уже существует аккаунт, вы можете прикрепить машину в личном кабинете.
				</p>
				<a href="/login/" class="btn-mod">Войти</a>
			</form>
		</div>
	</div>
<?endif;?>
<script>
	$(document).on('click', '#ORDER_CONFIRM_BUTTON', function(){
		var $form = $('#ORDER_FORM');
		var $req = $('.require-r');
		var $error = false;
		$req.removeClass('req').find('.req-r').remove();
		for(var i = 0; i < $req.length; i++) {
			if($req.eq(i).find('input, textarea').val().length == 0) {
				$req.eq(i).addClass('req').append('<span class="req-r">Вы не заполняли это поле</span>');
				$error = true;
			}
		}
		if(!$error) submitForm('Y');
		else {
			window.location.href="#order_form_content";
		}
	});
</script>

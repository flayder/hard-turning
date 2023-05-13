<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Application,
	Bitrix\Main\Web\Cookie;

global $USER;
?>

<?if($USER->IsAdmin()):?>



<?endif;?>

<?
if (!empty($arResult["ORDER"]) && $_GET["successful"] == "Y")
{
	//if($USER->IsAdmin()):
		$cookie = unserialize(Application::getInstance()->getContext()->getRequest()->getCookie("ORDER_DONE"));
		if(!in_array($arResult["ORDER"]["ID"], $cookie)):
			$data = (is_array($cookie)) ? $cookie : [];
			$data[] = $arResult["ORDER"]["ID"];
			$cookie = new Cookie("ORDER_DONE", serialize($data), time() + 60*60*24*60);
			Application::getInstance()->getContext()->getResponse()->addCookie($cookie);
?>
			<script>
				<?if($arResult["ITEMS"]):?>
					dataLayer.push({
					    "ecommerce": {
					        "purchase": {
					            "actionField": {
					                "id" : <?=$arResult["ORDER"]["ID"]?>,
					                "goal_id": 52896712
					            },
					            "products": [
									<?foreach ($arResult["ITEMS"] as $key => $arItem) :
										echo json_encode(
											[
												"id" => $arItem["ID"],
					             	       		"name" => $arItem["NAME"],
					             	       		"price" => (float)$arItem["PRICE"]["PRICE"] ?? "",
					             	       		"brand" => $arItem["BRAND"] ?? "",
					             	       		"category" => $arItem["SECTION_NAME"] ?? ""
											]
										);
										echo ",";
									endforeach;?>
					            ]
					        }
					    }
					})
				<?endif;?>
			</script>
		<?endif;?>
	<?//endif;?>
	<style>
		.order-confirm {
			font-size: 14px;
		}
		.order-confirm h1 {
			padding: 0;
		}
		.order-confirm p,
		.order-confirm h1,
		.order-confirm h3 {
			width: 100%;
			line-height: 22px;
		}
		.order-confirm a {
			color: #000;
		}
		.order-confirm h3,
		.order-confirm p {
			margin: 0 0 15px;
		}
		.order-confirm p {
			color: #002E47;
		}
		.order-confirm p b,
		.order-confirm p a {
			font-weight: 500;
			color: #000;
		}
		.order-confirm input {
			margin-top: 20px;
		}
		.order-confirm input[type="submit"] {
			width: 170px;
			height: 60px;
			background: linear-gradient(259.77deg, #721B5D 21.95%, #891F70 79.56%);
			color: #fff;
			border-radius: 10px;
		}
		.order-confirm input[type="submit"]:hover {
			opacity: .8;
		}
		.payment-bl {
			display: flex;
			padding: 15px 0;
			margin-bottom: 20px;
		}
		.payment-bl img {
			width: 30px !important;
			height: 30px !important;
			object-fit: cover;
		}
	
		.payment-block .tablebodytext > b,
		.payment-bl span {
			font-size: 18px;
			font-weight: 500;
		}
	
		.payment-block .tablebodytext > b {
			padding-left: 10px;
		}
	</style>
	
	<div class="container order-confirm">
		<div>
			<h3>Заказ сформирован</h3>
			<p>Ваш заказ <b><?=$arResult["ORDER"]["ACCOUNT_NUMBER"]?></b> от <?=$arResult["ORDER"]["DATE_INSERT"]?> успешно создан</p>
			<p>
				Вы можете следить за выполнением своего заказа в <a href="/personal/personalnye-dannye/" target="_blank">Персональном разделе сайта.</a> Обратите внимание, что для входа в этот раздел вам необходимо будет 	ввести логин и пароль пользователя сайта
			</p>
			<div class="payment-block">
				<?if (!empty($arResult["PAY_SYSTEM"])):?>
					<h3><?=GetMessage("SOA_TEMPL_PAY")?></h3>
	
					<div class="payment-bl">
						<?=CFile::ShowImage($arResult["PAY_SYSTEM"]["LOGOTIP"], 100, 100, "border=0", "", false);?>
						<span style="padding-left: 15px;">
							<?= $arResult["PAY_SYSTEM"]["NAME"] ?>
						</span>
					</div>
					<?
							if (strlen($arResult["PAY_SYSTEM"]["ACTION_FILE"]) > 0)
							{
								?>
										<?
										$service = \Bitrix\Sale\PaySystem\Manager::getObjectById($arResult["ORDER"]['PAY_SYSTEM_ID']);
	
										if ($arResult["PAY_SYSTEM"]["NEW_WINDOW"] == "Y")
										{
											?>
											<script language="JavaScript">
												window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))?>&PAYMENT_ID=<?=$arResult['ORDER']["PAYMENT_ID"]?>');
											</script>
											<?= GetMessage("SOA_TEMPL_PAY_LINK", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))."&PAYMENT_ID=".$arResult['ORDER']["	PAYMENT_ID"]))?>
											<?
											if (CSalePdf::isPdfAvailable() && $service->isAffordPdf())
											{
												?><br />
												<?= GetMessage("SOA_TEMPL_PAY_PDF", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))."&PAYMENT_ID=".$arResult['ORDER']["	PAYMENT_ID"]."&pdf=1&DOWNLOAD=Y")) ?>
												<?
											}
										}
										else
										{
											if ($service)
											{
												/** @var \Bitrix\Sale\Order $order */
												$order = \Bitrix\Sale\Order::load($arResult["ORDER_ID"]);
	
												/** @var \Bitrix\Sale\PaymentCollection $paymentCollection */
												$paymentCollection = $order->getPaymentCollection();
	
												/** @var \Bitrix\Sale\Payment $payment */
												foreach ($paymentCollection as $payment)
												{
													if (!$payment->isInner())
													{
														$context = \Bitrix\Main\Application::getInstance()->getContext();
														$service->initiatePay($payment, $context->getRequest());
														break;
													}
												}
											}
											else
											{
												echo '<span style="color:red;">'.GetMessage("SOA_TEMPL_ORDER_PS_ERROR").'</span>';
											}
										}
										?>
								<?
							}
							?>
				<?endif;?>
			</div>
		</div>
	</div>
	<script>
		window.onload = () => {
			$('.tablebodytext > b').text($('.tablebodytext > b').text() + ' руб.')
		}
	</script>
<?
}
else
{
	?>
	<b><?=GetMessage("SOA_TEMPL_ERROR_ORDER")?></b><br /><br />

	<table class="sale_order_full_table">
		<tr>
			<td>
				<?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST", Array("#ORDER_ID#" => $arResult["ACCOUNT_NUMBER"]))?>
				<?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST1")?>
			</td>
		</tr>
	</table>
	<?
}
?>


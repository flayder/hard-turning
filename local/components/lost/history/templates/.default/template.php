<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $USER;
?>
	<?if(!empty($arResult['ITEMS'])):?>
		<style>
			.table-history head th,
			.table-history td {
				padding: 10px !important;
			}
		</style>
		<table class="table-history">
			<thead>
				<tr>
					<th style="width: 50px !important;">Дата</th>
					<th style="width: calc(100% - 250px) !important;">Товар</th>
					<th style="width: 100px !important;">Статус товара</th>
					<th style="width: 50px !important;">Количество</th>
					<th style="width: 50px !important;">Сумма</th>
				</tr>
			</thead>
			<tbody>
				<?foreach ($arResult['ITEMS'] as $key => $item):
				?>
					<tr>
						<td style="width: 50px !important;"><a href="<?=$APPLICATION->GetCurPage()?>order.php?ID=<?=$basket['ORDER_ID']?>" class="link-h" target="_blank"><?=$item['DATE_STATUS']?></a></td>
						
							<td style="width: calc(100% - 250px) !important;">
								<?foreach ($item['BASKET'] as $k => $basket):?>
									<a href="<?=$APPLICATION->GetCurPage()?>order.php?ID=<?=$basket['ORDER_ID']?>" class="link-h" target="_blank">
										<?=$basket['NAME']?>
									</a>
									<br/>
									<?if(count($item['BASKET']) != $k + 1):?>
										<br/>
									<?endif;?>
								<?endforeach;?>
							</td>
							<td style="width: 100px !important;">
								<?if($item['PAYED'] == "Y"):?>
									Оплачен
								<?else:?>
									<a href="https://www.hard-tuning.ru/pay.php?ORDER_ID=<?=$basket['ORDER_ID']?>" class="btn-c-lilac" target="_blank" style="width: 100px; font-size: 12px; color: #fff;">Оплатить</a>
								<?endif;?>
							</td>
							<td style="width: 50px !important;">
								<?foreach ($item['BASKET'] as $k => $basket):?>
									<span style="position: relative;">
										<span style="opacity: 0;">
											<a href="<?=$APPLICATION->GetCurPage()?>order.php?ID=<?=$basket['ORDER_ID']?>" class="link-h" target="_blank">
												<?=$basket['NAME']?>
											</a>
											<br/>
											<?if(count($item['BASKET']) != $k + 1):?>
												<br/>
											<?endif;?>
										</span>
										<span style="position: absolute; left: 0; top: 50%;">
											<a href="<?=$APPLICATION->GetCurPage()?>order.php?ID=<?=$basket['ORDER_ID']?>" class="link-h" target="_blank">
												<?=$basket['QUANTITY']?> шт.
											</a>
											<br/>
											<?if(count($item['BASKET']) != $k + 1):?>
												<br/>
											<?endif;?>
										</span>
									</span>
								<?endforeach;?>
							</td>
							<td style="width: 50px !important;">
								<?foreach ($item['BASKET'] as $k => $basket):?>
									<span style="position: relative;">
										<span style="opacity: 0;">
											<a href="<?=$APPLICATION->GetCurPage()?>order.php?ID=<?=$basket['ORDER_ID']?>" class="link-h" target="_blank">
												<?=$basket['NAME']?>
											</a>
											<br/>
											<?if(count($item['BASKET']) != $k + 1):?>
												<br/>
											<?endif;?>
										</span>
										<span style="position: absolute; left: 0; top: 50%;">
											<? echo CurrencyFormat(intval($basket['PRICE']), 'RUB'); ?>
											<br/>
											<?if(count($item['BASKET']) != $k + 1):?>
												<br/>
											<?endif;?>
										</span>
									</span>
								<?endforeach?>
							</td>
						</tr>
				<?endforeach;?>
			</tbody>
		</table>
		<?
			echo $arResult['results']->GetPageNavStringEx($navComponentObject, '', 'round', 'N');
		?>
	<?else:?>
		<h2>У вас нет не одного заказанного товара</h2>
	<?endif;?>

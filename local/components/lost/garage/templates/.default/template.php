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
?>
<div class="order">
	<div class="alert alert-danger" style="display: none; max-width: 90%; margin-left: auto; margin-right: auto;"></div>
	<div class="alert alert-success" style="display: none; max-width: 90%; margin-left: auto; margin-right: auto;"></div>
	<?if(!empty($arResult['CARS']['MODELS'])):?>
	<table class="table-t">
		<thead>
			<tr>
				<th></th>
				<th style="text-align: center;">Марка</th>
				<th style="text-align: center;">Модель</th>
				<th style="text-align: center;">Год</th>
				<th style="text-align: center;">Win-номер</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		<?foreach ($arResult['CARS']['YEARS'] as $key => $car):?>
			<tr id="garage-<?=$car['ID']?>">
				<td>
					<div class="input radio<?if($car['ID'] == $arResult['DEFAULT']) echo " active";?>">
						<input type="radio" name="car"<?if($car['ID'] == $arResult['DEFAULT']) echo " checked";?> data-default="<?=$car['ID']?>">
					</div>
				</td>
				<td>
					<?if(!empty($car['PICTURE'])):?>
						<img src="<?=$car['PICTURE']?>" alt="img">
					<?endif;?>
					<div class="name"><?=$arResult['CARS']['MARKS'][$key]['NAME']?></div>
				</td>
				<td><?=$arResult['CARS']['MODELS'][$key]['NAME']?></td>
				<td><?=$car['NAME']?></td>
				<td>
					<div class="mobile-label">WIN-номер</div>
					<div class="wr-win">
						<a href="" class="add-b"> <i class="fas fa-plus"></i>
							Добавить win
						</a>
						<div class="input add-b">
							<input type="text" placeholder="Введите win" value="<?=$arResult['WIN'][$car['ID']];?>">
							<a href="javascript:void(0)" data-win="<?=$car['ID']?>" class="add"> <i class="fas fa-plus"></i>
							</a>
						</div>
					</div>
				</td>
				<td>
					<a href="javascript:void(0)" data-remove-garage="<?=$car['ID']?>" class="delete">
						<i class="fas fa-times"></i>
					</a>
				</td>
			</tr>
		<?endforeach;?>
		</tbody>
	</table>
	<?endif;?>
	<table class="bottom_t">
		<tbody>
			<tr>
				<td>
					<div class="input radio">
						<input type="radio" name="pay" id=""></div>
				</td>
				<td colspan="2">
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
				</td>
				<td colspan="2">
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
				</td>
				<td colspan="1">
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
				</td>
				<td>
					<a href="javascript:void(0)" data-add-garage="" class="add-m">Добавить автомобиль</a>
					<a href="javascript:void(0)" data-add-garage="" class="add">
						<i class="fas fa-plus"></i>
					</a>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="btn-p" style="opacity: 0; height: 200px;">
		<button class="btn-o-lilac">Сохранить</button>
	</div>
</div>
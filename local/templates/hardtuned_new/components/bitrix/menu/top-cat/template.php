<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<ul class="accordion"  id="accordion-3">

<?
global $USER;
if ($USER->IsAdmin()){
	//echo "<pre>"; print_r($arResult); echo "</pre>";
}
$previousLevel = 0;
foreach($arResult as $arItem):?>

	<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
		<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
	<?endif?>

	<?if ($arItem["IS_PARENT"]):?>

		<?if ($arItem["DEPTH_LEVEL"] == 1):?>
		<?//var_dump($arItem);?>
			<li>
				<a href="javascript:void(null);" class="<?if ($arItem["SELECTED"]):?>root-item-selected <?else:?>root-item<?endif?>">
					<?if(!empty($arItem['PARAMS']['PICTURE'])):?>
						<img src="<?=CFile::GetPath($arItem['PARAMS']['PICTURE'])?>" alt="image">
					<?endif;?>
					<?=$arItem["TEXT"]?>
				</a>
				<ul class="accordion-ibside">
		<?else:?>
			<?$file = CFile::ResizeImageGet($arItem["PARAMS"]["PICTURE"], array('width'=>30, 'height'=>30), BX_RESIZE_IMAGE_PROPORTIONAL, true);?>
			<li>
				<a href="<?=$arItem["LINK"]?>" class="parent<?if ($arItem["SELECTED"]):?> item-selected active<?endif?>">
					<?if(!empty($arItem['PARAMS']['PICTURE'])):?>
						<img src="<?=CFile::GetPath($arItem['PARAMS']['PICTURE'])?>" alt="image">
					<?endif;?>
					<?=$arItem["TEXT"]?>
				</a>
				<?if(isset($arItem['CHILDS'])):?>
					<span class="wrap-menu">
						<?foreach ($arItem['CHILDS'] as $k => $arItem_1):?>
							<ul>
								<li class="first-child"><a href="<?=$arItem_1['SECTION_PAGE_URL']?>"><?=$arItem_1['NAME']?></a></li>
								<?if(isset($arItem_1['CHILDS_2'])):?>
									<?foreach ($arItem_1['CHILDS_2'] as $k2 => $arItem_2):?>
										<li><a href="<?=$arItem_2['SECTION_PAGE_URL']?>"><?=$arItem_2['NAME']?></a></li>
									<?endforeach;?>
								<?endif;?>
							</ul>
						<?endforeach;?>
					</span>
				<?endif;?>
			</li>
			<ul>
		<?endif?>

	<?else:?>

		<?if ($arItem["DEPTH_LEVEL"] == 1):?>
			<li>
				<a href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]):?>root-item-selected active<?else:?>root-item<?endif?>" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>">
					<?if(!empty($arItem['PARAMS']['PICTURE'])):?>
						<img src="<?=CFile::GetPath($arItem['PARAMS']['PICTURE'])?>" alt="image">
					<?endif;?>
					<?=$arItem["TEXT"]?>
				</a>
				<?if(isset($arItem['CHILDS'])):?>
					<span class="wrap-menu">
						<?foreach ($arItem['CHILDS'] as $k => $arItem_1):?>
							<ul>
								<li class="first-child"><a href="<?=$arItem_1['SECTION_PAGE_URL']?>"><?=$arItem_1['NAME']?></a></li>
								<?if(isset($arItem_1['CHILDS_2'])):?>
									<?foreach ($arItem_1['CHILDS_2'] as $k2 => $arItem_2):?>
										<li><a href="<?=$arItem_2['SECTION_PAGE_URL']?>"><?=$arItem_2['NAME']?></a></li>
									<?endforeach;?>
								<?endif;?>
							</ul>
						<?endforeach;?>
					</span>
				<?endif;?>
			</li>
		<?endif?>


	<?endif?>

	<?$previousLevel = $arItem["DEPTH_LEVEL"];?>

<?endforeach?>

<?if ($previousLevel > 1)://close last item tags?>
	<?=str_repeat("</ul></li>", ($previousLevel-1) );?>
<?endif?>
<li class="raspr" style="background-color: #9d2b8a ;">
				<a style="color: white;" href="/catalog/rasprodazha/" class="root-item" title="Доступ запрещен">

  <img src="/img/sales1.png" alt="Фолбэк">


										Распродажа				



</a>
							</li>
</ul>
					<style>
						.raspr a:hover {background-color: #9d2b8a!important;}
</style>
<?endif?>
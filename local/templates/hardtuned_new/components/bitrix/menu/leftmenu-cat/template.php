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
			<li><a href="javascript:void(null);" class="<?if ($arItem["SELECTED"]):?>root-item-selected <?else:?>root-item<?endif?>" style="background: url(<?=CFile::GetPath($arItem['PARAMS']['PICTURE'])?>) no-repeat;"><?=$arItem["TEXT"]?></a>
				<ul class="accordion-ibside">
		<?else:?>
			<?$file = CFile::ResizeImageGet($arItem["PARAMS"]["PICTURE"], array('width'=>30, 'height'=>30), BX_RESIZE_IMAGE_PROPORTIONAL, true);?>
			<li><a href="<?=$arItem["LINK"]?>" class="parent<?if ($arItem["SELECTED"]):?> item-selected active<?endif?>" style="background: url(<?=$file["src"]?>) no-repeat;"><?=$arItem["TEXT"]?></a>
				</li><ul>
		<?endif?>

	<?else:?>

		<?if ($arItem["DEPTH_LEVEL"] == 1):?>
			<li><a href="<?=$arItem['LINK']?>" class="<?if ($arItem["SELECTED"]):?>root-item-selected active<?else:?>root-item<?endif?>" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>" style="background: url(<?=CFile::GetPath($arItem['PARAMS']['PICTURE'])?>) no-repeat;"><?=$arItem["TEXT"]?></a></li>
		<?else:?>
			<li><a href="<?=$arItem['LINK']?>" class="denied" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
		<?endif?>


	<?endif?>

	<?$previousLevel = $arItem["DEPTH_LEVEL"];?>

<?endforeach?>

<?if ($previousLevel > 1)://close last item tags?>
	<?=str_repeat("</ul></li>", ($previousLevel-1) );?>
<?endif?>

</ul>
<?endif?>
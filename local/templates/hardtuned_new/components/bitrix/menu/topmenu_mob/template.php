<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)):?>
<ul>
<?
foreach($arResult as $arItem):
	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
		continue;
?>
	<?if($arItem["SELECTED"]):?>
		<li class="selected-topmenu"><a href="<?=$arItem["LINK"]?>" class="selected" <?if (!empty($arItem["PARAMS"]["color"])):?>style="color: <?=$arItem["PARAMS"]["color"]?>;"<?endif?>><?=$arItem["TEXT"]?></a></li>
	<?else:?>
		<li><a href="<?=$arItem["LINK"]?>" <?if (!empty($arItem["PARAMS"]["color"])):?>style="color: <?=$arItem["PARAMS"]["color"]?>;"<?endif?>><?=$arItem["TEXT"]?></a></li>
	<?endif?>

<?endforeach?>
</ul>
<?endif?>
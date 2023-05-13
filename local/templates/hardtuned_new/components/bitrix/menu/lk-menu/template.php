<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$rsUser = CUser::GetByID($USER->GetID());
$arUser = $rsUser->Fetch();

?>

<?if (!empty($arResult)):?>
<ul>

<?
foreach($arResult as $arItem):
	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
		continue;
?>
	<?if($arItem["SELECTED"]):?>
		<li><a href="<?=$arItem["LINK"]?>" class="active"><span class="icon"></span><?=$arItem["TEXT"]?></a></li>
	<?else:?>
		<li><a href="<?=$arItem["LINK"]?>"><span class="icon"></span><?=$arItem["TEXT"]?></a></li>
	<?endif?>
	
<?endforeach?>
	<li>
		<a href="/?logout=yes"<?if($APPLICATION->GetCurPage() == '/personal/'):?> class="btn-c-lilac"<?endif;?>>Выйти</a>
	</li>
	<li style="display: flex; justify-content: space-between; text-align: center; align-items: center; flex-wrap: wrap;">
		<b style="font-size: 14px; width: 100%;">
			(Баллов: <?=$arUser['UF_BALLS'] < 0 ? '0': $arUser['UF_BALLS']?>)<br/>
			<span style="font-size: 11px;">Можете оплатить новый заказ до 40% от суммы заказ</span>
		</b>
	</li>
</ul>
<?endif?>
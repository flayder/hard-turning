<div class="news">
	<div class="title">Новости</div>
	<div class="wraps">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="new" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<div class="img">
			<?
			$img = null;
			if(!empty($arItem["PREVIEW_PICTURE"]["SRC"])) {
				$img = $arItem["PREVIEW_PICTURE"]["SRC"];
			} elseif(!empty($arItem["PREVIEW_PICTURE"]["SRC"])) {
				$img = $arItem["PREVIEW_PICTURE"]["SRC"];
			}
			?>
			<?if(!is_null($img)):?>
				<img src="<?=$img?>" alt="<?=$arItem["NAME"];?>">
			<?endif;?>
			</div>
		<div class="name">
			<a href="<?=$arItem["DETAIL_PAGE_URL"];?>">
				<?=$arItem["NAME"];?>
			</a>
		</div>
	</div>
<?endforeach;?>
	</div>
</div>
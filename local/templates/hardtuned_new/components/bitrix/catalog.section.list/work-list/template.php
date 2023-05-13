<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<?foreach ($arResult['SECTIONS'] as $key => $arSection):?>
	<h3 class="col-sm-12" style="font-size: 21px; text-align:center; margin-bottom:30px;">
		<?=$arSection['NAME']?>
	</h3>
	<br>
	<div class="container">
		<div class="row">
			<?foreach($arSection['ELEMENTS'] as $arItem):?>
			<?/*
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			*/?>
				<div class="col-sm-4 work-slider-block">
					<div class="top-work-block">
						<p class="name"><?echo $arItem["NAME"];?></p>
						<p  class="text">
								<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
									<?echo $arItem["PREVIEW_TEXT"];?>
								<?endif;?>
						</p>
					</div>	
					<div class="work-slide-wr" style="width: 100%;">
						<div class="work-slider-wrap">
							<?if (!empty($arItem["PROPERTIES"]["WORK_GALLERY"]["VALUE"])):?>
						  	<?foreach($arItem["PROPERTIES"]["WORK_GALLERY"]["VALUE"] as $photo):
						  		if($photo <= 0) continue;
						  		$file = CFile::GetFileArray($photo);
						  		$arWaterMark = Array(
								    array("name" => "watermark", "position" => "center", "size"=>"real", "file"=>$_SERVER['DOCUMENT_ROOT']."/bitrix/modules/itturbo.printform/logo-bg.png")
								);

								$file = CFile::ResizeImageGet($photo, array('width'=>$file['WIDTH'], 'height'=>$file['HEIGHT']), BX_RESIZE_IMAGE_EXACT, true, $arWaterMark);
						  	?>
						  		<?if($file['src']):?>
						  			<div class="image__wrapper">
						  				<img src="<?=$file['src']?>" class="minimized" alt="клик для увеличения" />
									</div>
								<?endif;?>
						  	<?endforeach?>
							<?endif?>
						</div>
					</div>
				</div>
			<?endforeach;?>
		</div>
	</div>

<?endforeach;?>
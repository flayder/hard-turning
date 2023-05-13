<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 */

$this->setFrameMode(true);

if (!empty($arResult['ITEMS']))
{
	$areaIds = array();
	$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
	$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
	$elementDeleteParams = array('CONFIRM' => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));
	?>
<div class="block_main <?=$arParams['CLASS_F']?>">
	<div class="title">
		<a href="javascript:void(0)"><?=$arParams['TITLE_F']?></a>
	</div>
	<div class="slider">
	<?
	foreach ($arResult['ITEMS'] as $item)
	{
		$uniqueId = $item['ID'].'_'.md5($this->randString().$component->getAction());
		$this->AddEditAction($uniqueId, $item['EDIT_LINK'], $elementEdit);
		$this->AddDeleteAction($uniqueId, $item['DELETE_LINK'], $elementDelete, $elementDeleteParams);
		?>
		<div class="product-block" id="<? echo $this->GetEditAreaId($uniqueId); ?>">
			<div class="wrap">
				<div class="img">
					<a href="<?=$item['DETAIL_PAGE_URL']?>">
						<img src="<?=$item['PREVIEW_PICTURE']['SRC']?>" alt="image">
					</a>
				</div>
				<div class="name">
					<a href="<?=$item['DETAIL_PAGE_URL']?>">
						<?=$item['NAME']?>
					</a>
				</div>
				<div class="price">
					<span><?=$item['PRICES']['BASE']['PRINT_VALUE_NOVAT']?></span>
					руб.
				</div>
				<?if(!isset($arResult['BASKET_PRODUCTS'][$item['ID']])):?>
					<button type="button" data-add-basket="<?=$item['ID']?>" onclick='addingEcommerce(
                        {
                            "id": <?=$item["ID"] ?? ""?>,
                            "name" : <?=$item["NAME"] ?? ""?>,
                            "price": <?=$item["MIN_PRICE"]["VALUE"] ?? ""?>
                            "brand": <?=$item["PROPERTIES"][75]["VALUE"] ?? ""?>,
                            "category": <?=$item["SECTION_NAME"] ?? ""?>,
                            "quantity": 1
                        }
                        )' data-quantity="1" class="btn-product">
						<span class="icon"></span>
						Купить
					</button>
				<?else: ?>
					<button type="button" class="btn-product active">
						<span class="icon"></span>
						Добавлено
					</button>
				<?endif;?>
			</div>
		</div>
	<?
	}
	?>
	</div>
</div>
<?
}
?>
		
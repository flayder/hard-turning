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
	<ul class="clients">
	<?
	foreach ($arResult['ITEMS'] as $item)
	{
		$uniqueId = $item['ID'].'_'.md5($this->randString().$component->getAction());
		$this->AddEditAction($uniqueId, $item['EDIT_LINK'], $elementEdit);
		$this->AddDeleteAction($uniqueId, $item['DELETE_LINK'], $elementDelete, $elementDeleteParams);
		?>
		<li id="<? echo $this->GetEditAreaId($uniqueId); ?>"><img src="<?=$item['PREVIEW_PICTURE']['SRC']?>" alt="<?=$item["NAME"]?>"></li>
	<?
	}
	?>
	</ul>
<?
}
?>
		
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
$this->setFrameMode(true);?>
<?
$page = $APPLICATION->GetCurPage();

$arViewModeList = $arResult['VIEW_MODE_LIST'];

$arViewStyles = array(
	'LIST' => array(
		'CONT' => 'bx_sitemap',
		'TITLE' => 'bx_sitemap_title',
		'LIST' => 'bx_sitemap_ul',
	),
	'LINE' => array(
		'CONT' => 'bx_catalog_line',
		'TITLE' => 'bx_catalog_line_category_title',
		'LIST' => 'bx_catalog_line_ul',
		'EMPTY_IMG' => $this->GetFolder().'/images/line-empty.png'
	),
	'TEXT' => array(
		'CONT' => 'bx_catalog_text',
		'TITLE' => 'bx_catalog_text_category_title',
		'LIST' => 'bx_catalog_text_ul'
	),
	'TILE' => array(
		'CONT' => 'bx_catalog_tile',
		'TITLE' => 'bx_catalog_tile_category_title',
		'LIST' => 'bx_catalog_tile_ul',
		'EMPTY_IMG' => $this->GetFolder().'/images/tile-empty.png'
	)
);
$arCurView = $arViewStyles[$arParams['VIEW_MODE']];

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

?>
<?if(!empty($arResult['SECTIONS'])):?>
	<h1 style="margin-top: 20px;">Каталог</h1>
<?endif;?>
<?
if (0 < $arResult["SECTIONS_COUNT"])
{
	$sections = '';
	foreach ($arResult['SECTIONS'] as &$arSection)
	{
		if($APPLICATION->GetCurPage() == $arSection['SECTION_PAGE_URL']) continue;
		$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
		$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
	
		if (false === $arSection['PICTURE'])
			$arSection['PICTURE'] = array(
				'SRC' => $arCurView['EMPTY_IMG'],
				'ALT' => (
					'' != $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
					? $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
					: $arSection["NAME"]
				),
				'TITLE' => (
					'' != $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]
					? $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]
					: $arSection["NAME"]
				)
			);
		switch ($arSection['DEPTH_LEVEL']) {
			case 1:
				$sections .= '<ul>
					<li id="'.$this->GetEditAreaId($arSection['ID']).'">
						<a href="'.$arSection['SECTION_PAGE_URL'].'">';
							if(!empty($arSection['DETAIL_PICTURE'])):
								$sections .= '<img src="'.$arSection['DETAIL_PICTURE'].'">';
							endif;
							$sections .= '<span class="name">'.$arSection['NAME'].'</span>
						</a>
					</li>
				</ul>';
			
				break;
			
			default:
			$sections .= '<div class="cat_s" id="'.$this->GetEditAreaId($arSection['ID']).'">
				<div class="img">
					<a href="'.$arSection['SECTION_PAGE_URL'].'">';
						if(!empty($arSection['DETAIL_PICTURE'])):
							$sections.='<img src="'.$arSection['DETAIL_PICTURE'].'">';
						endif;
					$sections .='</a>
				</div>
				<div class="name_c">
					<a href="'.$arSection['SECTION_PAGE_URL'].'">
						<b>'.$arSection['NAME'].'</b>
					</a>
				</div>
			</div>';
			break;
		}
		?>
		<?
	}
?>
	<?if(!empty($sections)):?>
		<div class="catalog_sect section_s">
			<div class="wrap">
				<?if($page != '/catalog/'):?><div class="title_h"><?=$arResult['SECTION']['NAME']?></div><?endif;?>
				<?echo $sections;?>
			</div>
		</div>
	<?endif;?>
<?}?>
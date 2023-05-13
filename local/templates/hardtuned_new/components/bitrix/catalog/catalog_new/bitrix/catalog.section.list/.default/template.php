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
global $USER;
$page = $APPLICATION->GetCurPage();
$sect = false;

$arr = explode('/', $page);
$code = $arr[count($arr)-2];
$str = '';
$sec = CIBlockSection::GetList(Array("SORT"=>"ASC"), Array('IBLOCK_ID' => 4, 'ACTIVE' => 'Y', '=CODE' => $code), false, Array('UF_*'), false);
if(!empty($code) && $section = $sec->GetNext()) {
	$sect = $section;
	if($section['UF_BG'] > 0) {
		$str = ' style="background: url('.CFile::GetPath($section['UF_BG']).') no-repeat; background-position: top center; background-size: 100% auto;"';
	}
} else {
	$res = CIBlock::GetByID(4);
	if($ar_res = $res->GetNext()) {
		$str = ' style="background: url('.CFile::GetPath($ar_res['PICTURE']).') no-repeat; background-position: top center; background-size: 100% auto;"';
	}
}
$APPLICATION->AddViewContent('section_bg', $str);
if($USER->IsAdmin()) {
	//echo "<pre>";
	//print_r($arResult['SECTIONS']);
	//echo "</pre>";
}
?>
<?


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
<div style="clear: both;"></div>
<?if(!empty($arResult['SECTIONS'])):?>
	<?if($page == "/catalog/"):?>
		<h1 style="margin-top: 20px;">Каталог</h1>
	<?else:?>
		<div class="title_h1" style="margin-top: 20px; margin-bottom: 0;">Каталог</div>
	<?endif;?>
<?endif;?>
<?
if (0 < $arResult["SECTIONS_COUNT"])
{
?>
<div class="catalog_sect section_s">
	<div class="wrap" style="padding: 20px 0;">
		<?if($page != '/catalog/'):?><h1 class="title_h" style="margin-bottom: 0;"><?=($arResult['SECTION']["UF_ADDITION_TITLE"]) ? $arResult['SECTION']["UF_ADDITION_TITLE"] . " " : ""?><?=$arResult['SECTION']['NAME']?></h1><?endif;?>
<?
	foreach ($arResult['SECTIONS'] as &$arSection)
	{
		$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
		$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
		$i++;
		if($sect && $sect['ID'] > 0 && $arSection['IBLOCK_SECTION_ID'] > 0 && $sect['ID'] != $arSection['IBLOCK_SECTION_ID']) continue;
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

		//switch ($arSection['DEPTH_LEVEL']) {
		//	case 1:
		/*		?>
				<?if($i==1):?>
					<ul style="margin-bottom: 0;"><?endif;?>
					<li id="<? echo $this->GetEditAreaId($arSection['ID']); ?>">
						<a href="<? echo $arSection['SECTION_PAGE_URL']; ?>">
							<?if(!empty($arSection['~PICTURE'])):?>
								<img src="<?=CFile::GetPath($arSection['~PICTURE'])?>">
							<?endif;?>
							<span class="name"><? echo $arSection['NAME']; ?></span>
						</a>
					</li>
			<?
				if(count($arResult['SECTIONS']) == $i):?>
				</ul>
				<?endif;
				break;
			
		//	default:
			*/?>
			<div class="cat_s" id="<? echo $this->GetEditAreaId($arSection['ID']); ?>">
				<div class="img">
					<a href="<? echo $arSection['SECTION_PAGE_URL']; ?>">
						<?if(!empty($arSection['~PICTURE'])):?>
							<img src="<?=CFile::GetPath($arSection['~PICTURE'])?>" style="height: 80px; width: auto; object-fit: contain;">
						<?endif;?>
					</a>
				</div>
				<div class="name_c">
					<a href="<? echo $arSection['SECTION_PAGE_URL']; ?>">
						<b><? echo $arSection['NAME']; ?></b>
					</a>
				</div>
			</div>
			<?
		//		break;
		//}
		?>
		<?
	}
}
?>
	</div>
</div>

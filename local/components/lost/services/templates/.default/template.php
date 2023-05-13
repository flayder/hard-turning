<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
	<?if(!empty($arResult['SECTIONS'])):?>
		<div class="block ser-block">
			<div class="title">Услуги</div>
			<ul>
				<?foreach ($arResult['SECTIONS'] as $key => $section):?>
					<li>
							<a href="/uslugi/<?=$section['CODE']?>"<?if(!empty($section['PICTURE'])):?> style="background: url(<?=$section['PICTURE']?>) no-repeat;<?endif;?>"><?=$section['NAME']?></a>
					</li>
				<?endforeach;?>
			</ul>
		</div>
	<?endif;?>

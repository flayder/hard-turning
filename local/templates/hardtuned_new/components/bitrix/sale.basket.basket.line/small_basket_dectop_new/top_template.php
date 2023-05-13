<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/**
 * @global array $arParams
 * @global CUser $USER
 * @global CMain $APPLICATION
 * @global string $cartId
 */
$compositeStub = (isset($arResult['COMPOSITE_STUB']) && $arResult['COMPOSITE_STUB'] == 'Y');
?>
<a href="<?= $arParams['PATH_TO_BASKET'] ?>" class="new_small_basket">
	<span class="icon"></span>
	<span class="count"><?=($arResult['NUM_PRODUCTS'] > 0)?$arResult['NUM_PRODUCTS']:'0';?></span>
</a>
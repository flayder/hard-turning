<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/**
 * @global array $arParams
 * @global CUser $USER
 * @global CMain $APPLICATION
 * @global string $cartId
 */
$compositeStub = (isset($arResult['COMPOSITE_STUB']) && $arResult['COMPOSITE_STUB'] == 'Y');
?>
<a href="<?= $arParams['PATH_TO_BASKET'] ?>">
	<span class="icon"></span>
	Корзина
	<span class="count"><?if($arResult['NUM_PRODUCTS'] > 0): echo $arResult['NUM_PRODUCTS']; endif;?></span>
</a>
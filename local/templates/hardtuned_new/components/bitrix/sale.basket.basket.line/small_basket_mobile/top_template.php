<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/**
 * @global array $arParams
 * @global CUser $USER
 * @global CMain $APPLICATION
 * @global string $cartId
 */
$compositeStub = (isset($arResult['COMPOSITE_STUB']) && $arResult['COMPOSITE_STUB'] == 'Y');
?>
<div class="basket-m">
	<a href="<?= $arParams['PATH_TO_BASKET'] ?>">
		<i class="fas fa-shopping-cart"></i>
		<?if($arResult['NUM_PRODUCTS'] > 0):?><span class="count"> <?echo $arResult['NUM_PRODUCTS'];?></span><? endif;?>
	</a>
</div>
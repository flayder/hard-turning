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
global $USER;
?>
	<?$this->SetViewTarget("lost_filter");?>
		<?if($APPLICATION->GetCurPage() != '/'):?>
		<style>
			@media (max-width: 991px) {
				.filter_main,
				.panel_menu {
					display: none !important;
				}
				.wrap_header {
					padding-bottom: 20px;
				}
			}
		</style>
	<?endif;?>
	<div class="label_of_filter">
		Поиск по авто
	</div>
<?
//empty($arResult['UF_MAIN_CAR']) || $arResult["AUTORIZED"] == "N"
if(true):?>
	
<div class="filter_main">
	<form action="">
		<div class="filter_main-wr">
			<div class="input cit">
			<div class="select">
				<select name="MARK_FILTER" style="display: none;">
					<option value="">Марка авто</option>
					<?if(!empty($arResult['MARKS'])):?>
						<?foreach ($arResult['MARKS'] as $key => $item):?>
							<option <?if(isset($_SESSION['U_MARKA']) && !empty($_SESSION['U_MARKA']) && $_SESSION['U_MARKA'] == $item['ID']) echo "selected";?> value="<?=$item['ID']?>"><?=$item['NAME']?></option>
						<?endforeach;?>
					<?endif;?>
				</select>
				<div class="pan">
					<span class="val"><?if(isset($_SESSION['U_MARKA']) && isset($arResult['MARKS'][$_SESSION['U_MARKA']])):?><?=$arResult['MARKS'][$_SESSION['U_MARKA']]['NAME']?><?else:?>Марка авто<?endif;?></span> <i class="fas fa-chevron-down"></i>
					<ul>
						<li data-value="">Марка авто</li>
						<?if(!empty($arResult['MARKS'])):?>
							<?foreach ($arResult['MARKS'] as $key => $item):?>
								<li data-value="<?=$item['ID']?>"><?=$item['NAME']?></li>
							<?endforeach;?>
						<?endif;?>
					</ul>
				</div>
			</div>
		</div>
		<div class="input in">
			<div class="select">
				<select name="MODEL_FILTER" style="display: none;">
					<option value="">Модель авто</option>
					<?if(!empty($arResult['MODEL'])):?>
						<option selected="selected" value="<?=$arResult['MODEL']['ID']?>"><?=$arResult['MODEL']['NAME']?></option>
					<?endif;?>
				</select>
				<div class="pan">
					<span class="val"><?if(!empty($arResult['MODEL']['NAME'])):?><?=$arResult['MODEL']['NAME']?><?else:?>Модель авто<?endif;?></span> <i class="fas fa-chevron-down"></i>
					<ul>
						<li data-value="">Модель авто</li>
						<?if(!empty($arResult['MODEL'])):?>
							<li data-value="<?=$arResult['MODEL']['ID']?>"><?=$arResult['MODEL']['NAME']?></li>
						<?endif;?>
					</ul>
				</div>
			</div>
		</div>
		<div class="input in">
			<div class="select">
				<select name="YEAR_FILTER" style="display: none;">
					<option value="">Год</option>
					<?if(!empty($arResult['YEAR'])):?>
						<option selected="selected" value="<?=$arResult['YEAR']['ID']?>"><?=$arResult['YEAR']['NAME']?></option>
					<?endif;?>
				</select>
				<div class="pan">
					<span class="val"><?if(!empty($arResult['YEAR']['NAME'])):?><?=$arResult['YEAR']['NAME']?><?else:?>Год<?endif;?></span> <i class="fas fa-chevron-down"></i>
					<ul>
						<li data-value="">Год</li>
						<?if(!empty($arResult['YEAR'])):?>
							<li data-value="<?=$arResult['YEAR']['ID']?>"><?=$arResult['YEAR']['NAME']?></li>
						<?endif;?>
					</ul>
				</div>
			</div>
		</div>
		</div>
		<!-- data-url="<?=($arResult['AUTORIZED'] == "Y")?'/cat/?default=car':'/cat/'?>" -->
		<div class="input">
			<button type="button" class="btn-product" id="search_filter" data-url="/cat/?default=car">
				Найти товары
			</button>
		</div>
	</form>
</div>
<?elseif($losts):?>
<div class="col-sm-12 col-lg-8 col-xl-7 col-lg-offset-1" style="margin-bottom: 25px;">
    <div class="panel_choice">
        <div class="img">
        	<?if(!empty($arResult['UF_MAIN_CAR']['PICTURE'])):?>
            	<img src="<?=$arResult['UF_MAIN_CAR']['PICTURE']?>" alt="img">
            <?endif;?>
        </div>
        <div class="block_mid">
            <div class="name"><?=$arResult['UF_MAIN_CAR']['MARK']['NAME']?> <?=$arResult['UF_MAIN_CAR']['MODEL']['NAME']?> (<?=$arResult['UF_MAIN_CAR']['NAME']?>)</div>
            <a href="<?=$arResult['UF_MAIN_CAR']['MODEL']['SECTION_PAGE_URL']?>" class="choice_l">История модели</a>
            <a href="<?=$arResult['UF_MAIN_CAR']['MARK']['SECTION_PAGE_URL']?>" class="choice_l">История марки</a>
        </div>
        <div class="btn-block">
            <a href="/?change=car" class="btn-c">Сменить</a>
            <a href="<?if($arResult['AUTORIZED']=="Y"):?>/personal/garazh/<?else:?>/login/?register=yes<?endif;?>" class="btn-c">В гараж</a>
        </div>
    </div>
</div>
<?endif;?>
<?//endif;?>
<?$this->EndViewTarget("lost_filter");?>
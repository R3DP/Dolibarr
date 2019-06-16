<?php

/*
 *  This file is part of SplashSync Project.
 *
 *  Copyright (C) 2015-2019 Splash Sync  <www.splashsync.com>
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

use Splash\Core\SplashCore as Splash;

//====================================================================//
// Create Setup Form
echo    '<form name="MainSetup" action="'.filter_input(INPUT_SERVER, "php_self").'" method="POST">';
echo    '<input type="hidden" name="token" value="'.$_SESSION['newtoken'].'">';
echo    '<input type="hidden" name="action" value="UpdateLocal">';

//====================================================================//
// Open Local Configuration Tab
dol_fiche_head(array(), null, $langs->trans("SPL_Local_Config"), 0, null);

echo '<table class="noborder" width="100%"><tbody>';

//====================================================================//
// Build Language Combo
$langcombo = '<select name="DefaultLang" id="DefaultLang" class="form-control" >';
$languages = $langs->get_available_languages();
ksort($languages);
foreach ($languages as $key => $value) {
    if ($conf->global->SPLASH_LANG == $key) {
        $langcombo .= '<option value="'.$key.'" selected="true">'.$value.'</option>';
    } else {
        $langcombo .= '<option value="'.$key.'">'.$value.'</option>';
    }
}
$langcombo .= '</select>';

echo '  <tr class="pair">';
echo '      <td>'.$langs->trans("SPL_DfLang").'</td>';
echo '      <td width="30%">'.$langcombo.'</td>';
echo '  </tr>';

//====================================================================//
// Build Other Languages MultiSelect
if ($conf->global->MAIN_MULTILANGS) {
    echo '  <tr class="pair">';
    echo '      <td>'.$langs->trans("SPL_OtherLangs").'</td>';
    echo '      <td width="30%">';
    echo $form->multiselectarray(
        "OtherLangs",
        $languages,
        unserialize($conf->global->SPLASH_LANGS)
    );
    echo '      </td>';
    echo '  </tr>';
}

//====================================================================//
// Default User Parameter
echo '  <tr class="impair">';
echo '      <td>'.$langs->trans("SPL_DfUser").'</td>';
echo '      <td>';
echo $form->select_dolusers($conf->global->SPLASH_USER, 'user', 1, null, 0, '', '', $conf->entity);
echo '      </td>';
echo '  </tr>';
//====================================================================//
// Default Warehouse Parameter
require_once(DOL_DOCUMENT_ROOT."/product/class/html.formproduct.class.php");
$formproduct = new FormProduct($db);
echo '  <tr class="pair">';
echo '      <td>'.$langs->trans("SPL_DfStock").'</td>';
echo '      <td>'.$formproduct->selectWarehouses($conf->global->SPLASH_STOCK, 'stock', '', 0).'</td>';
echo '  </tr>';
//====================================================================//
// Products Default Warehouse Parameter
echo '  <tr class="pair">';
echo '      <td>'.$langs->trans("SPL_ProductStock").'</td>';
echo '      <td>'.$formproduct->selectWarehouses($conf->global->SPLASH_PRODUCT_STOCK, 'product_stock', '', 1).'</td>';
echo '  </tr>';

//====================================================================//
// If multiprices are enabled
if (!empty($conf->global->PRODUIT_MULTIPRICES)) {
    //====================================================================//
    // Default Synchronized Product Price
    echo '  <tr class="pair">';
    echo '      <td>'.$langs->trans("SPL_DfMultiPrice").'</td>';
    echo '      <td>';

    print '<select name="price_level" class="flat">';
    for ($i = 1; $i <= $conf->global->PRODUIT_MULTIPRICES_LIMIT; $i++) {
        print '<option value="'.$i.'"' ;
        if ($i == $conf->global->SPLASH_MULTIPRICE_LEVEL) {
            print 'selected';
        }
        print '>'.$langs->trans('SellingPrice')." ".$i;
        $keyforlabel = 'PRODUIT_MULTIPRICES_LABEL'.$i;
        if (! empty($conf->global->{$keyforlabel})) {
            print ' - '.$langs->trans($conf->global->{$keyforlabel});
        }
        print '</option>';
    }
    print '</select>';

    echo '      </td>';
    echo '  </tr>';
}

echo '</tbody></table>';

//====================================================================//
// Close Local Configuration Tab
echo "</div>";

//====================================================================//
// Display Save Btn | Help Link
echo    '<div class="tabsAction">';
echo    '      <div class="inline-block" >';
echo    '           <a href="'.$langs->trans("SPL_Local_Help").'" target="_blank">';
echo    '               <i class="fa fa-external-link">&nbsp;</i>';
echo                    $langs->trans("SPL_Help_Msg").'<i class="fa fa-question">&nbsp;</i>';
echo    '           </a>';
echo    '       </div>';
echo    '       <input type="submit" class="butAction" align="right" value="'.$langs->trans("Save").'">';
echo    '</div>';

//====================================================================//
// Close Main Configuration Form
echo    "</form>";

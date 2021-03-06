<?php

/*
 *  This file is part of SplashSync Project.
 *
 *  Copyright (C) 2015-2020 Splash Sync  <www.splashsync.com>
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

//====================================================================//
// *******************************************************************//
// ACTIONS
// *******************************************************************//
//====================================================================//

//====================================================================//
// Update of Products Module Parameters
if ('UpdateMultiStock' == $action) {
    //====================================================================//
    // Update Server Expert Mode
    $multiStocks = GETPOST('MultiStock')?1:0;
    dolibarr_set_const($db, "SPLASH_MULTISTOCK", $multiStocks, 'int', 0, '', $conf->entity);
    header("location:".filter_input(INPUT_SERVER, "PHP_SELF"));
}

//====================================================================//
// Update of Products Module Parameters
if ('UpdateProducts' == $action) {
    //====================================================================//
    // Init DB Transaction
    $db->begin();

    $errors = 0;

    //====================================================================//
    // Update Default Stock
    $DfStock = GETPOST('stock', 'alpha');
    if ($DfStock) {
        if (dolibarr_set_const($db, "SPLASH_STOCK", $DfStock, 'chaine', 0, '', $conf->entity) <= 0) {
            $errors++;
        }
    }
    //====================================================================//
    // Update Products Default Stock
    $DfProductStock = GETPOST('product_stock', 'alpha');
    if ($DfProductStock) {
        if (dolibarr_set_const($db, "SPLASH_PRODUCT_STOCK", $DfProductStock, 'chaine', 0, '', $conf->entity) <= 0) {
            $errors++;
        }
    }
    //====================================================================//
    // Update Default MultiPrice
    $DfPrice = GETPOST('price_level', 'alpha');
    if ($DfPrice) {
        if (dolibarr_set_const($db, "SPLASH_MULTIPRICE_LEVEL", $DfPrice, 'chaine', 0, '', $conf->entity) <= 0) {
            $errors++;
        }
    }
    //====================================================================//
    // DB Commit & Display User Message
    if (! $error) {
        $db->commit();
        setEventMessage($langs->trans("SetupSaved"), 'mesgs');
    } else {
        $db->rollback();
        setEventMessage($langs->trans("Error"), 'errors');
    }
}

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
// Update of Local Module Parameters
if ('UpdateLocal' == $action) {
    //====================================================================//
    // Init DB Transaction
    $db->begin();

    $errors = 0;
    //====================================================================//
    // Update Default Lang
    $DfLang = GETPOST('DefaultLang', 'alpha');
    if ($DfLang) {
        if (dolibarr_set_const($db, "SPLASH_LANG", $DfLang, 'chaine', 0, '', $conf->entity) <= 0) {
            $errors++;
        }
    }

    //====================================================================//
    // Update Other Langs
    $OtherLangs = GETPOST('OtherLangs', 'alpha');
    if ($OtherLangs) {
        if (dolibarr_set_const($db, "SPLASH_LANGS", serialize($OtherLangs), 'chaine', 0, '', $conf->entity) <= 0) {
            $errors++;
        }
    }

    //====================================================================//
    // Update Default User
    $DfUser = GETPOST('user', 'alpha');
    if ($DfUser) {
        if (dolibarr_set_const($db, "SPLASH_USER", $DfUser, 'chaine', 0, '', $conf->entity) <= 0) {
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

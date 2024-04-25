<?php
// -----
// Part of the Customer: Tax-Exempt v2 plugin by lat9
// Copyright (C) 2019-2021, Vinos de Frutas Tropicales
//
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

define('CUSTOMER_TAX_EXEMPT_CURRENT_VERSION', '2.0.2');

// -----
// Wait until an admin is logged in before seeing if any initialization steps need to be performed.
//
if (isset($_SESSION['admin_id']) && defined('CUSTOMER_TAX_EXEMPT_VERSION') && CUSTOMER_TAX_EXEMPT_CURRENT_VERSION !== CUSTOMER_TAX_EXEMPT_VERSION) {
    // ----
    // If the plugin's version hasn't been recorded, it's either an initial installation or an
    // upgrade from a previous (v1) version.
    //
    if (!defined('CUSTOMER_TAX_EXEMPT_VERSION')) {
        $db->Execute(
            "INSERT INTO " . TABLE_CONFIGURATION . " 
                (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, set_function) 
             VALUES 
                ('Customer Tax-Exempt: Version', 'CUSTOMER_TAX_EXEMPT_VERSION', '0.0.0', 'The Customer: Tax-Exempt version number', 6, 100, now(), 'trim(')"
        );
        define('CUSTOMER_TAX_EXEMPT_VERSION', '0.0.0');
    }

    // -----
    // Version-update-specific changes
    //
    switch (true) {
        case version_compare(CUSTOMER_TAX_EXEMPT_VERSION, '2.0.0', '<'):
            // -----
            // Check for the presence of the customers::customers_tax_exempt field in the database.
            //
            // If the field doesn't exist, add it as a TEXT field.  
            //
            // Otherwise, check to see whether the field is *not* a TEXT field.  v1 of the plugin
            // defined the field as a varchar(32) one, which is inadequate to hold multiple tax-exemptions.
            //
            if (!$sniffer->field_exists(TABLE_CUSTOMERS, 'customers_tax_exempt')) {
                $db->Execute(
                    "ALTER TABLE " . TABLE_CUSTOMERS . " ADD customers_tax_exempt TEXT"
                );
            } elseif (!$sniffer->field_type(TABLE_CUSTOMERS, 'customers_tax_exempt', 'text')) {
                $db->Execute(
                    "ALTER TABLE " . TABLE_CUSTOMERS . " MODIFY customers_tax_exempt TEXT"
                );
            }
        default:                                                            //-Fall-through from above.
            break;
    }

    // -----
    // Update the configuration table to reflect the current version.
    //
    $db->Execute(
        "UPDATE " . TABLE_CONFIGURATION . " 
            SET configuration_value = '" . CUSTOMER_TAX_EXEMPT_CURRENT_VERSION . "' 
          WHERE configuration_key = 'CUSTOMER_TAX_EXEMPT_VERSION'
          LIMIT 1"
    );
}

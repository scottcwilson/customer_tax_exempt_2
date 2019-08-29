<?php
/**
 * functions_tax_exempt.php
 * functions used for Customer Tax Exempt
 *
 * @package functions
 * @copyright Copyright 2007-2008 Numinix http://www.numinix.com
 * @copyright Portions Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: functions_tax_exempt.php v1.12 2008-03-10 11:37:59Z numinix $
 */

// customer lookup of address book 
if (!function_exists('zen_get_customers_address_book')){
  function zen_get_customers_address_book($customer_id) { 
    global $db; 
    
    $customer_address_book_count_query = "SELECT c.*, ab.* from " . 
                                          TABLE_CUSTOMERS . " c 
                                          left join " . TABLE_ADDRESS_BOOK . " ab on c.customers_id = ab.customers_id 
                                          WHERE c.customers_id = '" . (int)$customer_id . "'"; 

    $customer_address_book_count = $db->Execute($customer_address_book_count_query); 
    return $customer_address_book_count; 
  }
}
  
?>
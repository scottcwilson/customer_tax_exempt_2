# UNINSTALL CUSTOMER TAX EXEMPT, v2
#
#
ALTER TABLE customers DROP COLUMN customers_tax_exempt;
DELETE FROM configuration WHERE configuration_key = 'CUSTOMER_TAX_EXEMPT_VERSION' LIMIT 1;
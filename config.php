<?php
// product Details
// Minimum amount is $0.50 US
$itemName = "Dmo Product";
$itemNumber = "PN12345";
$itemPrice = 25;
$currency = "USD";

// Stripe API configuration
define('STRIPE_API_KEY', 'sk_test_Z4j6EEDCNiTlE5eRBKn01qtW00pv2bFsEk');
define('STRIPE_PUBLISHABLE_KEY', 'pk_test_YbqlHlgLw4QgMFBDI91B1OmD00M8XOeINW');

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'stripe_payment_method');

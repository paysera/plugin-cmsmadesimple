<?php
$lang['info_test_settings'] = 'When test mode is enabled, the system will make test payments.';
$lang['testmode'] = 'Enable Test Mode?';
$lang['test_settings'] = 'Test Settings';
$lang['production_settings'] = 'Production Settings';

# C
$lang['checkout_button_message'] = 'Checkout';
$lang['checkout_message'] = 'Checkout with Paysera.com:';

# E
$lang['error_transaction_invalid_amount'] = 'An invalid (not the entire amount?) amount was received for a transaction';
$lang['error_transaction_invalid_currency'] = 'The currency received from the gateway does not match our selected currency';
$lang['error_ipn_invalid_data'] = 'Insufficient data was received from Paysera.com';
$lang['error_ipn_invalid_orderid'] = 'Invalid or missing order id';
$lang['error_ipn_verification_failed'] = 'Paysera.com transaction verification failed';
$lang['error_missing_custom_verifier'] = 'A code used to uniquely identify this transaction could not be found in the data returned from the payment gateway';
$lang['error_no_mcrypt'] = 'No encryption functionality found... this module will not function properly until mcrypt extensions are enabled';
$lang['error_retrieving_transaction_data'] = 'An error occurred trying to retrieve trsnsaction information from the gateway';
$lang['error_restoring_transaction_state'] = 'An error occurred trying to restore saved transaction information';
$lang['error_transaction_failed'] = 'Transaction failed';
$lang['error_transaction_id_missing'] = 'The transaction appeared to succeed, but we could not find a transaction id';

# F
$lang['form_template'] = 'Form Template';
$lang['friendlyname'] = 'Paysera Gateway';

# H
$lang['help'] = <<<EOT
<h3>What does it do?</h3>
  <p>This module is used by the Orders module to complete purchases using Paysera.com system. </p>
<h3>How Do I use It</h3>
<p>Create account at Paysera.com</p>
<p>Fill in required information in module panel.</p>
<p>Navigate to the preferences tab in the Orders module and select this module as your chosen payment gateway.</p>

<h3>Support</h3>
<p>If any problem occurs please contact support via integrate@paysera.com or skype evp_integrate (only on working hours).</p>
EOT;
$lang['help_order_id'] = 'Specifies the order id of the order we\'re try to complete.';


# M
$lang['moddescription'] = 'Part of the E-commerce collection, provide the ability to perform checkounts via Paysera';
$lang['msg_ipn_successful'] = 'IPN Transaction %s successful. Status: %s';
$lang['msg_transaction_cancelled'] = 'Transaction Cancelled';
$lang['msg_transaction_success'] = 'Received successfull transaction reply for %s';
$lang['msg_transaction_success_nopdt'] = 'Received successfull transaction reply for %s (PDT skipped)';
$lang['msg_transaction_waitingipn'] = 'Transaction %s marked as PENDING until Paysera.com confirmation arrives (%s)';

# O
$lang['online_purchase'] = 'Online Purchase';

# P
$lang['project_id'] = 'Your Paysera.com project ID';
$lang['project_pass'] = 'Your Paysera.com project password';
$lang['pdt_identity_token'] = 'PDT Identity Token';
$lang['postinstall'] = 'Paysera.com gateway module has now been installed.  You can select this gateway module from your Orders module preferences tab.';
$lang['postuninstall'] = 'Paysera.com gateway module has now been removed';
$lang['preferences'] = 'Preferences';
$lang['prompt_form_template'] = 'Edit the payment form template';

?>

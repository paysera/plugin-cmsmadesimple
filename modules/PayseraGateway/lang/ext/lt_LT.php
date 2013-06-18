<?php
$lang['info_test_settings'] = 'Testavimo režimas leidžia atlikti testinius mokėjimus.';
$lang['testmode'] = 'Įjungti testavimo režimą?';
$lang['test_settings'] = 'Testiniai nustatymai';
$lang['production_settings'] = 'Production Settings';

# C
$lang['checkout_button_message'] = 'Mokėti';
$lang['checkout_message'] = 'Mokėti per Mokėjimai.lt:';

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
<h3>Ką šis modulis daro?</h3>
<p>Šis modulis leidžia atsiskaityti už prekes per Mokėjimai.lt sistemą.</p>
<h3>Kaip naudotis</h3>
<p>Sukurkite projektą mokejimai.lt svetainėje.</p>
<p>Užpildykite modulioo informaciją administravimo skiltyje.</p>
<p>"Orders" modulyje pasirinkite šį modulį kaip mokėjimo būdą.</p>

<h3>Pagalba</h3>
<p>Jeigu kilo problemų prašome sisisiekti pagalba@mokejimai.lt el.paštu.</p>
EOT;
$lang['help_order_id'] = 'Nurodo užsakymo id.';


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
$lang['project_id'] = 'Jūsų Mokėjimai.lt projekto ID';
$lang['project_pass'] = 'Jūsų Mokėjimai.lt projekto slaptažodis';
$lang['pdt_identity_token'] = 'PDT Identity Token';
$lang['postinstall'] = 'Mokėjimai.lt modulis buvo sėkmingai įdiegtas. Jūs galite pasirinti šį modulį Orders modulio nustatymuose.';
$lang['postuninstall'] = 'Mokėjimai.lt modulis buvo ištrintas.';
$lang['preferences'] = 'Nustatymai';
$lang['prompt_form_template'] = 'Redaguoti mokėjimo formą.';
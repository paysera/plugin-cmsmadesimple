<?php

$cgpaymentgatewaybase = cms_join_path($gCms->config['root_path'], 'modules', 'CGPaymentGatewayBase', 'CGPaymentGatewayBase.module.php');
if (!is_readable($cgpaymentgatewaybase)) {
    echo '<h1><font color="red">ERROR: The CGPaymentGatewayBase module could not be found.  Please install it</font></h1>';
    return;
}
if (!class_exists('CGPaymentGatewayBase')) {
    require_once($cgpaymentgatewaybase);
}

class PayseraGateway extends CGPaymentGatewayBase {

    var $_data;

    /*---------------------------------------------------------
     Constructor()
     ---------------------------------------------------------*/
    function __construct() {
        parent::__construct();
        $this->_data = array();
    }

    /*---------------------------------------------------------
     GetName()
     ---------------------------------------------------------*/
    function GetName() {
        return 'PayseraGateway';
    }

    /*---------------------------------------------------------
     GetFriendlyName()
     ---------------------------------------------------------*/
    function GetFriendlyName() {
        return $this->Lang('friendlyname');
    }


    /*---------------------------------------------------------
     GetVersion()
     ---------------------------------------------------------*/
    function GetVersion() {
        return '1.6';
    }


    /*---------------------------------------------------------
     GetHelp()
     ---------------------------------------------------------*/
    function GetHelp() {
        return $this->Lang('help');
    }


    /*---------------------------------------------------------
     GetAuthor()
     ---------------------------------------------------------*/
    function GetAuthor() {
        return 'EVP International';
    }


    /*---------------------------------------------------------
     GetAuthorEmail()
     ---------------------------------------------------------*/
    function GetAuthorEmail() {
        return 'info@evp.lt';
    }


    /*---------------------------------------------------------
     GetChangeLog()
     ---------------------------------------------------------*/
    function GetChangeLog() {
        return @file_get_contents(dirname(__FILE__) . '/changelog.inc');
    }

    /*---------------------------------------------------------
     IsPluginModule()
     ---------------------------------------------------------*/
    function IsPluginModule() {
        return true;
    }


    /*---------------------------------------------------------
     HasAdmin()
     ---------------------------------------------------------*/
    function HasAdmin() {
        return true;
    }


    /*---------------------------------------------------------
     GetAdminSection()
     ---------------------------------------------------------*/
    function GetAdminSection() {
        global $CMS_VERSION;
        if (version_compare($CMS_VERSION, '1.8', '<')) return 'extensions';
        return 'ecommerce';
    }


    /*---------------------------------------------------------
     GetAdminDescription()
     ---------------------------------------------------------*/
    function GetAdminDescription() {
        return $this->Lang('moddescription');
    }


    /*---------------------------------------------------------
     VisibleToAdminUser()
     ---------------------------------------------------------*/
    function VisibleToAdminUser() {
        return $this->CheckPermission('Modify Templates') ||
        $this->CheckPermission('Modify Site Preferences');
    }


    /*---------------------------------------------------------
     GetDependencies()
     ---------------------------------------------------------*/
    function GetDependencies() {
        return array('CGExtensions'         => '1.28.1',
                     'CGPaymentGatewayBase' => '1.1');
    }


    /*---------------------------------------------------------
     MinimumCMSVersion()
     ---------------------------------------------------------*/
    function MinimumCMSVersion() {
        return "1.8.1";
    }


    /*---------------------------------------------------------
     SetParameters()
     ---------------------------------------------------------*/
    function SetParameters() {
        $this->RegisterModulePlugin();
        $this->RestrictUnknownParams();

        $this->RegisterRoute('/[Pp]aysera\/ipn\/(?P<returnid>[0-9]+)$/', array('action' => 'ipn'));
        $this->SetParameterType('process', CLEAN_STRING);
        $this->SetParameterType('order_id', CLEAN_INT);
        $this->SetParameterType('mycustom', CLEAN_STRING);
    }


    /*---------------------------------------------------------
     InstallPostMessage()
     ---------------------------------------------------------*/
    function InstallPostMessage() {
        return $this->Lang('postinstall');
    }


    /*---------------------------------------------------------
     UninstallPostMessage()
     ---------------------------------------------------------*/
    function UninstallPostMessage() {
        return $this->Lang('postuninstall');
    }


    /*---------------------------------------------------------
     UninstallPreMessage()
     ---------------------------------------------------------*/
    function UninstallPreMessage() {
        return $this->Lang('really_uninstall');
    }

    //////////////////////////////////////////////////
    // Begin methods required for payment gateways
    //////////////////////////////////////////////////


    /*---------------------------------------------------------
     RequiresCreditCardInfo()
     ---------------------------------------------------------*/
    function RequiresCreditCardInfo() {
        return false;
    }


    /*---------------------------------------------------------
     RequiresSSL()
     ---------------------------------------------------------*/
    function RequiresSSL() {
        return false;
    }


    /*---------------------------------------------------------
     RequiresShippingInfo()
     ---------------------------------------------------------*/
    function RequiresShippingInfo() {
        return false;
    }


    /*---------------------------------------------------------
     RequiresBillingInfo()
     ---------------------------------------------------------*/
    function RequiresBillingInfo() {
        return false;
    }


    /*---------------------------------------------------------
    SaveState()
     ---------------------------------------------------------*/
    function SaveState($encrypt = false, $key = '') {
        if ($encrypt) {
            if (empty($key)) $key = str_shuffle(md5(session_id() . time()));
            $raw                   = serialize($this->_data);
            $enc                   = $this->encrypt($key, $raw);
            $_SESSION['payseragw'] = base64_encode($enc);
            return $key;
        } else {
            $raw                   = serialize($this->_data);
            $_SESSION['payseragw'] = base64_encode($raw);
            return '';
        }
    }


    /*---------------------------------------------------------
     RestoreState()
     ---------------------------------------------------------*/
    function RestoreState($key = '') {
        if (!isset($_SESSION['payseragw'])) return FALSE;
        if (empty($key)) {
            $raw = base64_decode($_SESSION['payseragw']);
        } else {
            $enc = base64_decode($_SESSION['payseragw']);
            $raw = $this->decrypt($key, $enc);
            if ($raw === FALSE) return FALSE;
        }
        $this->_data = unserialize($raw);
        unset($_SESSION['payseragw']);
        return TRUE;
    }


    /*---------------------------------------------------------
     SetPaymentId()
     ---------------------------------------------------------*/
    public function SetPaymentId($payment_id) {
        $this->_data['payment_id'] = $payment_id;
    }


    /*---------------------------------------------------------
     GetPaymentId()
     ---------------------------------------------------------*/
    public function GetPaymentId() {
        if (!isset($this->_data['payment_id'])) return FALSE;
        return $this->_data['payment_id'];
    }


    /*---------------------------------------------------------
     SetCreditCardInfo()
     ---------------------------------------------------------*/
    function SetCreditCardInfo($ccnumber, $ccexp, $ccvcode) {
        return TRUE;
    }


    /*---------------------------------------------------------
     SetCurrencyCode()
     ---------------------------------------------------------*/
    function SetCurrencyCode($code = 'USD') {
        $this->_data['currencycode'] = strtoupper($code);
    }


    /*---------------------------------------------------------
     SetWeightUnits()
     ---------------------------------------------------------*/
    function SetWeightUnits($units = 'lbs') {
        $this->_data['weightunits'] = $units;
    }


    /*---------------------------------------------------------
     SetDestination()
     ---------------------------------------------------------*/
    function SetDestination($url) {
        $this->_data['destination'] = $url;
    }


    /*---------------------------------------------------------
     AddItem()
     ---------------------------------------------------------*/
    function AddItem($name, $number, $quantity, $weight, $amount, $tax = '') {
        $name = strip_tags($name);
        $name = html_entity_decode($name);
        $name = trim($name);
        if (!isset($this->_data['items'])) {
            $this->_data['items'] = array();
        }

        if (!isset($this->_items[$name])) {
            $this->_data['items'][$name] = array('name'     => $name,
                                                 'number'   => $number,
                                                 'quantity' => $quantity,
                                                 'weight'   => $weight,
                                                 'amount'   => $amount);
            if (!empty($tax)) {
                $this->_data['items'][$name]['tax'] = $tax;
            }
        }
    }


    /*---------------------------------------------------------
     SetOrderDescription()
     ---------------------------------------------------------*/
    function SetOrderDescription($txt) {
        $this->_data['description'] = substr($txt, 0, 255);
    }


    /*---------------------------------------------------------
     SetOrderObject()
     ---------------------------------------------------------*/
    function SetOrderObject(orders_order& $order) {
        $this->_data['order_obj'] = $order;
    }


    /*---------------------------------------------------------
     SetOrderTaxAmount()
     ---------------------------------------------------------*/
    function SetOrderTaxAmount($tax) {
        $this->_data['ordertax'] = $tax;
    }


    /*---------------------------------------------------------
     SetOrderShipping()
     ---------------------------------------------------------*/
    function SetOrderShipping($shipping) {
        $this->_data['ordershipping'] = $shipping;
    }


    /*---------------------------------------------------------
     SetInvoice()
     ---------------------------------------------------------*/
    function SetInvoice($invoice) {
        $this->_data['invoice'] = substr($invoice, -20);
    }


    /*---------------------------------------------------------
     SetOrderID()
     ---------------------------------------------------------*/
    function SetOrderID($orderid) {
        $this->_data['orderid'] = $orderid;
    }


    /*---------------------------------------------------------
     SetStatus()
     ---------------------------------------------------------*/
    function SetStatus($status) {
        switch ($status) {
            case PAYMENT_STATUS_NONE:
            case PAYMENT_STATUS_APPROVED:
            case PAYMENT_STATUS_DECLINED:
            case PAYMENT_STATUS_ERROR:
            case PAYMENT_STATUS_CANCELLED:
            case PAYMENT_STATUS_OTHER:
            case PAYMENT_STATUS_PENDING:
                $this->_data['status'] = $status;
                break;
        }
    }


    /*---------------------------------------------------------
     SetTransactionId()
     ---------------------------------------------------------*/
    function SetTransactionId($tid) {
        $this->_data['transaction_id'] = $tid;
    }


    /*---------------------------------------------------------
     SetError()
     ---------------------------------------------------------*/
    function SetError($message) {
        $this->_data['status']        = PAYMENT_STATUS_ERROR;
        $this->_data['error_message'] = $message;
    }


    /*---------------------------------------------------------
     SetCancelled()
     ---------------------------------------------------------*/
    function SetCancelled($message = '') {
        $this->_data['status'] = PAYMENT_STATUS_CANCELLED;
        if ($message) {
            $this->_data['error_message'] = $message;
        }
    }


    /*---------------------------------------------------------
     Reset()
     ---------------------------------------------------------*/
    function Reset() {
        $this->_data = array();
    }


    /*---------------------------------------------------------
     SetDeclined()
     ---------------------------------------------------------*/
    function SetDeclined($message) {
        $this->_data['status']        = PAYMENT_STATUS_DECLINED;
        $this->_data['error_message'] = $this->Lang('error_payment_declined');
    }


    /*---------------------------------------------------------
     GetTransactionStatus()
     ---------------------------------------------------------*/
    function GetTransactionStatus() {
        /*if( isset($this->_data['status']) )
          return $this->_data['status'];
        return FALSE;*/
        return PAYMENT_STATUS_PENDING;
    }


    /*---------------------------------------------------------
     GetTransactionId()
     ---------------------------------------------------------*/
    function GetTransactionId() {
        if (isset($this->_data['transaction_id']))
            return $this->_data['transaction_id'];
        return FALSE;
    }


    /*---------------------------------------------------------
     GetMessage()
     ---------------------------------------------------------*/
    function GetMessage() {
        if (isset($this->_data['error_message']))
            return $this->_data['error_message'];
        return FALSE;
    }


    /*---------------------------------------------------------
     FinishTransaction()
     ---------------------------------------------------------*/
    function FinishTransaction() {
        if (!isset($this->_data['destination'])) return FALSE;
        $key = $this->SaveState(true);
        $url = $this->_data['destination'];
        $url = html_entity_decode($url);
        $url .= "&cntnt01datakey=" . $key;

        redirect($url);
    }


    /*---------------------------------------------------------
     CheckInfo()
     ---------------------------------------------------------*/
    function CheckInfo() {
        return true;
    }


    /*---------------------------------------------------------
     GetForm()
     ---------------------------------------------------------*/
    function GetForm($returnid) {

        require_once '/vendor/webtopay/libwebtopay/WebToPay.php';
        if (!$this->CheckInfo()) return FALSE;

        global $gCms;
        $config = $gCms->GetConfig();

        $key = $this->SaveState(true);
        $url = WebToPay::PAY_URL;

        $parms    = array();
        $URL      = array();
        $amount   = 0;
        $quantity = 1;
        $price    = 0;
        $address  = & $this->_data['billing_address'];
        $items    = & $this->_data['items'];
        $lang     = get_site_preference('frontendlang');

        //index.php?page=checkout
        $URL['accept']   = $this->CreateLink('cntnt01', 'return_success', $returnid, '', array('order_id' => $this->_data['orderid'], 'mycustom' => $key), '', true);
        $URL['cancel']   = $this->CreateLink('cntnt01', 'return_cancel', $returnid, '', array('order_id' => $this->_data['orderid'], 'mycustom' => $key), '', true);
        $URL['callback'] = $config['root_url'] . '/modules/PayseraGateway/callback.php';

        foreach ($items as $key => $value) {
            foreach ($value as $k => $v) {
                if ($k == 'quantity') {
                    $quantity = $v;
                }
                if ($k == 'amount') {
                    $amount = $v;
                }
            }
            $price += $amount * $quantity;
        }

        foreach ($URL as $k => $v) {
            $URL[$k] = str_replace('&amp;', '&', $v);
        }
        try {
            $request = WebToPay::buildRequest(array(
                'projectid'     => $this->GetPreference('prod_id'),
                'sign_password' => $this->GetPreference('prod_pass'),

                'orderid'       => $this->_data['orderid'],
                'amount'        => intval(number_format($price, 2, '', '')),
                'currency'      => $this->_data['currencycode'],
                'lang'          => ($lang == 'lt_LT') ? 'LIT' : 'ENG',

                'accepturl'     => $URL['accept'],
                'cancelurl'     => $URL['cancel'],
                'callbackurl'   => $URL['callback'],

                'payment'       => '',
                'country'       => $address->get_country(),

                'logo'          => '',
                'p_firstname'   => $address->get_firstname(),
                'p_lastname'    => $address->get_lastname(),
                'p_email'       => $address->get_email(),
                'p_street'      => $address->get_address1() . ' ' . $address->get_address2(),
                'p_city'        => $address->get_city(),
                'p_state'       => $address->get_state(),
                'p_zip'         => $address->get_postal(),
                //'p_countrycode' => $p_countrycode,
                'test'          => $this->GetPreference('testmode'),
            ));
        } catch (WebToPayException $e) {
            echo get_class($e) . ': ' . $e->getMessage();
        }

        // give everything to smarty
        $smarty =& $gCms->GetSmarty();
        $smarty->assign('posturl', $url);
        $smarty->assign('checkout_text', $this->Lang('checkout_message'));

        $lang == 'lt_LT' ? $img = '/images/icon.gif' : $img = '/images/paysera_button.gif';
        $smarty->assign('image_url', $config['root_url'] . '/modules/' . $this->GetName() . $img);

        $str = '';
        $fmt = '<input type="hidden" name="%s" value="%s"/>' . "\n";


        foreach ($request as $key => $value) {
            $str .= sprintf($fmt, $key, (string)$value);
        }

        $smarty->assign('formvalues', $str);

        return $this->ProcessTemplateFromDatabase('form_template');
    }


    /*---------------------------------------------------------
     SetBillingAddress()
     ---------------------------------------------------------*/
    public function SetBillingAddress(orders_address& $billing_addy) {
        if (!$billing_addy instanceof cge_address) {
            return FALSE;
        }
        $this->_data['billing_address'] = $billing_addy;
    }


    /*---------------------------------------------------------
     SetShippingAddress()
     ---------------------------------------------------------*/
    public function SetShippingAddress(orders_address& $shipping_addy) {
        if (!$shipping_addy instanceof cge_address) {
            return FALSE;
        }
        $this->_data['shipping_address'] = $shipping_addy;
    }


    /*---------------------------------------------------------
     GetTransactionAmount()
     ---------------------------------------------------------*/
    public function GetTransactionAmount() {
        if (isset($this->_data['amount']))
            return $this->_data['amount'];
        return FALSE;
    }


    /*---------------------------------------------------------
     SetTransactionAmount()
     ---------------------------------------------------------*/
    public function SetTransactionAmount($tid) {
        $this->_data['amount'] = $tid;
    }

} // class

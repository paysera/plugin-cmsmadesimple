<?php
	if( !isset($gCms) ) exit;
	global $gCms;
    $config = $gCms->GetConfig();
	
	$this->Audit('',$this->GetName().':return_success',$this->Lang('msg_transaction_success_nopdt',$txn_id));
    $this->SetStatus(PAYMENT_STATUS_PENDING);
    //$this->SetTransactionID($_REQUEST['cntnt01mycustom']);
    //$this->SetTransactionAmount($_REQUEST['cntnt01mycustom']);
    //$this->SetPaymentId();
    
    $this->_data['destination'] = $config['root_url'].'/index.php?mact=Orders,cntnt01,gateway_complete,0&cntnt01order_id='.$_REQUEST['cntnt01order_id'].'&cntnt01returnid='.$_REQUEST['cntnt01returnid'];
    $this->FinishTransaction();
?>
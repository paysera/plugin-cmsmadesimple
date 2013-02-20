<?php

if( !isset($gCms) ) exit;

if( !isset($params['mycustom']) )
  {
    $this->SetError($this->Lang('error_missing_custom_verifier'));
    $this->Audit('',$this->GetName(),$this->Lang('error_missing_custom_verifier'));
  }
else if( !isset($params['order_id']) )
  {
    $this->SetError($this->Lang('error_ipn_invalid_orderid'));
    $this->Audit('',$this->GetName(),$this->Lang('error_ipn_invalid_orderid'));
  }
  
$this->RestoreState($params['mycustom']);
$this->Audit('',$this->GetName(),$this->lang('msg_transaction_cancelled'));

$config = $gCms->GetConfig();
header("Location: ".$confi['root_url']."index.php?page=orders");

// EOF
?>

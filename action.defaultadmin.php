<?php

if( !isset($gCms) ) exit;

// do functionality tests
if( !function_exists('mcrypt_module_open') )
  {
    echo $this->ShowErrors($this->Lang('error_no_mcrypt'));
    return;
  }

// start tabs.
echo $this->StartTabHeaders();
if( $this->CheckPermission('Modify Templates') )
  {
    echo $this->SetTabHeader('template',$this->Lang('form_template'));
  }
if( $this->CheckPermission('Modify Site Preferences') )
  {
    echo $this->SetTabHeader('prefs',$this->Lang('preferences'));
  }
echo $this->EndTabHeaders();


echo $this->StartTabContent();
if( $this->CheckPermission('Modify Templates') )
  {
    echo $this->StartTab('template');
    include(dirname(__FILE__).'/function.template_tab.php');
    echo $this->EndTab();
  }
if( $this->CheckPermission('Modify Site Preferences') )
  {
    // handle the form
    if (isset($params['submit'])) {
		$this->SetPreference('testmode',(int)$params['testmode']);
		$this->SetPreference('prod_id',trim($params['prod_id']));
		$this->SetPreference('prod_pass',trim($params['prod_pass']));
	}

    echo $this->StartTab('prefs');
    $smarty->assign('formstart', $this->CGCreateFormStart($id, 'defaultadmin', $returnid));
    $smarty->assign('formend', $this->CreateFormEnd());
    
    $smarty->assign('testmode',$this->GetPreference('testmode',0));
    $smarty->assign('prod_id',$this->GetPreference('prod_id'));
    $smarty->assign('prod_pass',$this->GetPreference('prod_pass'));

    $smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', lang('submit')));

    $contentops 	= $gCms->GetContentOperations();
    $the_returnid 	= $contentops->GetDefaultContent();
    $pretty_url 	= "webtopay/ipn/$the_returnid";
    $ipn_url 		= $this->CreateURL($id,'ipn',$the_returnid,array(),false,$pretty_url);
    $smarty->assign('ipn_url',$ipn_url);

    echo $this->ProcessTemplate('prefs.tpl');
    echo $this->EndTab();
  }

echo $this->EndTabContent();
// EOF
?>

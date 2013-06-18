<?php

if( !isset($gCms) ) exit;

echo cge_template_admin::get_single_template_form($this,$id,$returnid,
						  'form_template',
						  'template',
						  $this->Lang('prompt_form_template'),
						  'orig_form_template.tpl');
#
# EOF
#
?>
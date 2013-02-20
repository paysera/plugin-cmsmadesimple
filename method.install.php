<?php

$fn = dirname(__FILE__).'/templates/orig_form_template.tpl';
$data = @file_get_contents($fn);
$this->SetTemplate('form_template',$data);

# EOF
?>

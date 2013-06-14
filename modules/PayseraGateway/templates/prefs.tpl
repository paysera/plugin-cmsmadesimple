{$formstart}

<fieldset>
<legend>{$mod->Lang('production_settings')}</legend>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('project_id')}</p>
  <p class="pageinput">
    <input type="text" name="{$actionid}prod_id" size="50" maxlength="255" value="{$prod_id}"/>
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('project_pass')}</p>
  <p class="pageinput">
    <input type="text" name="{$actionid}prod_pass" size="50" maxlength="255" value="{$prod_pass}"/>
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('testmode')}</p>
  <p class="pageinput">
    {cge_yesno_options prefix=$actionid name=testmode selected=$testmode}
  </p>
</div>
</fieldset>
<div class="pageoverflow">
  <p class="pagetext">&nbsp;</p>
  <p class="pageinput">{$submit}</p>
</div>
{$formend}

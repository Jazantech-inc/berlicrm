{*<!--
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/
-->*}
{strip}
<div class="container-fluid">
	<div class="widget_header row-fluid">
		<h3>{vtranslate($MODULE, $QUALIFIED_MODULE)}</h3>
	</div>
	<hr>
	<div class="row-fluid">
		<span class="span2 btn-toolbar">
			<button class="btn btn-success" type="submit" name="exportUserByTime" id="exportUserByTime"><strong>{vtranslate('LBL_EXPORT_BY_TIME', $QUALIFIED_MODULE)}</strong></button>
		</span>
		<span class="span2 btn-toolbar">
			<button class="btn btn-success" type="submit" name="exportUserByName" id="exportUserByName"><strong>{vtranslate('LBL_EXPORT_BY_USER', $QUALIFIED_MODULE)}</strong></button>
		</span>
	</div>
	<div class="row-fluid">
		<span class="span8 btn-toolbar">
				<select class="chzn-select" id="usersFilter" >
					<option value="">{vtranslate('LBL_ALL', $QUALIFIED_MODULE)}</option>
					{foreach item=USERNAME key=USER from=$USERSLIST}
						<option value="{$USER}" name="{$USERNAME}" {if $USERNAME eq $SELECTED_USER} selected {/if}>{$USERNAME}</option>
					{/foreach}
				</select>
		</span>
		<span class="span4 btn-toolbar">
			{include file='ListViewActions.tpl'|@vtemplate_path:$QUALIFIED_MODULE}
		</span>
	</div>
	<div class="clearfix"></div>
	<div class="listViewContentDiv" id="listViewContents">
{/strip}
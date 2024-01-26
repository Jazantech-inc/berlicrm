﻿<!DOCTYPE html>
<head>
<!-- the following header content gets only loaded with a direct http call-->
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<meta charset="utf-8">
<link REL="SHORTCUT ICON" HREF="../../layouts/vlayout/modules/crmtogo/resources/images/favicon.ico">	
<script type="text/javascript" src="../../layouts/vlayout/modules/crmtogo/resources/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="../../layouts/vlayout/modules/crmtogo/resources/jquery.mobile-1.4.5.min.js"></script>
<script type="text/javascript" src="../../layouts/vlayout/modules/crmtogo/resources/getScrollcontent.js"></script>
<link rel="stylesheet" href="../../layouts/vlayout/modules/crmtogo/resources/css/jquery.mobile.icons.min.css" >
<link rel="stylesheet" href="../../layouts/vlayout/modules/crmtogo/resources/css/theme.css" >
<script type="text/javascript" src="../../layouts/vlayout/modules/crmtogo/resources/lang/{$LANGUAGE}.lang.js"></script>
{literal}
	<!-- define the collapsible button size-->
	<style>	
	.collapse_header .ui-btn-text{
		font-size: 10px
	}
	</style>
{/literal}
</head>
<body>
<div data-role="page" data-theme="b" >
	<div data-role="header" data-theme="{$COLOR_HEADER_FOOTER}"  data-position="fixed">
		<h4>{vtranslate('LBL_RELATED_LIST', 'crmtogo')}</h4>
		<a href="#"  onclick="window.history.back()" class="ui-btn ui-btn-right ui-corner-all ui-icon-back ui-btn-icon-notext">{vtranslate('LBL_CANCEL', 'crmtogo')}</a>
	</div>
	<div data-role="collapsible-set">
	{assign var=relListRecords value=$_RECORDS->getResult()}
	{if $relListRecords eq ''}
		<div data-role="main" class="ui-content">
			<label> {vtranslate('LBL_NO_RELATEDLIST', 'crmtogo')}</label>
		</div>
	{else}
	{foreach item=_RECORD key=_MODULE from=$relListRecords}
		<div data-role="collapsible" data-collapsed="true">
			<h3>{$_MODULE|@getTranslatedString:$_MODULE}</h3>
			<div class="ui-collapsible-content ui-body-c ui-corner-bottom" aria-hidden="false">
				<ul class="ui-listview" data-role="listview">
						{foreach item=_FIELD from=$_RECORD}
							<li >
								<a class="ui-btn ui-btn-icon-right ui-icon-carat-r" href="?_operation=fetchRecord&record={$_FIELD.relatedlistcontent.id}&lang={$LANGUAGE}" target="_self">{$_FIELD.relatedlistcontent.0}{if $_FIELD.relatedlistcontent.1 neq ''}, {$_FIELD.relatedlistcontent.1}
								{/if}
								</a>
							</li>
						{/foreach}
				</ul>
			</div>
		</div>
	{/foreach}
	{/if}
	</div>
	<div data-role="footer" data-theme="{$COLOR_HEADER_FOOTER}" data-position="fixed">
		<h1></h1>
	</div>	
</div>
</body>
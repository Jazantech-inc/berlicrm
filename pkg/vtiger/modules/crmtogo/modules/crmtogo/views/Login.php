<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

include_once dirname(__FILE__) . '/../api/ws/Login.php';

class crmtogo_UI_Login  extends crmtogo_WS_Login {

	function process(crmtogo_API_Request $request) {
		$default_config = $this->getConfigDefaults();
		$default_lang_strings = return_module_language($default_config['language'], 'crmtogo');
		$viewer= new crmtogo_UI_Viewer();
		$viewer->assign('LANGUAGE', $default_lang_strings);
		$viewer->assign('COLOR_HEADER_FOOTER', $default_config['theme']);
		return $viewer->process('Login.tpl');
	}
}
<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Emails_Module_Model extends Vtiger_Module_Model{

	/**
	 * Function to check whether the module is an entity type module or not
	 * @return <Boolean> true/false
	 */
	public function isQuickCreateSupported() {
		//emails module is not enabled for quick create
		return false;
	}

	public function isWorkflowSupported() {
		return false;
	}

	/**
	 * Function to check whether the module is summary view supported
	 * @return <Boolean> - true/false
	 */
	public function isSummaryViewSupported() {
		return false;
	}
	
	/**
	 * Function to get emails related modules
	 * @return <Array> - list of modules 
	 */	
	public function getEmailRelatedModules() {
		$userPrivModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
		
		$relatedModules = vtws_listtypes(array('email'), Users_Record_Model::getCurrentUserModel());
		$relatedModules = $relatedModules['types'];

		foreach ($relatedModules as $key => $moduleName) {
			if ($moduleName === 'Users') {
				unset($relatedModules[$key]);
			}
		}
		foreach ($relatedModules as $moduleName) {
			$moduleModel = Vtiger_Module_Model::getInstance($moduleName);
			if($userPrivModel->isAdminUser() || $userPrivModel->hasGlobalReadPermission() || $userPrivModel->hasModulePermission($moduleModel->getId())) {
				$emailRelatedModules[] = $moduleName;
			}
		}
		$emailRelatedModules[] = 'Users';

		// since we need a Verteiler module, and his emails, we need to add it 
		if( vtlib_isModuleActive('Verteiler') === true ){
			$emailRelatedModules[] = 'Verteiler';
		}
		

		return $emailRelatedModules;
	}

	/**
	 * Function to search emails for send email
	 * @param <String> $searchValue
	 * @return <Array> Result of searched emails
	 */
	public function searchEmails($searchValue) {
		$emailsResult = array();
		$db = PearDatabase::getInstance();
		$currentUserModel = Users_Record_Model::getCurrentUserModel();
		$emailSupportedModulesList = $this->getEmailRelatedModules();

		foreach ($emailSupportedModulesList as $moduleName) {
			$searchFields = array();
			$moduleModel = Vtiger_Module_Model::getInstance($moduleName);
			$emailFieldModels = $moduleModel->getFieldsByType('email');

			foreach ($emailFieldModels as $fieldName => $fieldModel) {
				if ($fieldModel->isViewable()) {
					$searchFields[] = $fieldName;
				}
			}
			$emailFields = $searchFields;

			$nameFields = $moduleModel->getNameFields();
			foreach ($nameFields as $index => $fieldName) {
				$fieldModel = Vtiger_Field_Model::getInstance($fieldName, $moduleModel);
				if ($fieldModel->isViewable()) {
					$searchFields[] = $fieldName;
				} else {
					unset($nameFields[$index]);
				}
			}

			if ($emailFields) {
				$moduleInstance = CRMEntity::getInstance($moduleName);
				$queryGenerator = new QueryGenerator($moduleName, $currentUserModel);
				$listFields = $searchFields;
				$listFields[] = 'id';
				$queryGenerator->setFields($listFields);
                                
                                //Opensource fix for showing up deleted records on email search
                                $queryGenerator->startGroup(""); 
				foreach ($searchFields as $key => $emailField) {
					$queryGenerator->addCondition($emailField, trim($searchValue), 'c', 'OR');
				}

                                $queryGenerator->endGroup(); 
				$result = $db->pquery($queryGenerator->getQuery(), array());
				$numOfRows = $db->num_rows($result);

				for($i=0; $i<$numOfRows; $i++) {
					$row = $db->query_result_rowdata($result, $i);
					foreach ($emailFields as $emailField) {
						$emailFieldValue = html_entity_decode($row[$emailField]);
						if (!empty($emailFieldValue)) {
							$arr_recordLabel = array();
							foreach ($nameFields as $fieldName) {
								$arr_recordLabel[] = html_entity_decode($row[$fieldName]);
							}
							$recordLabel = implode(" ", $arr_recordLabel);
							$emailsResult[vtranslate($moduleName, $moduleName)][$row[$moduleInstance->table_index]][]
								= array('value'	=> $emailFieldValue,
										'label'	=> $recordLabel . ' <b>('.$emailFieldValue.')</b>');
							//found one matching instance, no need to check other fields
							break;
						}
					}
				}
			}
		}
		return $emailsResult;
	}
	
	/**
	 * Function to get orderby sql from orderby field
	 */
	public function getOrderBySql($orderBy){
		 if($orderBy == 'date_start'){
			 return "CONCAT($orderBy, ' ', time_start)";
		 }
		 return parent::getOrderBySql($orderBy);
	}
}
?>

<?php
/*+*******************************************************************************
 *  The contents of this file are subject to the vtiger CRM Public License Version 1.0
 *  ("License"); You may not use this file except in compliance with the License
 *  The Original Code is:  vtiger CRM Open Source
 *  The Initial Developer of the Original Code is vtiger.
 *  Portions created by vtiger are Copyright (C) vtiger.
 *  All Rights Reserved.
 ******************************************************************************** */

/**
 * Function to get the field information from module name and field label
 */
function getFieldByReportLabel($module, $label) {
	$cacheLabel = VTCacheUtils::getReportFieldByLabel($module, $label);
	if($cacheLabel) return $cacheLabel;

	// this is required so the internal cache is populated or reused.
	getColumnFields($module);
	//lookup all the accessible fields
	$cachedModuleFields = VTCacheUtils::lookupFieldInfo_Module($module);
	$label = decode_html($label);
	
	if($module == 'Calendar') {
		$cachedEventsFields = VTCacheUtils::lookupFieldInfo_Module('Events');
		if ($cachedEventsFields) {
			if(empty($cachedModuleFields)) $cachedModuleFields = $cachedEventsFields;
			else $cachedModuleFields = array_merge($cachedModuleFields, $cachedEventsFields);
		}
		if($label == 'Start_Date_and_Time') {
			$label = 'Start_Date_&_Time';
		}
	}
	
	if(empty($cachedModuleFields)) {
		return null;
	}
    
	foreach ($cachedModuleFields as $fieldInfo) {
		$fieldLabel = str_replace(' ', '_', $fieldInfo['fieldlabel']);
        $fieldLabel = decode_html($fieldLabel);
		if($label == $fieldLabel) {
			VTCacheUtils::setReportFieldByLabel($module, $label, $fieldInfo);
			return $fieldInfo;
		}
	}
	return null;
}

function isReferenceUIType($uitype) {
	static $options = array('101', '116', '117', '26', '357',
		'50', '51', '52', '53', '57', '58', '59', '66', '68',
		'73', '75', '76', '77', '78', '80', '81'
	);

	if(in_array($uitype, $options)) {
		return true;
	}
	return false;
}

function IsDateField($reportColDetails) {
	list($tablename, $colname, $module_field, $fieldname, $typeOfData) = explode(":", $reportColDetails);
	if ($typeOfData == "D") {
		return true;
	} else {
		return false;
	}
}

/**
 *
 * @global Users $current_user
 * @param ReportRun $report
 * @param Array $picklistArray
 * @param ADOFieldObject $dbField
 * @param Array $valueArray
 * @param String $fieldName
 * @return String
 */
function getReportFieldValue ($report, $picklistArray, $dbField, $valueArray, $fieldName) {
	global $current_user, $default_charset;

	$db = PearDatabase::getInstance();
	$value = $valueArray[$fieldName];
	$fld_type = $dbField->type;
	list($module, $fieldLabel) = explode('_', $dbField->name, 2);
	$fieldInfo = getFieldByReportLabel($module, $fieldLabel);
	$fieldType = null;
	$fieldvalue = $value;
	if(!empty($fieldInfo)) {
		$field = WebserviceField::fromArray($db, $fieldInfo);
		$fieldType = $field->getFieldDataType();
	}

	if ($fieldType == 'currency' && $value != '') {
		// Some of the currency fields like Unit Price, Total, Sub-total etc of Inventory modules, do not need currency conversion
		if($field->getUIType() == '72') {
			$curid_value = explode("::", $value);
			$currency_id = $curid_value[0];
			$currency_value = $curid_value[1];
			$cur_sym_rate = getCurrencySymbolandCRate($currency_id);
			if($value!='') {
				if(($dbField->name == 'Products_Unit_Price')) { // need to do this only for Products Unit Price
					if ($currency_id != 1) {
						$currency_value = (float)$cur_sym_rate['rate'] * (float)$currency_value;
					}
				}

				$formattedCurrencyValue = CurrencyField::convertToUserFormat($currency_value, null, true);
				$fieldvalue = CurrencyField::appendCurrencySymbol($formattedCurrencyValue, $cur_sym_rate['symbol']);
			}
		} else {
			$currencyField = new CurrencyField($value);
			$fieldvalue = $currencyField->getDisplayValue();
		}
	//crm-now: assuming this is one of those calculated fields of vtiger_inventoryproductrel table
	} elseif (empty($fieldInfo) && empty($dbField->orgtable) && is_numeric($value)) {
		$currencyField = new CurrencyField($value);
		$fieldvalue = $currencyField->getDisplayValue();
	} elseif ($dbField->name == "PurchaseOrder_Currency" || $dbField->name == "SalesOrder_Currency"
				|| $dbField->name == "Invoice_Currency" || $dbField->name == "Quotes_Currency" || $dbField->name == "PriceBooks_Currency") {
		if($value!='') {
			$fieldvalue = getTranslatedCurrencyString($value);
		}
	} elseif (in_array($dbField->name,$report->ui101_fields) && !empty($value)) {
		$entityNames = getEntityName('Users', $value);
		$fieldvalue = $entityNames[$value];
	} elseif( $fieldType == 'date' && !empty($value)) {
		if($module == 'Calendar' && $field->getFieldName() == 'due_date') {
			$endTime = $valueArray['calendar_end_time'];
			if(empty($endTime)) {
				$recordId = $valueArray['calendar_id'];
				$endTime = getSingleFieldValue('vtiger_activity', 'time_end', 'activityid', $recordId);
			}
			$date = new DateTimeField($value.' '.$endTime);
			$fieldvalue = $date->getDisplayDate();
		} else if(!($field->getUIType() == '5'||$field->getUiType() =='23')) {
            $date = new DateTimeField($fieldvalue);
            $fieldvalue = $date->getDisplayDateTimeValue();
		}
	} elseif( $fieldType == "datetime" && !empty($value)) {
		$date = new DateTimeField($value);
		$fieldvalue = $date->getDisplayDateTimeValue();
	} elseif( $fieldType == 'time' && !empty($value) && $field->getFieldName()
			!= 'duration_hours') {
		if($field->getFieldName() == "time_start" || $field->getFieldName() == "time_end") {
			$date = new DateTimeField($value);
			$fieldvalue = $date->getDisplayTime();
		} else {
			$userModel = Users_Privileges_Model::getCurrentUserModel();
			if($userModel->get('hour_format') == '12'){
				$value = Vtiger_Time_UIType::getTimeValueInAMorPM($value);
			}
			$fieldvalue = $value;
		}
	} elseif( $fieldType == "picklist" && !empty($value) ) {
		if(is_array($picklistArray)) {
			if(is_array($picklistArray[$dbField->name]) &&
					$field->getFieldName() != 'activitytype' && !in_array(
					$value, $picklistArray[$dbField->name])){
				$fieldvalue =$app_strings['LBL_NOT_ACCESSIBLE'];
			} else {
				$fieldvalue = getTranslatedString($value, $module);
			}
		} else {
			$fieldvalue = getTranslatedString($value, $module);
		}
	} elseif( $fieldType == "multipicklist" && !empty($value) ) {
		if(is_array($picklistArray[1])) {
			$valueList = explode(' |##| ', $value);
			$translatedValueList = array();
			foreach ( $valueList as $value) {
				if(is_array($picklistArray[1][$dbField->name]) && !in_array(
						$value, $picklistArray[1][$dbField->name])) {
					$translatedValueList[] =
							$app_strings['LBL_NOT_ACCESSIBLE'];
				} else {
					$translatedValueList[] = getTranslatedString($value,
							$module);
				}
			}
		}
		if (!is_array($picklistArray[1]) || !is_array($picklistArray[1][$dbField->name])) {
			$fieldvalue = str_replace(' |##| ', ', ', $value);
		} else {
			$fieldvalue = implode(', ', $translatedValueList);
		}
	} 
	elseif ($fieldType == 'double') {
		$fieldvalue = NumberField::convertToUserFormat($fieldvalue, null, false);
    }
	if($fieldvalue == "") {
		return "-";
	}
	$fieldvalue = str_replace("<", "&lt;", $fieldvalue);
	$fieldvalue = str_replace(">", "&gt;", $fieldvalue);
	$fieldvalue = decode_html($fieldvalue);

	if (stristr($fieldvalue, "|##|") && empty($fieldType)) {
		$fieldvalue = str_ireplace(' |##| ', ', ', $fieldvalue);
	} elseif ($fld_type == "date" || $fieldType == 'date') {
		$fieldvalue = DateTimeField::convertToUserFormat($fieldvalue);
	} elseif ($fld_type == "datetime" || $fieldType == 'datetime') {
		$date = new DateTimeField($fieldvalue);
		$fieldvalue = $date->getDisplayDateTimeValue();
	}

	// Added to render html tag for description fields
	if($fieldInfo['uitype'] == '19' && ($module == 'Documents' || $module == 'Emails')) {
		return $fieldvalue;
	}
	return htmlentities($fieldvalue, ENT_QUOTES, $default_charset);
}

?>

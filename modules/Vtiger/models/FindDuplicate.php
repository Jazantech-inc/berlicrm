<?php
/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */

class Vtiger_FindDuplicate_Model extends Vtiger_Base_Model {

	public function setModule($moduleModel) {
		$this->module = $moduleModel;
	}

	public function getModule() {
		return $this->module;
	}

	function getListViewHeaders() {
		$db = PearDatabase::getInstance();
		$moduleModel = $this->getModule();
		$listViewHeaders = array();
		$listViewHeaders[] = new Vtiger_Base_Model(array('name' => 'recordid', 'label' => 'Record Id'));
		$headers = $db->getFieldsArray($this->result);
		foreach($headers as $header) {
			$fieldModel = $moduleModel->getFieldByColumn($header);
			if($fieldModel) {
				$listViewHeaders[] = $fieldModel;
			}
		}
		return $listViewHeaders;
	}

	function getListViewEntries(Vtiger_Paging_Model $paging) {
        $db = PearDatabase::getInstance();
        $moduleModel = $this->getModule();
        $module = $moduleModel->getName();

        $fields = $this->get('fields');
        $fieldModels = $moduleModel->getFields();
        if(is_array($fields)) {
            foreach($fields as $fieldName) {
                $fieldModel = $fieldModels[$fieldName];
                $tableColumns[] = $fieldModel->get('table').'.'.$fieldModel->get('column');
            }
        }

        $startIndex = $paging->getStartIndex();
        $pageLimit = $paging->getPageLimit();
		$ignoreEmpty = $this->get('ignoreEmpty');

        $focus = CRMEntity::getInstance($module);
        $query = $focus->getQueryForDuplicates($module, $tableColumns, '', $ignoreEmpty);

		$query .= " LIMIT $startIndex, ". ($pageLimit+1);
		
		$result = $db->pquery($query, array());
        $rows = $db->num_rows($result);
        $this->result = $result;

        $group = 'group0';
        $temp = $fieldValues = array(); $groupCount = 0;
        $groupRecordCount = 0;
        $entries = array();
        for($i=0; $i<$rows; $i++) {
			$entries[] = $db->query_result_rowdata($result, $i);
		}

		$paging->calculatePageRange($entries);

        if ($rows > $pageLimit) {
			array_pop($entries);
            $paging->set('nextPageExists', true);
        } else {
            $paging->set('nextPageExists', false);
        }
		$rows = count($entries);

		for ($i=0; $i<$rows; $i++) {
			$row = $entries[$i];
            if($i != 0) {
                $slicedArray = array_slice($row, 2);
                array_walk($temp, 'lower_array');
                array_walk($slicedArray, 'lower_array');
                $arrDiff = array_diff($temp, $slicedArray);
                if(count($arrDiff) > 0) {
                    $groupCount++;
                    $temp = $slicedArray;
                    $groupRecordCount = 0;
                }
                $group = "group".$groupCount;
            }
            $fieldValues[$group][$groupRecordCount]['recordid'] = $row['recordid'];
            foreach($row as $field => $value) {
                if($i == 0 && $field != 'recordid') $temp[$field] = $value;
                $fieldModel = $fieldModels[$field];
                $resultRow[$field] = $value;
            }
            $fieldValues[$group][$groupRecordCount++] = $resultRow;
        }

        return $fieldValues;
    }

	public static function getInstance($module) {
		$self = new self();
		$moduleModel = Vtiger_Module_Model::getInstance($module);
		$self->setModule($moduleModel);
		return $self;
	}

	public function getRecordCount() {
		if($this->rows) {
			$rows = $this->rows;
		} else {
			$db = PearDatabase::getInstance();

			$moduleModel = $this->getModule();
			$module = $moduleModel->getName();
			$fields = $this->get('fields');
			$fieldModels = $moduleModel->getFields();
			if(is_array($fields)) {
				foreach($fields as $fieldName) {
					$fieldModel = $fieldModels[$fieldName];
					$tableColumns[] = $fieldModel->get('table').'.'.$fieldModel->get('column');
				}
			}
			$focus = CRMEntity::getInstance($module);
			$ignoreEmpty = $this->get('ignoreEmpty');
			$query = $focus->getQueryForDuplicates($module, $tableColumns, '', $ignoreEmpty);

			$pos = stripos($query, ' from ');
            if ($pos !== false) {
                $query = 'SELECT count(*) AS count' . substr($query,$pos); 
            }
			$result = $db->pquery($query, array());
			$rows = $db->query_result($result, 0, 'count');

		}
		return $rows;
	}
    
    public function getMassDeleteRecords(Vtiger_Request $request) {
       
        $db = PearDatabase::getInstance();
        $module = $request->getModule();
        $moduleModel = Vtiger_Module_Model::getInstance($module);

        $fields = $request->get('fields');
        $ignoreEmpty = $request->get('ignoreEmpty');
		$ignoreEmptyValue = false;
		if($ignoreEmpty == 'on')
            $ignoreEmptyValue = true;

        $fieldModels = $moduleModel->getFields();
        if(is_array($fields)) {
            foreach($fields as $fieldName) {
                $fieldModel = $fieldModels[$fieldName];
                $tableColumns[] = $fieldModel->get('table').'.'.$fieldModel->get('column');
            }
        }

        $focus = CRMEntity::getInstance($module);
        $query = $focus->getQueryForDuplicates($module, $tableColumns, '', $ignoreEmpty);
        $result = $db->pquery($query, array());
        
        $recordIds = array();
        for($i = 0; $i < $db->num_rows($result) ; $i++) {
            $recordIds[] = $db->query_result($result, $i, 'recordid');
        }
        
        $excludedIds = $request->get('excluded_ids');
        $recordIds = array_diff($recordIds, $excludedIds);
        
        return $recordIds;
    }
}
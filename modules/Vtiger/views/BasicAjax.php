<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Vtiger_BasicAjax_View extends Vtiger_Basic_View {

	function __construct() {
		parent::__construct();
		$this->exposeMethod('showAdvancedSearch');
		$this->exposeMethod('showSearchResults');
	}

	function checkPermission() { }

	function preProcess(Vtiger_Request $request, $display = false) {
		return true;
	}

	function postProcess(Vtiger_Request $request) {
		return true;
	}

	function process(Vtiger_Request $request) {
		$mode = $request->get('mode');
		if(!empty($mode)) {
			$this->invokeExposedMethod($mode, $request);
		}
		return;
	}

	/**
	 * Function to display the UI for advance search on any of the module
	 * @param Vtiger_Request $request
	 */
	function showAdvancedSearch(Vtiger_Request $request) {
		//Modules for which search is excluded
		$excludedModuleForSearch = array('Vtiger', 'Reports');

		$viewer = $this->getViewer($request);
		$moduleName = $request->getModule();
		
		if($request->get('source_module')) {
			$moduleName = $request->get('source_module');
		}
        
		$saveFilterPermitted = true;
        $saveFilterexcludedModules =  array('ModComments','RSS','Portal','Integration','PBXManager','DashBoard');
        if(in_array($moduleName, $saveFilterexcludedModules)){
            $saveFilterPermitted = false;
        }
        
		//See if it is an excluded module, If so search in home module
		if(in_array($moduleName, $excludedModuleForSearch)) {
			$moduleName = 'Home';
		}
		$module = $request->getModule();

		$customViewModel = new CustomView_Record_Model();
        $customViewModel->setModule($moduleName);
		$moduleModel = Vtiger_Module_Model::getInstance($moduleName);
		$recordStructureInstance = Vtiger_RecordStructure_Model::getInstanceForModule($moduleModel);

		$viewer->assign('SEARCHABLE_MODULES', Vtiger_Module_Model::getSearchableModules());
		$viewer->assign('CUSTOMVIEW_MODEL', $customViewModel);
		
		if($moduleName == 'Calendar'){
			$advanceFilterOpsByFieldType = Calendar_Field_Model::getAdvancedFilterOpsByFieldType();
		} else{
			$advanceFilterOpsByFieldType = Vtiger_Field_Model::getAdvancedFilterOpsByFieldType();
		}
		$viewer->assign('ADVANCED_FILTER_OPTIONS', Vtiger_Field_Model::getAdvancedFilterOptions());
		$viewer->assign('ADVANCED_FILTER_OPTIONS_BY_TYPE', $advanceFilterOpsByFieldType);
        $dateFilters = Vtiger_Field_Model::getDateFilterTypes();
        foreach($dateFilters as $comparatorKey => $comparatorInfo) {
            $comparatorInfo['startdate'] = DateTimeField::convertToUserFormat($comparatorInfo['startdate']);
            $comparatorInfo['enddate'] = DateTimeField::convertToUserFormat($comparatorInfo['enddate']);
            $comparatorInfo['label'] = vtranslate($comparatorInfo['label'],$module);
            $dateFilters[$comparatorKey] = $comparatorInfo;
        }
        $viewer->assign('DATE_FILTERS', $dateFilters);
		$viewer->assign('RECORD_STRUCTURE', $recordStructureInstance->getStructure());
		$viewer->assign('SOURCE_MODULE',$moduleName);
        $viewer->assign('SOURCE_MODULE_MODEL', $moduleModel);
		$viewer->assign('MODULE', $module);
        
        $viewer->assign('SAVE_FILTER_PERMITTED', $saveFilterPermitted);

		echo $viewer->view('AdvanceSearch.tpl',$moduleName, true);
	}

	/**
	 * Function to display the Search Results
	 * @param Vtiger_Request $request
	 */
	function showSearchResults(Vtiger_Request $request) {
		$db = PearDatabase::getInstance();

		$viewer = $this->getViewer($request);
		$moduleName = $request->getModule();
		$advFilterList = $request->get('advfilterlist');
		
		$allResultCount = 0;
		$rowsLimit = 0;

		//used to show the save modify filter option
		$isAdvanceSearch = false;
		$matchingRecords = array();
		if(is_array($advFilterList) && count($advFilterList) > 0) {
			$isAdvanceSearch = true;

			$pageNumber = $request->get('page');
			if(empty ($pageNumber)){
				$pageNumber = '1';
			}
			$pagingModel = new Vtiger_Paging_Model();
			$pagingModel->set('page', $pageNumber);
			$pagingModel->set('viewid', $request->get('viewname'));
			$pageLimit = $pagingModel->getPageLimit();
			if(empty ($pageLimit) || !(is_numeric($pageLimit)) ||  $pageLimit < 0){
				$pageLimit = 0;
			}
			else if( is_numeric($pageLimit) && $pageLimit >= 0){
				if($pageLimit > 2){
					$pageLimit = ceil($pageLimit / 2);
				}
			}
			$rowsLimit = $pageLimit;

			$user = Users_Record_Model::getCurrentUserModel();
			$queryGenerator = new QueryGenerator($moduleName, $user);
			$queryGenerator->setFields(array('id'));
          
            vimport('~~/modules/CustomView/CustomView.php');
            $customView = new CustomView($moduleName);
            $dateSpecificConditions = $customView->getStdFilterConditions();

			foreach ($advFilterList as $groupindex=>$groupcolumns) {
				$filtercolumns = $groupcolumns['columns'];
				if(count($filtercolumns) > 0) {
					$queryGenerator->startGroup('');
					foreach ($filtercolumns as $index=>$filter) {
						$nameComponents = explode(':',$filter['columnname']);
						if(empty($nameComponents[2]) && $nameComponents[1] == 'crmid' && $nameComponents[0] == 'vtiger_crmentity') {
							$name = $queryGenerator->getSQLColumn('id');
						} else {
							$name = $nameComponents[2];
						}
                        if(($nameComponents[4] == 'D' || $nameComponents[4] == 'DT') && in_array($filter['comparator'], $dateSpecificConditions)) {
                            $filter['stdfilter'] = $filter['comparator'];
                            $valueComponents = explode(',',$filter['value']);
                            if($filter['comparator'] == 'custom') {
                                $filter['startdate'] = DateTimeField::convertToDBFormat($valueComponents[0]);
                                $filter['enddate'] = DateTimeField::convertToDBFormat($valueComponents[1]);
                            }
                            $dateFilterResolvedList = $customView->resolveDateFilterValue($filter);
                            $value[] = $queryGenerator->fixDateTimeValue($name, $dateFilterResolvedList['startdate']);
                            $value[] = $queryGenerator->fixDateTimeValue($name, $dateFilterResolvedList['enddate'], false);
                            $queryGenerator->addCondition($name, $value, 'BETWEEN');
                        }else{
                            $queryGenerator->addCondition($name, $filter['value'], $filter['comparator']);
                        }
						$columncondition = $filter['column_condition'];
						if(!empty($columncondition)) {
							$queryGenerator->addConditionGlue($columncondition);
						}
					}
					$queryGenerator->endGroup();
					$groupConditionGlue = $groupcolumns['condition'];
					if(!empty($groupConditionGlue))
						$queryGenerator->addConditionGlue($groupConditionGlue);
				}
			}
			$query = $queryGenerator->getQuery();
			//Remove the ordering for now to improve the speed
			//$query .= ' ORDER BY createdtime DESC';
			$result = $db->pquery($query, array());
			$rows = $db->num_rows($result);

			$allResultCount = $rows;
			if($rows > $rowsLimit){
				$rows = $rowsLimit;
			}

			for($i=0; $i<$rows; ++$i) {
				$row = $db->query_result_rowdata($result, $i);
				$recordInstance = Vtiger_Record_Model::getInstanceById($row[0]);
				$moduleName = $recordInstance->getModuleName();
				$matchingRecords[$moduleName][$row[0]] = $recordInstance;
			}
			$viewer->assign('SEARCH_MODULE', $moduleName);
		} else {
			$searchKey = $request->get('value');
			$searchModule = false;
			
			if($request->get('searchModule')) {
				$searchModule = $request->get('searchModule');
			}
			
			$viewer->assign('SEARCH_KEY', $searchKey);
			$viewer->assign('SEARCH_MODULE', $searchModule);
			$matchingRecords =  Vtiger_Record_Model::getSearchResult($searchKey, $searchModule);
		}
		
		$matchingRecordsList = array();
		if ($matchingRecords[$moduleName]) {
			$matchingRecordsList[$moduleName] = $matchingRecords[$moduleName];
		}
		foreach ($matchingRecords as $module => $recordModelsList) {
			$matchingRecordsList[$module] = $recordModelsList;
		}

		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('MATCHING_RECORDS', $matchingRecordsList);
		$viewer->assign('IS_ADVANCE_SEARCH', $isAdvanceSearch);
		$viewer->assign('ALL_RESULT_COUNT', $allResultCount);
		$viewer->assign('ROWS_LIMIT', $rowsLimit);

		echo $viewer->view('UnifiedSearchResults.tpl', '', true);
	}	
}
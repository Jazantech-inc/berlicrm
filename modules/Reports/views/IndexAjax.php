<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Reports_IndexAjax_View extends Vtiger_Index_View {

	function __construct() {
		parent::__construct();
		$this->exposeMethod('showActiveRecords');
		$this->exposeMethod('showScheduledReports');
	}

	function preProcess(Vtiger_Request $request, $display=false) {
		return true;
	}

	function postProcess(Vtiger_Request $request) {
		return true;
	}

	function process(Vtiger_Request $request) {
		$mode = $request->get('mode');
		if(!empty($mode)) {
			$this->invokeExposedMethod($mode, $request);
			return;
		}
	}

	/*
	 * Function to show the recently modified or active records for the given module
	 */
	function showActiveRecords(Vtiger_Request $request) {
		$viewer = $this->getViewer($request);
		$moduleName = $request->getModule();

		$moduleModel = Vtiger_Module_Model::getInstance($moduleName);
		$recentRecords = $moduleModel->getRecentRecords();

		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('RECORDS', $recentRecords);

		echo $viewer->view('RecordNamesList.tpl', $moduleName, true);
	}

	function getRecordsListFromRequest(Vtiger_Request $request) {
		$cvId = $request->get('cvid');
		$selectedIds = $request->get('selected_ids');
		$excludedIds = $request->get('excluded_ids');

		if(!empty($selectedIds) && $selectedIds != 'all') {
			if(!empty($selectedIds) && count($selectedIds) > 0) {
				return $selectedIds;
			}
		}

		$customViewModel = CustomView_Record_Model::getInstanceById($cvId);
		if($customViewModel) {
            $searchKey = $request->get('search_key');
            $searchValue = $request->get('search_value');
            $operator = $request->get('operator');
            if(!empty($operator)) {
                $customViewModel->set('operator', $operator);
                $customViewModel->set('search_key', $searchKey);
                $customViewModel->set('search_value', $searchValue);
            }
			return $customViewModel->getRecordIds($excludedIds);
		}
	}

	/*
	 * Function to show the scheduled reports
	 */
	function showScheduledReports(Vtiger_Request $request) {
		require_once ('modules/Reports/ScheduledReports.php');
		$current_user = Users_Record_Model::getCurrentUserModel();
		$is_admin = $current_user->get('is_admin');
		$viewer = $this->getViewer($request);

		$moduleName = $request->getModule();
		$scheduledReportsModel = new Reports_ScheduleReports_Model();
		$scheduledReports = $scheduledReportsModel->getScheduledReports(true);
		
		// cron should be finished at least 10 minutes before next cron starts
		$cronFrequency = $scheduledReportsModel->getCronFrequency();
		$cronStopLimit = date('H:i',$cronFrequency -600);


		$nextRunTime = $scheduledReportsModel->getNextRunTime();
		$lastStartDateTime = $scheduledReportsModel->getLastStartDateTime();

		$currentDateTime = Vtiger_Datetime_UIType::getDisplayDateTimeValue(date('Y-m-d H:i:s'));

		$timeDiffInMinutes = date('H:i',(strtotime($currentDateTime) - strtotime($lastStartDateTime)));
		
		// button control: show button if status 2 lasts longer than frequency - 10 minutes
		$showCronResetButton = false;
		if (strtotime($timeDiffInMinutes) > strtotime($cronStopLimit)) {
			$showCronResetButton = true;
		}

		$scheduledReportInfo = array();
		foreach ($scheduledReports as $scheduledReportsObj) {
			$reportid = $scheduledReportsObj->get('reportid');
			$detailViewModel = Reports_DetailView_Model::getInstance($moduleName, $reportid);
			$reportModel = $detailViewModel->getRecord();
			$reportModel->setModule('Reports');
			$reportname = $reportModel->get('reportname');
			$next_trigger_time = $scheduledReportsObj->get('next_trigger_time');
			$next_time = DateTimeField::convertToUserFormat($next_trigger_time);
			$scheduledReportInfo [$reportid] = array('reportname'=>$reportname , 'next_time'=>$next_time);
		}
		$cronStatus = $scheduledReportsModel->cronStatus();
		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('CRONSTATUS', $cronStatus);
		$viewer->assign('SCHEDULEDREPORTS', $scheduledReportInfo);
		$viewer->assign('ISADMIN', $is_admin);
		$viewer->assign('NEXTTIME', $nextRunTime);
		$viewer->assign('LASTTIME', $lastStartDateTime);
		$viewer->assign('SHOWBUTTON', $showCronResetButton);
		$viewer->assign('RUNNINGTIME', $timeDiffInMinutes);
		$viewer->assign('CRONFREQUENCYLIMIT', $cronStopLimit);

		echo $viewer->view('ScheduledReportsList.tpl', $moduleName, true);
	}
	

}
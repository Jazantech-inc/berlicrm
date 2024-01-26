<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/
$languageStrings = array(
	'ModuleName' => 'Module Name',
	'LBL_CUSTOM_INFORMATION' => 'Custom Information',
	'LBL_MODULEBLOCK_INFORMATION' => 'Module Block Information',
	'ModuleFieldLabel' => 'Module Field Label Text',
	'SINGLE_Mailchimp' => 'MailChimp Group',
    'LBL_LOAD_LIST' => 'load list',
	
	'LBL_CAMPAIGN'=>'CRM Group: ',
	'LBL_GET_ALL' => 'Get all contacts or leads on this list which were synchronized.',
	'LBL_SHOW_HIDE_QUERY'=>'Show / Hide Query',
	'LBL_ADD_BATCH'=>'Adding to batch ...',
	'LBL_SHOW_HIDE_RESULTS'=>'Show / Hide Results',
	'LBL_GET_ALL_LAST_SYNC'=>'Get contacts and leads which have been added since the last synchronization.',
	'LBL_REMOVE_DUPLICATES'=>'Removing any duplicates in the batch.',
	'LBL_SEND_MAILCHIMP'=>'Sending to Mailchimp ...',
	'LBL_BATCH_FAILED'=>'Batch subscribe failed!',
	'LBL_ERROR_CODE'=>'Error Code:',
	'LBL_ERROR_MSG'=>'Error Message:',
	'LBL_SUCCESS'=>'Success:',
	'LBL_ERRORS'=>'Errors:',
	'LBL_GET_REMOVE_MEMBER_LAST_SYNC'=>'Getting members which have been deleted since the last synchronization.',
	'LBL_REMOVE_FROM_MAILCHIMP'=>'Removing from Mailchimp ...',
	'LBL_FAILED'=>'failed',
	'LBL_GET_MAILCHIP_COMP_NAME'=>'Getting name of Mailchimp group.',
	'LBL_MAILCHIMP_EXPORT_API'=>'Query Mailchimp export API',
	'LBL_REMOVE_CONTACTS_ACCOUNTS_MAILCHIMP'=>'Removing contacts/ leads from the Mail group.',
	'LBL_GET_ALL_MEMBERS_VTIGER_MAILCHAMP'=>'Getting all the members of this CRM Mailchimp group.',
	'LBL_GET_VTIGER_ENTITY_IDS'=>'Getting CRM entity IDs of Mailchimp subscribers.',
	'LBL_LIST_MAILCHIMP_USERS'=>'Mailchimp list subscribers:',
	'LBL_VTIGER_CAMPIN_MEMBERS'=>'Members of CRM group:',
	'LBL_REMOVE_ENTITYS_FROM_VTIGER'=>'Entities to remove from CRM group:',
	'LBL_NEW_LOCAL_ENTRIES_TO_EXPORT'=>'New local entries to export:',
	'LBL_FINISHED_AFTER'=>'Synchronization end since %s seconds.',
	'LBL_DELETE_LAST_SYNCDATE'=>'Deleting the last synchronization date in order to make a full synchronization.',
	'LBL_GET_LAST_SYNCDATE'=>'Getting last synchronization date.',
	'LBL_START_ADD_CONTACTS'=>'Starting process of adding contact or lead to a mail group, if it doesn\'t exist, we create it in the CRM....',
	'LBL_LIST_OF_EMAIL_ADDRESS'=>'Creating a list of email addresses from batch.',
	'LBL_CHECK_EMAIL_EXIST'=>'Checking if there any of the email addresses already exist in the database.',
	'LBL_LATE_ADDING_IF_EMAIL_IN_DB'=>'Add a missing contact/lead entry to the CRM.',
	'LBL_LATE_ADD_RELATION'=>'Check whether a contact/lead exists in the MailChimp group.',
	'LBL_CHECK_EMAIL_LIST_AND_ADD'=>'If the record\'s email address is in the MailChimp list but not in the CRM, create a new contact or lead entry, and add the new contact / lead to this CRM Mailchimp group.',
	'LBL_UPDATE_DIFF'=>'Update the last CRM synchronization date and finish synchronization.',
	'LBL_LINK_MAILCHIMP'=>'Click here to return to the Mailchimp group page.',
	
	'LBL_SETUP_MODULE'=>'Set up your module to enable the synchronization with MailChimp',
	
	'LBL_ENTER_APP_KEY'=>'Please enter your MailChimp API key',
	'LBL_MAILCHIMP_SETTINGS'=>'MailChimp Settings',
	'LBL_MAILCHIMP_LIST_ID'=>'Please enter your Mailchimp List ID',
	'LBL_CREATE_AS'=>'Select whether Mailchimp subscribers are<br />created as Contacts or Leads in the CRM',
	'LBL_CONTACTS'=>'Contacts',
	'LBL_LEADS'=>'Leads',
	'LBL_SAVE'=>'Save',
	'LBL_SECCESSFULL_SAVE'=>'Successfully saved',
	'LBL_FAIL_SAVE'=>'Can not get saved',
	'LBL_SAVE_PROCESS'=>'Saving in process...',
	
	'LBL_EXTRACING'=>'Extracting headers and set the salutation field if it does not exist.',
	'LBL_EXTRACING_ONLY_MEMBERS'=>'Get the members of this Mailchimp group, which are assigned to this CRM group (default is set) and which had been added since last synchronization.',
	'LBL_RETURNED_MEMBER' =>'Number of Mailchimp entries which are related to the CRM entries: ',
	
	'Starting Synchronization'=> 'Starting Synchronization',
	'LBL_START_SYNC'=> 'Starting Synchronization',
	'LBL_WORK_MAILCHIMP'=>'Process Mailchimp Entries',
	'unsubscribed'=>'unsubscribed',

	'LBL_BACK_TO_CRM'=>'go back to Mailchimp module',
	'GO_TO_MAILCHIMP'=>'go to Mailchimp page',

	'Synchronize with MailChimp' => 'Synchronize with MailChimp',
	'MailChimp Campaign Information'=>'MailChimp group information',
	'LBL_GROUP_INFO'=>'MailChimp group information',
	'CampaignName'=> 'Group Name',
	'Last Synchronization'=>'Last Synchronization',
	'Description Information' => 'Description Information',
	'Select One'=>'please select a list',
	'Campaign No'=>'Group Id',
	'Campaign Type'=>'Group Type',
	'Campaign Status' => 'Group Status',
	'ERROR_NEW_GROUP' =>'Error with create new group in Mailchimp, please contact the CRM administrator',
	'BAD_RESPONSE'=>'Bad Response.  Got this: ',
	'NO_ERROR_FOUND'=>'No error message was found',
	'RESPONSE_TIME_OUT'=>'Could not read response (timed out)',
	'NO_CONNECT'=>'Could not connect (ERR',
	'LBL_MAILCHIMP_INFO'=>'Mailchimp information',
	'LBL_SYNC_HISTORY'=>'Mailchimp Synchronisation History',
	'LBL_START_SYNC_BTN'=>'Start Synchronisation',
	'LBL_NONE'=>'--None--',
	'LBL_LISTE'=>'MailChimp lists ',
	'GROUPS_ADD'=>'add groups list ',
	'GROUPS_NOT_ADD'=>'can not add groups list, the groups list already exists or an error occurred by creating groups list',
	'LBL_GROUPS'=>'Groups',
	'LBL_GROUPE'=>'CRM Group Name',
	'LBL_NEW_GROUP'=>'New Group Name',
	'LBL_SYNC'=>'Synchronisation',

	'type'=>'Type',
	'status'=>'Status',
	'description'=>'Description',
	'LBL_CRM_NONE_DELETED'=>'Since last synchronization no CRM entries were deleted from this list.',
	'LBL_LAST_SYNC_DATE'=>'last synchronization for this list: ',
	'LBL_REMOVE_ID'=>'The following entries had been removed from the CRM list since they were removed from the Mailchimp list:',
	'LBL_PROTCOLL'=>'Synchronisation Protocol',
	'LBL_WORK_CRM'=>'Process CRM entries',
	'LBL_CHECK_DATA'=>'Check, whether someone had been removed from the CRM list since last synchronization.',
	'LBL_NO_MS_CHANGE'=>'Since last synchronisation no one had been removed from the MailChimp list (unsubsribed or deleted).',
	'LBL_LAST_GROUP_SYNC'=>'Last synchronisation of this group: ',
	'LBL_CREATE_FIELD'=>'created in MailChimp',
	'LBL_NO_MS_ADD'=>'Since last synchronization no existing CRM contact or leads had been added to MailChimp.',
	'LBL_MS_ADD'=>'Since last synchronization MailChimp entries had been added which exist already as contact or lead entries at the CRM:',
	//added for unsubscribed listings
	'LBL_CHECK_UNSUBSCRIBED'=>'Check, who unsubscribed from this MailChimp list.',
	'LBL_NO_UNSUBSCRIBED'=>'Nobody unsubscribed from this list.',
	'LBL_LIST_UNSUBSCRIBED'=>'The following entries had been removed from the Mailchimp list:',
	'LBL_REASON_UNSUBSCRIBED'=>'Reason provided:',
	'LBL_NO_REASON_UNSUBSCRIBED'=>'no reason had been provided',

	//added for sync dates
	'LBL_UPDATE_TIME_GROUP'=>'Updated synchronization time for this Mailchimp group.',
	'LBL_UPDATE_TIME_LIST'=>'Updated synchronization time for this CRM list.',
	'LBL_EMPTY_LOG'=>'Empty Log Display',
	
	'LBL_CHECK_DATA_MC'=>'Check, who was removed from the MailChimp list.',
	'LBL_SELECT_TO_LOAD_LIST'=>'select list',
	'LBL_FIELD_EXISTS'=>'Column exists in Mailchimp',
	'Planning'=>'planned',
	'Inactive'=>'inactive',
	'Completed'=>'completed',
	'LBL_NO_CRM_CHANGES'=>'There are no changes since the last synchronization date.',
	'LBL_UPDATED'=>'updated',
	'LBL_NEW_CREATED'=>'created',
	'LBL_EMPTY_MAIL'=>'You have removed a contact from your list which does not have an email address. Please enter any email address for this contact, synchronize and remove it again.',
	'LBL_PLEASE_WAIT'=>'Please wait. Depending on the size of your list, the next operation can take up to 15 minutes.',
	'LBL_FIRST_SYNC'=>'This is your very first synchronization of this list.',
	'LBL_MOVE_TO_MAILCHIMP'=>'All CRM data from the related lists are getting transferred to Mailchimp.',
	'LBL_MOVE_ALL_FROM_MAILCHIMP'=>'All Mailchimp data are getting transferred to the CRM.',
	'LBL_MOVE_PARTIAL_FROM_MAILCHIMP'=>'New Mailchimp data are getting transferred to the CRM.',
	'LBL_CRM_LIST_EMPTY'=>'Your related contacts and leads lists are empty.',
	'LBL_FIRST_SYNC'=>'This is your first synchronization for this list.',
	'LBL_CRM_LIST_EMPTY'=>'There is no data to be transferred from the CRM to Mailchimp.',
	'LBL_NO_REMOVED_MEMBER_LAST_SYNC'=>'Since the last synchronization nothing was removed from the CRM list.',
	'LBL_NO_NOTSUBSCRIBED'=>'Number of entries in the Mailchimp list which are not subscribed:',

	'LBL_INTERESTGROUP_FAILED'=>'No group (interests) was created in Mailchimp. Please create there. Otherwise synchronization is not possible!',
	
	'LBL_EXISTING_CONTACTS_ADDED'=>'Added existing contacts to the CRM group:',
	'LBL_EXISTING_LEADS_ADDED'=>'Added existing leads to CRM group:',
	'LBL_UPDATED_ENTRIES'=>'Entries updated with changed attributes:',
	'LBL_NEW_CONTACTS_IMPORTED'=>'New contacts created and added to the Mailchimp group of the CRM group:',
	'LBL_NEW_LEADS_IMPORTED'=>'New leads created and added to the CRM group\'s Mailchimp group:',
	'LBL_BROKEN_CONTACTS'=>'<br><b>The following elected contacts do not have an email address:</b> ',
	'LBL_BROKEN_LEADS'=>'<br><b>The following selected leads do not have an email address:</b> ',

	'LBL_VERBOSE'=>'verbose output',		
	'LBL_VERBOSELOG_DELETE'=>'CRM-entry &raquo;%s&laquo; deleted, <b>DELETE ON Mailchimp</b>',
	'LBL_VERBOSELOG_NOEXPORTONOPTOUT'=>'CRM-entry &raquo;%s&laquo; not yet on Mailchimp, but set EmailOptOut. <b>NO EXPORT</b>',
	'LBL_VERBOSELOG_DELETEDREMOTELY'=>'CRM-entry &raquo;%s&laquo; on Mailchimp deleted. <b>REMOVE FROM CRM GROUP</b>',
	'LBL_VERBOSELOG_EXPORT'=>'CRM-entry &raquo;%s&laquo; not in Mailchimp group yet. <b>EXPORT</b>',
	'LBL_VERBOSELOG_ADDTOCRMGROUP'=>'Mailchimp-entry &raquo;%s&laquo; present in the CRM, but not in this group. <b>ADD TO CRM GROUP</b>',
	'LBL_VERBOSELOG_TEST4IMPORT'=>'Mailchimp-entry &raquo;%s&laquo; not available in CRM.',
	'LBL_VERBOSELOG_INACTIVE'=>'Mailchimp-entry &raquo;%s&laquo; is not in CRM and inactive. <b>skip</b>',
	'LBL_VERBOSELOG_TYPEBLOCKED'=>'Mailchimp-entry &raquo;%s&laquo; is blocked in CRM for type &raquo;%s&laquo;. <b>skip</b>',
	'LBL_VERBOSELOG_INCOMPLETE'=>' is incomplete!',
	'LBL_VERBOSELOG_DOIMPORT'=>' <b>IMPORT</b>',
	'LBL_VERBOSELOG_DONTIMPORT'=>' <b>NO IMPORT</b>',
	'LBL_VERBOSELOG_HAVEENTRY'=>'Mailchimp-entry &raquo;%s&laquo; already in the CRM group &raquo;%s&laquo; present.',
	'LBL_VERBOSELOG_UNSUBSCRIBED'=>' <b>SIGNED OUT on %s</b>',
	'LBL_VERBOSELOG_BOUNCED'=>' <b>BOUNCED, banned since %s</b>',
	'LBL_VERBOSELOG_ATTRIBCHANGED'=>' Attributes changed!',
	'LBL_VERBOSELOG_OPTOUT'=>' Active despite EmailOptOut!',
	'LBL_VERBOSELOG_DOUPDATE'=>' <b>UPDATE Mailchimp</b>',
	'LBL_VERBOSELOG_DONTUPDATE'=>' <b>NO CHANGE</b>',
	
	'LBL_UPDATEPROGRESS'=>'<b>Please wait</b>: %s of %s entries updated...',
	'LBL_DELETEPROGRESS'=>'<b>Please wait</b>: %s of %s entries deleted...',
	'LBL_IMPORTPROGRESS'=>'<b>Please wait</b>: %s of %s entries imported...',
	'LBL_EXPORTPROGRESS'=>'<b>Please wait</b>: %s of %s entries exported...',
	
	'LBL_API_ERROR'=>'Bad Mailchimp API response. Please try again.',
	'LBL_API_TIMEOUT_ACT'=>'Please try again.',
	'LBL_API_AUTH_ERROR'=>'API unauthorized!',
	'LBL_API_AUTH_ERROR_ACT'=>'Please check your Mailchimp settings here.',
	'LBL_API_CONNECTED_TO'=>'Successfully connected to Mailchimp API account #%s of %s %s.',

	'LBL_GOT_ALL_MEMBERS_CRM_MAILCHIMP'=>'All entries of the CRM group &raquo;%s&laquo; (ID %s) loaded.',
	'LBL_GOT_ALL_MEMBERS_MAILCHIMP_API'=>'All entries of the Mailchimp group &raquo;%s&laquo; (ID %s) loaded.',
	'LBL_MAILCHIMP_ATTRIB_CREATED'=>'The required attributes were created on Mailchimp.',
	'LBL_MAILCHIMP_ATTRIB_OK'=>'All required attributes present on Mailchimp.',
	'LBL_NO_CHANGES_TO_SYNC'=>'No changes since the last synchronization.',
	'LBL_STEP'=>'Step',

	);
	
	
	$jsLanguageStrings = array(
		'JS_LBL_ARE_YOU_SURE_YOU_WANT_TO_ADD_THIS_FILTER' => 'Are you sure that you want to add this list?',
		'JSLBL_ENTER_MC_VALUE'=>'Synchronization with MailChimp is not yet possible. Please provide the Mailchimp API Key by a proper entry at the Settings menu.',
		'JSLBL_GOTO_DETAIL_VIEW'=>'Please go to the Mail Chimp Group Detail view, before starting a synchronization.',
		'LBL_MASS_DELETE_REL_CONFIR'=>'Are you sure that you want to remove these entries? If applicable these records will get removed from the Mailchimp list during the next synchronization.',
		'of' => 'of',
		'to' => 'to',
		'MC_WAIT' => 'Please wait. Depending on your list size the next operation can take up to 15 minutes.',
		'RESPONSE_TIME_OUT'=>'Return could not be read (time out)',
		'LBL_RECORDS_ADDED' => 'The list has been added without creating duplicates.',
		'LBL_ERROR_RECORDS_ADD' => 'The list could not be added.',
	);
	
?>
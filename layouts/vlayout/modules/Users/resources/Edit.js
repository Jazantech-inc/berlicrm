/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Vtiger_Edit_Js("Users_Edit_Js",{},{
	
	duplicateCheckCache : {},
	
	//Hold the conditions for a hour format
	hourFormatConditionMapping : false,
	
	
	registerWidthChangeEvent : function() {
		var widthType = app.cacheGet('widthType', 'narrowWidthType');
		jQuery('#currentWidthType').html(jQuery('li[data-class="'+widthType+'"]').html());
		jQuery('#widthType').on('click', 'li', function(e){
			var value = jQuery(e.currentTarget).data('class');
			app.cacheSet('widthType', value);
			jQuery('#currentWidthType').html(jQuery(e.currentTarget).html());
			window.location.reload();
		});
	},
	
	registerHourFormatChangeEvent : function() {
		
	},
	
	changeStartHourValuesEvent : function(form){
		var thisInstance = this;
		form.on('change','select[name="hour_format"]',function(e){
			var hourFormatVal = jQuery(e.currentTarget).val();
			var startHourElement = jQuery('select[name="start_hour"]',form);
			var conditionSelected = startHourElement.val();
			var list = thisInstance.hourFormatConditionMapping['hour_format'][hourFormatVal]['start_hour'];
			var options = '';
			for(var key in list) {
				//IE Browser consider the prototype properties also, it should consider has own properties only.
				if(list.hasOwnProperty(key)) {
					var conditionValue = list[key];
					options += '<option value="'+key+'"';
					if(key == conditionSelected){
						options += ' selected="selected" ';
					}
					options += '>'+conditionValue+'</option>';
				}
			}
			startHourElement.html(options).trigger("liszt:updated");
		});
		
		
	},
	
	triggerHourFormatChangeEvent : function(form) {
		this.hourFormatConditionMapping = jQuery('input[name="timeFormatOptions"]',form).data('value');
		this.changeStartHourValuesEvent(form);
		jQuery('select[name="hour_format"]',form).trigger('change');
	},
	
	/**
	 * Function to register recordpresave event
	 */
	registerRecordPreSaveEvent : function(form){
		var thisInstance = this;
		form.on(Vtiger_Edit_Js.recordPreSave, function(e, data) {
			var groupingSeperatorValue = jQuery('[name="currency_grouping_separator"]', form).val();
			var decimalSeperatorValue = jQuery('[name="currency_decimal_separator"]', form).val();
			if(groupingSeperatorValue == decimalSeperatorValue){
				Vtiger_Helper_Js.showPnotify(app.vtranslate('JS_DECIMAL_SEPARATOR_AND_GROUPING_SEPARATOR_CANT_BE_SAME'));
				e.preventDefault();
                return;
			}
			var userName = jQuery('input[name="user_name"]').val();
			var newPassword = jQuery('input[name="user_password"]').val();
			var confirmPassword = jQuery('input[name="confirm_password"]').val();
			var record = jQuery('input[name="record"]').val();

			if(record == ''){
				if(newPassword != confirmPassword){
					Vtiger_Helper_Js.showPnotify(app.vtranslate('JS_REENTER_PASSWORDS'));
					e.preventDefault();
                    return;
				}
				if(!(userName in thisInstance.duplicateCheckCache)) {
					thisInstance.checkDuplicateUser(userName).then(
						function(data){
							if(data.result) {
								thisInstance.duplicateCheckCache[userName] = data.result;
								Vtiger_Helper_Js.showPnotify(app.vtranslate('JS_USER_EXISTS'));
							}
						}, 
						function (data, error){
							thisInstance.duplicateCheckCache[userName] = data.result;
                            delayedSubmit=true;
							form.submit();
						}
					);
				} else {
					if(thisInstance.duplicateCheckCache[userName] == true){
						Vtiger_Helper_Js.showPnotify(app.vtranslate('JS_USER_EXISTS'));
					} else {
						delete thisInstance.duplicateCheckCache[userName];
						return true;
					}
				}
				e.preventDefault();
			}
		})
	},
	
	checkDuplicateUser: function(userName){
		var aDeferred = jQuery.Deferred();
		var params = {
				'module': app.getModuleName(),
				'action' : "SaveAjax",
				'mode' : 'userExists',
				'user_name' : userName
			}
			AppConnector.request(params).then(
				function(data) {
					if(data.result){
						aDeferred.resolve(data);
					}else{
						aDeferred.reject(data);
					}
				}
			);
		return aDeferred.promise();
	},
	
	registerEvents : function() {
        this._super();
		var form = this.getForm();
		this.registerWidthChangeEvent();
		this.triggerHourFormatChangeEvent(form);
		this.registerRecordPreSaveEvent(form);
		Users_PreferenceEdit_Js.registerChangeEventForCurrencySeperator();
	}
});

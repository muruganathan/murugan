(function( $ ){
	$.fn.mcContact = function(options){

		// -----------------------------------------------
		// DEFAULTS AND OPTIONS
		// -----------------------------------------------
		var mcForm = this;
		var defaults = {
			mcAjaxSubmitUrl : 'contact.php',
			mcSideBarBtn : true,
			mcCharacterCount : true,
			mcBubbleResponse : true,
			mcTooltip : true,
			mcScrollToError : true,
			mcModalFadeIn : false,
			mcModalFadeInBtn : false,
			mcModalSlideIn : false,
			mcModalSlideInBtn : false,
			mcModalSlideDown : false,
			mcModalSlideDownBtn : false,
			mcModalTimed : false,
			mcModalTimedTime : 0,
			mcSuccessRedirect : false,
			mcSuccessRedirectTimeout : 0,
			mcSuccessRedirectUrl : '',
		};
		var settings = $.extend({}, defaults, options);

		// -----------------------------------------------
		// GET CURRENT MODAL WRAPPER NAME
		// -----------------------------------------------
		var mcWrapElement = 'html,body';
		if(settings.mcModalTimed){
			mcWrapElement = '';
		}

		// -----------------------------------------------
		// GET CURRENT AJAX SUBMIT URL
		// -----------------------------------------------
		var mcSubmitUrl = settings.mcAjaxSubmitUrl;
		if(mcSubmitUrl !== 'contact.php'){
			mcSubmitUrl = settings.mcAjaxSubmitUrl;
		}

		// ***********************************************
		// 1. MODAL WINDOW - FADE IN
		// ***********************************************
		if(settings.mcModalFadeIn){
			var mcContactWrap = mcForm.parent();
			$(mcContactWrap).hide();
			$(mcContactWrap).addClass('mcContactWrapPlus');
			$('body').prepend('<div class="mcModalWrap1">');
			$(mcContactWrap).prepend('<a class="mcCloseModalBtn1" href="#" title="close"></a>');
			var mcModalWrap = $('.mcModalWrap1');
			var mcCloseBtn = $('.mcCloseModalBtn1');
			if(settings.mcModalFadeInBtn === false){
				$('body').prepend('<a class="mcModalBtn1" href="#" title="contact us">c o n t a c t</a>');
				var mcModalBtn1 = $('.mcModalBtn1');
				$(mcModalBtn1).show();
				$(mcModalBtn1).click(function(e){
					e.preventDefault();
					$(mcModalWrap).fadeIn('slow');
					$(mcContactWrap).fadeIn('slow');
					if(settings.mcSideBarBtn){mcSideBarBtn();}
					$(mcWrapElement).stop().animate({scrollTop: mcForm.offset().top -60},'slow');
				});
				$(mcCloseBtn).click(function(e){
					e.preventDefault();
					$(mcModalWrap).fadeOut();
					$(mcContactWrap).fadeOut();
					mcResetForm();
					$(mcModalBtn1).fadeOut('slow').fadeIn('slow');
				});
			}else{
				var mcCustBtn = settings.mcModalFadeInBtn;
				$(mcCustBtn).click(function(e){
					e.preventDefault();
					$(mcModalWrap).fadeIn('slow');
					$(mcContactWrap).fadeIn('slow');
					$(mcWrapElement).stop().animate({scrollTop: mcForm.offset().top -60},'slow');
					if(settings.mcSideBarBtn){mcSideBarBtn();}
				});
				$(mcCloseBtn).click(function(e){
					e.preventDefault();
					$(mcModalWrap).fadeOut();
					$(mcContactWrap).fadeOut();
					mcResetForm();
					$(mcCustBtn).fadeOut('slow').fadeIn('slow');
				});
			}
			mcModalWrap.click(function(){
				$(this).fadeOut('slow');
				$(mcContactWrap).fadeOut('slow');
				mcResetForm();
				$(mcModalBtn1).fadeOut('slow').fadeIn('slow');
			});
		}

		// ***********************************************
		// 2. MODAL WINDOW - TIMED FADE IN
		// ***********************************************
		if(settings.mcModalTimed){
			var mcContactWrap = mcForm.parent();
			$(mcContactWrap).wrap('<div class="mcModalWrap1">');
			$(mcContactWrap).prepend('<a class="mcCloseModalBtn1" href="#" title="close"></a>');
			var mcModalWrap = $('.mcModalWrap1');
			if(settings.mcModalTimedTime > 0){
				setTimeout(function(){
					$(mcModalWrap).fadeIn('slow');
					if(settings.mcSideBarBtn){mcSideBarBtn();}
				}, settings.mcModalTimedTime);
			}
			var mcCloseBtn = $('.mcCloseModalBtn1');
			$(mcCloseBtn).click(function(e){
				e.preventDefault();
				$(mcModalWrap).fadeOut();
				mcResetForm();
			});
		}

		// ***********************************************
		// 3. MODAL WINDOW - SLIDE IN
		// ***********************************************
		if(settings.mcModalSlideIn){
			var mcContactWrap = mcForm.parent();
			$(mcContactWrap).wrap('<div class="mcModalWrap2">');
			$(mcContactWrap).hide();
			$(mcContactWrap).prepend('<a class="mcCloseModalBtn1" href="#" title="close"></a>');
			var mcModalWrap = $('.mcModalWrap2');
			var mcCloseBtn = $('.mcCloseModalBtn1');
			if(settings.mcModalSlideInBtn === false){
				$('body').prepend('<a class="mcModalBtn1" href="#" title="contact us">c o n t a c t</a>');
				var mcModalBtn1 = $('.mcModalBtn1');
				$(mcModalBtn1).show();
				$(mcModalBtn1).click(function(e){
					e.preventDefault();
					$(mcContactWrap).show();
					$(mcModalWrap).animate({'marginLeft':'375px'},300);
					$(mcWrapElement).stop().animate({scrollTop: mcForm.offset().top -60},'slow');
					if(settings.mcSideBarBtn){mcSideBarBtn();}
				});
				$(mcCloseBtn).click(function(e){
					e.preventDefault();
					$(mcModalWrap).animate({'marginLeft':'0px'},300, function(){
						$(mcContactWrap).hide();
					});
					mcResetForm();
					$(mcModalBtn1).fadeOut('slow').fadeIn('slow');
				});
			}else{
				var mcCustBtn = settings.mcModalSlideInBtn;
				$(mcCustBtn).click(function(e){
					e.preventDefault();
					$(mcContactWrap).show();
					$(mcModalWrap).animate({'marginLeft':'375px'},300);
					$(mcWrapElement).stop().animate({scrollTop: mcForm.offset().top -60},'slow');
					if(settings.mcSideBarBtn){mcSideBarBtn();}
				});
				$(mcCloseBtn).click(function(e){
					e.preventDefault();
					$(mcModalWrap).animate({'marginLeft':'0px'},300, function(){
						$(mcContactWrap).hide();
					});
					mcResetForm();
					$(mcCustBtn).fadeOut('slow').fadeIn('slow');
				});
			}
		}

		// ***********************************************
		// 4. MODAL WINDOW - SLIDE DOWN
		// ***********************************************
		if(settings.mcModalSlideDown){
			var mcContactWrap = mcForm.parent();
			$(mcContactWrap).wrap('<div class="mcModalWrap3">');
			$(mcContactWrap).append('<a class="mcCloseModalBtn2" href="#" title="close"></a>');
			var mcModalWrap = $('.mcModalWrap3');
			var mcModalWrapHeight = mcModalWrap.outerHeight();
			var mcCloseBtn = $('.mcCloseModalBtn2');
			if(settings.mcModalSlideDownBtn === false){
				$('body').prepend('<a class="mcModalBtn3" href="#" title="contact us">c o n t a c t</a>');
				var mcModalBtn3 = $('.mcModalBtn3');
				$(mcModalBtn3).show();
				$(mcModalWrap).css('margin-top', - mcModalWrapHeight + -30 + 'px');
				$(mcModalBtn3).click(function(e){
					e.preventDefault();
					$(mcModalWrap).animate({'marginTop':-25},300);
					$(mcWrapElement).stop().animate({scrollTop: mcForm.offset().top -60},'slow');
					if(settings.mcSideBarBtn){mcSideBarBtn();}
				});
				$(mcCloseBtn).click(function(e){
					e.preventDefault();
					$(mcModalWrap).animate({'marginTop':- mcModalWrapHeight + -30 + 'px'},300);
					mcResetForm();
					$(mcModalBtn3).fadeOut('slow').fadeIn('slow');
				});
			}else{
				var mcCustBtn = settings.mcModalSlideDownBtn;
				mcModalWrap.css('margin-top', - mcModalWrapHeight + -30 + 'px');
				$(mcCustBtn).click(function(e){
					e.preventDefault();
					$(mcModalWrap).animate({'marginTop':-25},300);
					$(mcWrapElement).stop().animate({scrollTop: mcForm.offset().top -60},'slow');
					if(settings.mcSideBarBtn){mcSideBarBtn();}
				});
				$(mcCloseBtn).click(function(e){
					e.preventDefault();
					$(mcModalWrap).animate({'marginTop':- mcModalWrapHeight + -30 + 'px'},300);
					mcResetForm();
					$(mcCustBtn).fadeOut('slow').fadeIn('slow');
				});
			}
		}

		// -----------------------------------------------
		// HIDE SEND COPY CHECKBOX / SHOW GRAPHIC ONE
		// -----------------------------------------------
		$('.mcDivSendCopy', mcForm).show();
		$('.mcLblSendCopy', mcForm).hide();

		// -----------------------------------------------
		// AJAX LOADING IMAGE
		// -----------------------------------------------
		var mcLoading = $('.mcLoading', mcForm);

		// -----------------------------------------------
		// FORM - SEND COPY CHECKBOX CLICK
		// -----------------------------------------------
		$('.mcDivSendCopy', mcForm).click(function(){
			var mcCbxSendCopy = $(this).next().find('.mcCbxSendCopy');
			$(mcCbxSendCopy).attr('checked',!$(mcCbxSendCopy).attr('checked'));
			if($(mcCbxSendCopy).attr('checked')){
				$(this).addClass('mcDivSendCopySelected');
				$(this).text('OK!');
			}else{
				$(this).removeClass('mcDivSendCopySelected');
				$(this).text('Click to receive a copy of this email.');
			}
		});

		// -----------------------------------------------
		// UI DATEPICKER WITH SELECT MENUS
		// -----------------------------------------------
		var mcFindDatepicker = $('.mcDateSelected', mcForm);
		if(mcFindDatepicker.length > 0){
			$(mcFindDatepicker).datepicker({
				beforeShow: mcReadSelected,
				onSelect: mcUpdateSelected,
				minDate: new Date(1900, 1 - 1, 1),
				maxDate: new Date(2050, 12 - 1, 31),
				showOn: 'both',
				buttonImageOnly: true,
				buttonImage: 'themes/default/images/datepicker.png',
				changeMonth: true,
				changeYear: true
			});
		}

		// get selected date from hidden field
		function mcReadSelected() {
			var mcSelectPicker = $(this).parent();
			var mcDateSelected = $(mcSelectPicker).find('.mcDateSelected');
			var mcCalDay = $(mcSelectPicker).find('.mcCalDay');
			var mcCalMonth = $(mcSelectPicker).find('.mcCalMonth');
			var mcCalYear = $(mcSelectPicker).find('.mcCalYear');

			$(mcDateSelected).val($(mcCalMonth).val() + '/' + $(mcCalDay).val() + '/' + $(mcCalYear).val());
			return {};
		}

		// Update select control group to match a date picker selection
		function mcUpdateSelected(date) {
			var mcSelectPicker = $(this).parent();
			var mcCalDay = $(mcSelectPicker).find('.mcCalDay');
			var mcCalMonth = $(mcSelectPicker).find('.mcCalMonth');
			var mcCalYear = $(mcSelectPicker).find('.mcCalYear');

			$(mcCalMonth).val(date.substring(0, 2));
			$(mcCalDay).val(date.substring(3, 5));
			$(mcCalYear).val(date.substring(6, 10));
		}

		// -----------------------------------------------
		// RESET FORM FUNCTION
		// -----------------------------------------------
		function mcResetForm(){
			var mcDivSendCopy = $('.mcDivSendCopy', mcForm);
			$(mcDivSendCopy).removeClass('mcDivSendCopySelected');
			$(mcDivSendCopy).text('Click to receive a copy of this email.');

			var mcCbxSendCopy = mcForm.find('.mcCbxSendCopy');
			$(mcCbxSendCopy).removeAttr('checked');

			var mcSelect1 = mcForm.find('.mcSelect1');
			var mcSelect2 = mcForm.find('.mcSelect2');
			$('option:selected', mcSelect2).remove().appendTo(mcSelect1);

			mcForm.find('.mcCustResponse').remove();
			mcForm.find('.mcError').removeClass('mcError');

			mcResponse('', false);

			mcForm[0].reset();
		}

		// -----------------------------------------------
		// RESET FORM BUTTON CLICK
		// -----------------------------------------------
		var mcResetBtn = $('input[type=reset]', mcForm);
		$(mcResetBtn).click(function(){
			mcResetForm();
			$(mcWrapElement).stop().animate({scrollTop: mcForm.offset().top -60},'slow');
		});

		// -----------------------------------------------
		// RECAPTCHA REFRESH
		// -----------------------------------------------
		function mcReloadRecaptcha(){
			var mcReCaptcha = $('input[id=recaptcha_response_field]', mcForm);
			if(mcReCaptcha.is(':visible')) {
				Recaptcha.reload();
			}
		}

		// -----------------------------------------------
		// SIDEBAR BUTTON
		// -----------------------------------------------
		if(settings.mcSideBarBtn){
			function mcSideBarBtn(){
				var mcContactWrap = mcForm.parent();
				$(mcContactWrap).each(function(){
					var mcFormHeight = $(this).outerHeight();
					var mcSideBtn = $('.mcSideBtn', this);
					var mcSideBtnHeight = mcFormHeight -30 + 'px';
					$(mcSideBtn).css('height', mcSideBtnHeight);
					$(mcSideBtn).fadeIn('slow').fadeOut('slow').fadeIn('slow');
				});
			}
			mcSideBarBtn();
		}

		// -----------------------------------------------
		// RESPONSE MESSAGES
		// -----------------------------------------------
		function mcResponse(mcMsg, mcShowHide){
			var mcResponse = $('.mcResponse', mcForm);
			if(mcShowHide === true){
				$(mcResponse).fadeIn('slow').html('- ' + mcMsg);
			}
			else if(mcShowHide === false){
				$(mcResponse).fadeOut('slow');
			}
		}

		// -----------------------------------------------
		// CHARACTER COUNT
		// -----------------------------------------------
		if(settings.mcCharacterCount){
			$('.mcCount', mcForm).each(function(){
				var mcMaxChar = $(this).attr('maxlength');
				var mcCharLabelText = ' characters remaining';
				$(this).before('<label class="mcCharCountLabel">' + mcMaxChar + mcCharLabelText + '</label>');
				var mcCharCountLbl = $(this).parent().find('.mcCharCountLabel');
				$(this).bind('keyup', (function() {
					var mcTextLength = $(this).val().length;
					var mcTextRemaining = (mcMaxChar - mcTextLength);

					if(mcTextRemaining < 0) {
						$(mcCharCountLbl).html('0');
						$(this).val($(this).val().slice(0, mcMaxChar));
					}
					else {
						$(mcCharCountLbl).html('<strong>' + mcTextRemaining + '</strong>' + mcCharLabelText);
					}
				}));
			});
		}

		// -----------------------------------------------
		// MULTI SELECT TRANSFER LIST
		// -----------------------------------------------
		$('.mcTransferGroup').each(function() {
			var mcAdd = $(this).find('.mcAdd');
			var mcRemove = $(this).find('.mcRemove');
			var mcSelect1 = $(this).find('.mcSelect1');
			var mcSelect2 = $(this).find('.mcSelect2');

			$(mcAdd).click(function() {
				return !$('option:selected', mcSelect1).remove().appendTo(mcSelect2);
			});
			$(mcRemove).click(function() {
				return !$('option:selected', mcSelect2).remove().appendTo(mcSelect1);
			});
		});

		// -----------------------------------------------
		// TOOLTIP MOUSE HOVER
		// -----------------------------------------------
		if(settings.mcTooltip){
			mcForm.append('<div class="mcTooltip"></div>');
			$('a, input, textarea, select, p, label', mcForm).mousemove(function(e) {
				var mcHoverText = $(this).attr('data-tooltip');
				var mcTooltip = $('.mcTooltip');
				if(mcHoverText){
					mcTooltip.html(mcHoverText).stop(true, true).fadeIn(100).css('left', e.clientX + 15).css('top', e.clientY + 15);
				}
			}).mouseout(function() {
				var mcTooltip = $('.mcTooltip');
				mcTooltip.fadeOut(100);
			});
		}

		// -----------------------------------------------
		// HIDE RESPONSE MESSAGES ON CLICK AND HOVER
		// -----------------------------------------------
		$('.mcResponse').click(function(){
			mcResponse('', false);
		});

		$('.mcCustResponse').live("hover", function(){
			$(this).animate({marginLeft: '-=200', opacity: '0'}, 500);
		});

		// -----------------------------------------------
		// CHECK FOR FILE INPUT / UPLOAD
		// -----------------------------------------------
		function mcFindFileInput(){
			var mcFileInput = mcForm.find('input:file');
			if(mcFileInput.length > 0){
				return true;
			}else{
				return false;
			}
		}

		// -----------------------------------------------
		// IE PLACEHOLDER FIX
		// -----------------------------------------------
		$.support.placeholder = (function(){
			var i = document.createElement('input');
			return 'placeholder' in i;
		})();

		if (!$.support.placeholder) {

			$('[placeholder]', mcForm).focus(function() {
				if ($(this).val() === $(this).attr('placeholder')) {
					$(this).val('');
				}
			}).blur(function() {
				if ($(this).val().length == 0 || $(this).val() === $(this).attr('placeholder')) {
					$(this).val($(this).attr('placeholder'));
				}
			}).blur();

			mcForm.submit(function(e) {
				//e.preventDefault();
				$(this).find('[placeholder]').each(function() {
					if ($(this).val() === $(this).attr('placeholder')) {
						$(this).val('');
					}
				});
			});
		}

		// -----------------------------------------------
		// REDIRECT ON SUCCESS
		// -----------------------------------------------
		function mcSuccessRedirect() {
			if (settings.mcSuccessRedirect) {
				setTimeout(function() {
					window.location = settings.mcSuccessRedirectUrl;
				}, settings.mcSuccessRedirectTimeout);
			}
		}

		// -----------------------------------------------
		// FORM VALIDATION
		// -----------------------------------------------
		function mcValidate() {
			// remove custom errors if visible
			$('.mcCustResponse', mcForm).remove();

			// -----------------------------------------------
			// CHECK - EMPTY REQUIRED FILED + MIN LENGTH
			// -----------------------------------------------
			mcForm.find('.mcRequired').each(function() {
				var mcEmptyCheck = $.trim($(this).val());
				var mcMinLength = $(this).attr('minlength');
				if(mcEmptyCheck.length == 0) {
					mcResponse('Please fill in the required field!', true);
					if(settings.mcBubbleResponse){
						$(this).parent().prepend('<span class="mcCustResponse">Please fill in the required field!</span>');
					}
					$(this).addClass('mcError');
				}
				else {
					$(this).removeClass('mcError');
				}

				// check min length
				if(mcEmptyCheck.length != 0 && mcEmptyCheck.length < mcMinLength) {
					mcResponse('- Min. ' + mcMinLength + ' chars. are required!', true);
					if(settings.mcBubbleResponse){
						$(this).parent().prepend('<span class="mcCustResponse">Min. ' + mcMinLength + ' chars. are required!</span>');
					}
					$(this).addClass('mcError');
				}
			});

			// -----------------------------------------------
			// CHECK - VALID EMAIL FORMAT
			// -----------------------------------------------
			mcForm.find('.mcEmail').each(function() {
				var mcEmailCheck = $(this).val();
				var mcEmailRegex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

				if(!mcEmailCheck.match(mcEmailRegex)) {
					mcResponse('Incorrect Email format!', true);
					if(settings.mcBubbleResponse){
						$(this).parent().prepend('<span class="mcCustResponse">Incorrect Email format!</span>');
					}
					$(this).addClass('mcError');
				}
			});

			// -----------------------------------------------
			// CHECK - NUMBERS ONLY
			// -----------------------------------------------
			mcForm.find('.mcNumbers').each(function() {
				var mcNumCheck = $(this).val();
				var mcNumRegex = /^-?\d+$/;

				if(mcNumCheck.length != 0 && !mcNumCheck.match(mcNumRegex)) {
					mcResponse('Incorrect format! Numbers only!', true);
					if(settings.mcBubbleResponse){
						$(this).parent().prepend('<span class="mcCustResponse">Incorrect format! Numbers only!</span>');
					}
					$(this).addClass('mcError');
				}
			});

			// -----------------------------------------------
			// CHECK U.S. PHONE NUMBER
			// -----------------------------------------------
			mcForm.find('.mcPhoneUS').each(function() {
				var mcPhoneUSCheck = $(this).val();
				var mcPhoneUSRegex = /^(1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/;

				if(mcPhoneUSCheck.length != 0 && !mcPhoneUSCheck.match(mcPhoneUSRegex)) {
					mcResponse('Incorrect format! U.S. phone number format 555-555-1212 only!', true);
					if(settings.mcBubbleResponse){
						$(this).parent().prepend('<span class="mcCustResponse">Incorrect format! U.S. phone number format 555-555-1212 only!</span>');
					}
					$(this).addClass('mcError');
				}
			});

			// -----------------------------------------------
			// CHECK - ALPHA AND/OR NUMERIC ONLY - NO SPACES
			// -----------------------------------------------
			mcForm.find('.mcAlphaNum').each(function() {
				var mcAlphaNumCheck = $(this).val();
				var mcAlphaNumRegex = /^[a-z0-9]+$/i;

				if(mcAlphaNumCheck.length != 0 && !mcAlphaNumCheck.match(mcAlphaNumRegex)) {
					mcResponse('Incorrect format! Alphanumeric characters only. No spaces.', true);
					if(settings.mcBubbleResponse){
						$(this).parent().prepend('<span class="mcCustResponse">Incorrect format! Alphanumeric characters only. No spaces.</span>');
					}
					$(this).addClass('mcError');
				}
			});

			// -----------------------------------------------
			// CHECK - ALPHANUMERIC PLUS
			// -----------------------------------------------
			mcForm.find('.mcAlphaNumPlus').each(function() {
				var mcAlphaNumPlusCheck = $(this).val();
				var mcAlphaNumPlusRegex = /^[a-z0-9_.,\-\ ]+$/i;

				if(mcAlphaNumPlusCheck.length != 0 && !mcAlphaNumPlusCheck.match(mcAlphaNumPlusRegex)) {
					mcResponse('Incorrect format! Letters, numbers, spaces, underscores, comas, dashes and dots only.', true);
					if(settings.mcBubbleResponse){
						$(this).parent().prepend('<span class="mcCustResponse">Incorrect format! Letters, numbers, spaces, underscores, comas, dashes and dots only.</span>');
					}
					$(this).addClass('mcError');
				}
			});

			// -----------------------------------------------
			// CHECK - ALPHABETIC CHARS ONLY
			// -----------------------------------------------
			mcForm.find('.mcAlpha').each(function() {
				var mcAlphaCheck = $(this).val();
				var mcAlphaRegex = /^[a-z]+$/i;

				if(mcAlphaCheck.length != 0 && !mcAlphaCheck.match(mcAlphaRegex)) {
					mcResponse('Incorrect format! Alphabetic characters only. No spaces.', true);
					if(settings.mcBubbleResponse){
						$(this).parent().prepend('<span class="mcCustResponse">Incorrect format! Alphabetic characters only. No spaces.</span>');
					}
					$(this).addClass('mcError');
				}
			});

			// -----------------------------------------------
			// CHECK - U.S. ZIP CODE
			// -----------------------------------------------
			mcForm.find('.mcZipUS').each(function() {
				var mcZipUSCheck = $(this).val();
				var mcZipUSRegex = /^\d{5}(-\d{4})?$/;

				if(mcZipUSCheck.length != 0 && !mcZipUSCheck.match(mcZipUSRegex)) {
					mcResponse('Incorrect format! Zip Code must be in the format xxxxx or xxxxx-xxxx!', true);
					if(settings.mcBubbleResponse){
						$(this).parent().prepend('<span class="mcCustResponse">Incorrect format! Zip Code must be in the format xxxxx or xxxxx-xxxx!</span>');
					}
					$(this).addClass('mcError');
				}
			});

			// -----------------------------------------------
			// CHECK - SSN - U.S. SOCIAL SECURITY NUMBER
			// -----------------------------------------------
			mcForm.find('.mcSSN').each(function() {
				var mcSSNCheck = $(this).val();
				var mcSSNRegex = /^(?!000)(?!666)(?!9)\d{3}[- ]?(?!00)\d{2}[- ]?(?!0000)\d{4}$/;

				if(mcSSNCheck.length != 0 && !mcSSNCheck.match(mcSSNRegex)) {
					mcResponse('SSN field must be valid and in the format xxx-xx-xxxx!', true);
					if(settings.mcBubbleResponse){
						$(this).parent().prepend('<span class="mcCustResponse">SSN field must be valid and in the format xxx-xx-xxxx!</span>');
					}
					$(this).addClass('mcError');
				}
			});

			// -----------------------------------------------
			// CHECK - VALID WEB ADDRESS - URL
			// -----------------------------------------------
			mcForm.find('.mcWebsite').each(function() {
				var mcUrlCheck = $(this).val();
				var mcUrlRegex = /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/;

				if(!mcUrlCheck.match(mcUrlRegex)) {
					mcResponse('Incorrect Website Address format!', true);
					if(settings.mcBubbleResponse){
						$(this).parent().prepend('<span class="mcCustResponse">Incorrect Website Address format!</span>');
					}
					$(this).addClass('mcError');
				}
				else {
					$(this).removeClass('mcError');
				}
			});

			// -----------------------------------------------
			// CHECK - MATCH TWO FIELDS
			// -----------------------------------------------
			mcForm.find('.mcVerifyGroup').each(function() {
				var mcVerifyCheck_0 = $(this).find('.mcVerify_0');
				var mcVerifyCheck_1 = $(this).find('.mcVerify_1');

				if(mcVerifyCheck_1.val() != mcVerifyCheck_0.val()) {
					mcResponse('Items do not match!', true);
					if(settings.mcBubbleResponse){
						$(this).prepend('<span class="mcCustResponse">Items do not match!</span>');
					}
					$(mcVerifyCheck_1).addClass('mcError');
				}
				else {
					$(mcVerifyCheck_1).removeClass('mcError');
				}
			});

			// -----------------------------------------------
			// CHECK - SINGLE SELECT SELECTION
			// -----------------------------------------------
			mcForm.find('.mcMenu').each(function() {
				var mcMenuCheck = $(this).val();
				if(mcMenuCheck == null || mcMenuCheck == 0) {
					mcResponse('Please make a Selection!', true);
					if(settings.mcBubbleResponse){
						$(this).parents(':eq(1)').prepend('<span class="mcCustResponse">Please make a Selection!</span>');
					}
					$(this).addClass('mcError');
				}
				else if(mcMenuCheck != null) {
					$(this).removeClass('mcError');
				}
			});

			// -----------------------------------------------
			// CHECK - MULTI SELECT SELECTION
			// -----------------------------------------------
			mcForm.find('.mcList').each(function() {
				var mcSelectMin = $(this).attr('mcminselect');
				var mcSelectCheck = $('option:selected', this).length;
				if(mcSelectCheck < mcSelectMin) {
					mcResponse('Please select at least ' + mcSelectMin + '!', true);
					if(settings.mcBubbleResponse){
						$(this).parents(':eq(1)').prepend('<span class="mcCustResponse">Please select at least ' + mcSelectMin + ' entries!</span>');
					}
					$(this).addClass('mcError');
				}
				else if(mcSelectCheck != null) {
					$(this).removeClass('mcError');
				}
			});

			// -----------------------------------------------
			// CHECK - MULTI SELECT TRANSFER LIST
			// -----------------------------------------------
			mcForm.find('.mcListTransfer').each(function() {
				var mcSelectTMin = $(this).attr('mcminselect');
				var mcSelectTCheck = $('option', this).length;
				if(mcSelectTCheck < mcSelectTMin) {
					mcResponse('Please select at least ' + mcSelectTMin + '!', true);
					if(settings.mcBubbleResponse){
						$(this).parent().prepend('<span class="mcCustResponse">Please select at least ' + mcSelectTMin + ' entries!</span>');
					}
					$(this).addClass('mcError');
				}
				else if(mcSelectTCheck != null) {
					$(this).removeClass('mcError');
				}
			});

			// -----------------------------------------------
			// CHECK SINGLE CHECKBOX
			// -----------------------------------------------
			mcForm.find('.mcCbxSingle').each(function() {
				var mcCbxCheck = $(this);
				if(!mcCbxCheck.is(':checked')) {
					mcResponse('Please check the checkbox!', true);
					if(settings.mcBubbleResponse){
						$(this).parents(':eq(1)').prepend('<span class="mcCustResponse">Please check the checkbox!</span>');
					}
					$(this).parents(':eq(1)').addClass('mcError');
				}
				else{
					$(this).parents(':eq(1)').removeClass('mcError');
				}
			});

			// -----------------------------------------------
			// CHECK CHECKBOX GROUP
			// -----------------------------------------------
			mcForm.find('.mcCbxGroup').each(function() {
				var mcCbxMin = $(this).attr('mcminselect');
				if($(this).find('input[type=checkbox]:checked').length < mcCbxMin) {
					mcResponse('Please check at least ' + mcCbxMin + '!', true);
					if(settings.mcBubbleResponse){
						$(this).prepend('<span class="mcCustResponse">Please check at least ' + mcCbxMin + ' checkbox!</span>');
					}
					$(this).addClass('mcError');
				}
				else{
					$(this).removeClass('mcError');
				}
			});

			// -----------------------------------------------
			// CHECK RADIO GROUP
			// -----------------------------------------------
			mcForm.find('.mcRadGroup').each(function() {
				if($(this).find('input[type=radio]:checked').length == 0) {
					mcResponse('Please select a radio button!', true);
					if(settings.mcBubbleResponse){
						$(this).prepend('<span class="mcCustResponse">Please select an option!</span>');
					}
					$(this).addClass('mcError');
				}
				else{
					$(this).removeClass('mcError');
				}
			});

			// -----------------------------------------------
			// CHECK DATEPICKER
			// -----------------------------------------------
			mcForm.find('.mcDateGroup').each(function() {
				var mcCalMonth = $(this).find('.mcCalMonth');
				var mcCalDay = $(this).find('.mcCalDay');
				var mcCalYear = $(this).find('.mcCalYear');
				if(mcCalMonth.val() == null || mcCalMonth.val() == 0) {
					mcResponse('Please select a month!', true);
					if(settings.mcBubbleResponse){
						$(this).prepend('<span class="mcCustResponse">Please select a month!</span>');
					}
					$(mcCalMonth).addClass('mcError');
				}
				else if(mcCalMonth.val() != null) {
					$(mcCalMonth).removeClass('mcError');
				}
				if(mcCalDay.val() == null || mcCalDay.val() == 0) {
					mcResponse('Please select a day!', true);
					if(settings.mcBubbleResponse){
						$(this).prepend('<span class="mcCustResponse">Please select a day!</span>');
					}
					$(mcCalDay).addClass('mcError');
				}
				else if(mcCalDay.val() != null) {
					$(mcCalDay).removeClass('mcError');
				}
				if(mcCalYear.val() == null || mcCalYear.val() == 0) {
					mcResponse('Please select a year!', true);
					if(settings.mcBubbleResponse){
						$(this).prepend('<span class="mcCustResponse">Please select a year!</span>');
					}
					$(mcCalYear).addClass('mcError');
				}
				else if(mcCalYear.val() != null) {
					$(mcCalYear).removeClass('mcError');
				}
			});

			// -----------------------------------------------
			// CHECK FILE UPLOAD - SINGLE
			// -----------------------------------------------
			mcForm.find('.mcFileUpSingle').each(function() {
				var mcFileType = $(this).attr('data-mcfiletype');
				var mcFileTypeRegex = "/^(" + mcFileType + ")$/";
				var mcFileUpSingle = $(this).find('input[type=file]');
				if(mcFileUpSingle.val().length == 0) {
					//alert('Please select a file to upload!');
					mcResponse('Please select a file to upload!', true);
					if(settings.mcBubbleResponse === true){
						$(this).prepend('<span class="mcCustResponse">Please select a file to upload!</span>');
					}
					$(this).addClass('mcError');
				}
				else{
					$(this).removeClass('mcError');
					mcFileUpSingle.removeClass('mcError');

					var mcGetExtension = mcFileUpSingle.val().substr( (mcFileUpSingle.val().lastIndexOf('.') +1) );
					if (! (mcGetExtension && mcFileTypeRegex.match(mcGetExtension))){
						//alert('Incorrect file type!');
						if(settings.mcBubbleResponse === true){
							$(this).prepend('<span class="mcCustResponse">Incorrect file type! Use only the following: ' + mcFileType + '</span>');
						}
						$(this).addClass('mcError');
						mcFileUpSingle.addClass('mcError');
					}
				}
			});

			// -----------------------------------------------
			// CHECK RECAPTCHA
			// -----------------------------------------------
			mcForm.find('#recaptcha_area').each(function() {
				var mcRecaptchaDiv = $(this);
				var mcReCaptcha = $(this).find('input[id=recaptcha_response_field]');
				var mcReCaptchaVal = mcReCaptcha.val();
				if(mcReCaptcha.is(':visible')) {
					if($.trim(mcReCaptchaVal).length == 0){
						mcResponse('Please enter the captcha!', true);
						if(settings.mcBubbleResponse){
							$(mcRecaptchaDiv).prepend('<span class="mcCustResponse">Please enter the captcha!</span>');
						}
						$(mcRecaptchaDiv).addClass('mcError');
					} else {
						$(mcRecaptchaDiv).removeClass('mcError');
					}
				}
			});

			// -----------------------------------------------
			// IF ERROR(S) FOUND
			// -----------------------------------------------
			var $errors = $('.mcError', mcForm);
			if($errors.length > 0){
				if(settings.mcScrollToError){
					$(mcWrapElement).stop().delay(500).animate({ scrollTop: ($errors.filter(":first").offset().top -30) },'slow');
				}
				return false;
			}
			else{
				mcResponse('', false);
				return true;
			}
		}

		// -----------------------------------------------
		// FORM SUBMIT
		// -----------------------------------------------
		mcForm.submit(function(e){

			// 1. if NO file input is present
			if(mcFindFileInput() === false){
				if(mcValidate() === true){
					var mcFormData = $(this).serialize();
					var mcAjaxParam = true;
					var mcSubmitIdParam = $('input[type=submit]', mcForm).attr('id');
					mcFormData += '&mcAjax=' + encodeURIComponent(mcAjaxParam);
					mcFormData += '&' + mcSubmitIdParam + '=' + encodeURIComponent(mcAjaxParam);
					mcAjaxSubmit(mcFormData);
					$(mcLoading).show();
				}
			}

			// 2. if file input IS present
			if(mcFindFileInput() === true){
				if(mcValidate() === true){
					$(mcLoading).show();
					mcIframeSubmit();
					return true;
				}
			}

			// do not submit
			e.preventDefault();
			return false;
		});

		// -----------------------------------------------
		// AJAX SUBMIT FUNCTION
		// -----------------------------------------------
		function mcAjaxSubmit(mcFormData){
			$.ajax({
				type: 'POST',
				url: mcSubmitUrl,
				data: mcFormData,
				dataType: 'json',
				cache: false,
				timeout: 20000,
				success: function(data) {
					$.each(data, function(key, value){
						if(value.error === true){

							// hide loading image
							$(mcLoading).hide();

							// display error message
							mcResponse(value.msg, true);

							$(mcWrapElement).stop().animate({scrollTop: mcForm.offset().top -60},'slow');

							// generate new captcha image
							mcReloadRecaptcha();
						}
						else if(value.error === false){

							// reset form
							mcResetForm();

							// hide loading image
							$(mcLoading).hide();

							// display success message
							mcResponse(value.msg, true);

							$(mcWrapElement).stop().animate({scrollTop: mcForm.offset().top -60},'slow');

							// generate new captcha image
							mcReloadRecaptcha();

							// redirect on success?
							mcSuccessRedirect();
						}
					});
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					// display error message
					mcResponse('Oops! Parsing error. Failed to process the form...', true);

					// hide loading image
					$(mcLoading).hide();

					$(mcWrapElement).stop().animate({scrollTop: mcForm.offset().top -60},'slow');
				},
				complete: function(XMLHttpRequest, status) {
					$(mcLoading).hide();
				}
			});
		}

		// -----------------------------------------------
		// IFRAME SUBMIT FUNCTION
		// -----------------------------------------------
		function mcIframeSubmit(){
			// remove iframe if exists
			$('#mcHiddenIframe').remove();

			// change target attribute on form
			mcForm.attr('target', 'mcHiddenIframe');

			// create and add iframe to page
			$('<iframe />', {
				name: 'mcHiddenIframe',
				id: 'mcHiddenIframe',
				style: 'display:none'
			}).appendTo('body');

			// on response from php file
			$('#mcHiddenIframe').load(function(){
				var mcIframeResponse = $(this).contents().find('.mc1').html();
				var mcIframeError = $(this).contents().find('.mc2').html();

				// reset form
				mcResetForm();

				// hide loading image
				$(mcLoading).hide();

				// scroll to top
				$(mcWrapElement).stop().animate({scrollTop: mcForm.offset().top -60},'slow');

				// display response message
				if (mcIframeError == true) {
					mcResponse(mcIframeResponse, true);
				} else {
					mcResponse(mcIframeResponse, true);

					// redirect on success?
					mcSuccessRedirect();
				}

				// stop iframe load
				$(this).unbind('load');

				// remove form target attribute
				mcForm.removeAttr('target');

				// refresh captcha image
				mcReloadRecaptcha();
			});
		}

		// -----------------------------------------------
		// FORM SIDE BUTTON CLICK
		// -----------------------------------------------
		$('.mcSideBtn', mcForm).click(function(e){
			e.preventDefault();

			// pass it to submit function
			mcForm.submit();
		});
	};
})( jQuery );
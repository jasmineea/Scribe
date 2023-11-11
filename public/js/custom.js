$(document).ready(function(){

	function setCookie(cname,cvalue,exdays) {
		const d = new Date();
		d.setTime(d.getTime() + (exdays*24*60*60*1000));
		let expires = "expires=" + d.toUTCString();
		document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
		}

		function getCookie(cname) {
		let name = cname + "=";
		let decodedCookie = decodeURIComponent(document.cookie);
		let ca = decodedCookie.split(';');
		for(let i = 0; i < ca.length; i++) {
		  let c = ca[i];
		  while (c.charAt(0) == ' ') {
		  c = c.substring(1);
		  }
		  if (c.indexOf(name) == 0) {
		  return c.substring(name.length, c.length);
		  }
		}
		return "";
		}
		function delete_cookie(name) {
			document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
		}

		function checkCookie(element) {
		  let tour_tooltip = getCookie(element);
		  if (typeof $(element).data('value') !== "undefined" && tour_tooltip=='') {
			console.log('ddd');
			createPopup(element,$(element).data('pos'),$(element).data('title'),$(element).data('value'),$(element).data('video_link'))
			setCookie(element,1, 30);
		  }
		}
		function createPopup(element,pos,title,text,video_link){
			const tour = new Shepherd.Tour({
				defaultStepOptions: {
				  cancelIcon: {
					enabled: true
				  },
				  classes: 'class-1 class-2',
				  scrollTo: { behavior: 'smooth', block:'center' }
				}
			  });

			  tour.addStep({
				title: title,
				text: text,
				attachTo: {
				  element: element,
				  on: pos
				},
				buttons: [
				  {
					action() {
					  return this.complete();
					},
					classes: 'shepherd-button-secondary',
					text: 'Close'
				  },
				  {
					action() {
					$(".show_video").trigger('click');
					  return this.complete();
					},
					text: 'Watch Video'
				  }
				],
				id: 'creating'
			  });

			  tour.start();
		}
		//=================setp 1 =================================
			checkCookie("#step_1_tooltip");
			checkCookie("#step_2_tooltip");
			checkCookie("#step_3_tooltip");
			checkCookie("#step_4_tooltip");
			checkCookie("#step_5_tooltip");
			checkCookie("#step_6_tooltip");
			$(".step-info").click(function(){
				var element=$(this).data('element');
				delete_cookie("#"+element);
				checkCookie("#"+element);
			})
		//=================setp 1 end =================================

			// var count = 1;
			// $('.prev_message').prop('disabled', true);
			// $('.next_message').prop('disabled', true);

			$('.add_row').on('click',function(){
				addNewMessageBox();
			});

			$(".how_much_message").bind('keyup mouseup', function () {
				var current_value = $(this).val();
				var single_row2_count =$(".custom_box").length;
				console.log(current_value);
				console.log(single_row2_count);
				if(current_value>=single_row2_count){
					var diff=current_value-single_row2_count;
					while(diff){
						addNewMessageBox();
						diff--;
					}
				}else{
					var diff=single_row2_count-current_value;;
					while(diff){
						$('.main').find('.custom_box:last').remove();
						diff--;
					}
				}
			});

			function addNewMessageBox(){
				var count = $(".custom_box").length;
				if(count > 5){
					alert('you can add max 5 messages');
					$.notify("you can add max 5 messages");
					return false;
				}
				count++;
				if(count > 0){

					$('.prev_message').prop('disabled', false);
					$('.next_message').prop('disabled', false);
				}




				$('.main').append(`<div class="single_row2 max-width-650 custom_box" id="single_row2_`+count+`"  data-count="`+count+`"><h4><b>Custom Message `+count+`</b><div style="float: right;width: 31%;">#tag <input style="width: 66%;text-align: center;padding: 0px;border-radius: 5px;border: 1px solid #ced4da;height: 25px;font-size: 15px;font-weight: 400;" name="tag" value="Custom Message `+count+`" disabled><i class="fa fa-pencil-alt edit_tag" aria-hidden="true" style="margin-left: 3px; border: 1px solid #ced4da; border-radius: 5px; padding: 2px; font-size: 17px;"></i></div></h4><div class="mb-2"><textarea name="hwl_custom_msg[]" style="min-height:300px" class="hwl_custom_msg custm-edtr" placeholder="Type your Note here."></textarea><h6 class="wrd-cuntng">150 words Remaining</h6><p class="template_words"></p><div class="group-btn"><input type="button" name="fname_btn[]" data-toggle="tooltip" data-placement="bottom" title="Recipient's First Name" class="fname_btn group-btn-item" data-placeholder="{FIRST_NAME}" value="First Name"> <input type="button" data-toggle="tooltip" data-placement="bottom" title="Recipient's Last Name" name="lname_btn[]" class="lname_btn group-btn-item" data-placeholder="{LAST_NAME}" value="Last Name"> <input type="button" data-toggle="tooltip" data-placement="bottom" title="Recipient's Company Name" name="cmp_btn[]" class="cmp_btn group-btn-item" data-placeholder="{COMPANY_NAME}" value="Company"> <input type="button" data-toggle="tooltip" data-placement="bottom" title="Recipient's Email Address" name="email_btn[]" class="email_btn group-btn-item" data-placeholder="{EMAIL_ADDRESS}" value="Email Address"> <input type="button" data-toggle="tooltip" data-placement="bottom" title="Recipient's Phone Number" name="phone_btn[]" class="phone_btn group-btn-item" data-placeholder="{PHONE}" value="Phone"></div><div><input type="hidden" name="textmsg[]" value="" class="textmsg"></div></div>`);

				// $('.single_row2:not(:last)').hide();
				// $('.main').find('#single_row2_'+count).show();
				 $('.main').find('.single_row2:last').data('count',count);
				 current = $('.main').find('.single_row2:last').data('count');
				 $('[data-toggle="tooltip"]').tooltip();
			}

			// Next button Event

			var current = $('.main').find('.single_row2:last').data('count');


			$('.next_message').on('click', function() {

				// var current = $('.main').find('.single_row2:last').data('count');

				if(current != null){
					var next = current + 1;
					if($('#single_row2_'+next).length > 0){
						$('#single_row2_'+current).hide();
						current++;
						$('#single_row2_'+current).show();
					}
				}
			});

			// Previous Button Event
			$('.prev_message').on('click', function() {
				// var current = $('.main').find('.single_row2:last').data('count');

				if(current>0){
					$('#single_row2_'+current).hide();
					current--;
					$('#single_row2_'+current).show();
				}
			});


			// Character counting for Message text area
			var default_lines=$("#input_lines").val();
			var default_words=$("#input_words").val();
			var text_max = default_words;
			var set_target = 10;

			$('.wrd-cuntng').html(default_words + ' words remaining');
			jQuery('.wrd-cuntng').attr('count',text_max);

			// jQuery(document).on('keyup','.hwl_custom_msg', function(event) {
			// 	console.log(event.key);
			// 	if(event.key!='Backspace'&&event.key!='Delete'&&event.key!='Enter'){
			// 			var word_count1 = 0;
			// 			jQuery(this).parents(".single_row2").find('.textmsg').val(jQuery(this).val());
			// 			var split = jQuery(this).val().split(' ');
			// 			for (var i = 0; i < split.length; i++) {
			// 				if (split[i] != "") {
			// 					word_count1 += 1;
			// 				}
			// 			}
			// 			var text_remaining = text_max - word_count1;
			// 			if(text_remaining<=0){
			// 				var str=jQuery(this).val();
			// 				jQuery(this).val(str.substring(0, str.lastIndexOf(" ")));
			// 				return false;
			// 			}
			// 			jQuery(this).parents(".single_row2").find('.wrd-cuntng').html(text_remaining + ' words remaining');
			// 			console.log(word_count1+"=="+set_target);
			// 			if(word_count1>=set_target){
			// 				str=jQuery(this).val();
			// 				var lastIndex = jQuery(this).val().lastIndexOf(" ");
			// 				str = jQuery(this).val().substr(0, lastIndex) + '\n' + jQuery(this).val().substr(lastIndex + 1);
			// 				jQuery(this).val(str);
			// 				set_target+=10;
			// 			}else{
			// 				line_no=getLineNumber(this);
			// 				line_no=line_no-1;
			// 				word_c=checkwordsperline(this,line_no);
			// 				if(word_c>11){
			// 					var lastIndex = jQuery(this).val().lastIndexOf(" ");
			// 					str = jQuery(this).val().substr(0, lastIndex) + '\n' + jQuery(this).val().substr(lastIndex + 1);
			// 					jQuery(this).val(str);
			// 					set_target+=10;
			// 				}
			// 			}
			// 	}else{
			// 		var split = jQuery(this).val().split(' ');
			// 		var text_remaining = text_max - split.length;
			// 		jQuery(this).parents(".single_row2").find('.wrd-cuntng').html(text_remaining + ' words remaining');
			// 		//set_target=roundUpToAny(split.length,10);
			// 		set_target=jQuery(this).val().split(/\r\n|\r|\n/).length*10;
			// 	}
			// 	console.log(getLineNumber(this));
			// });
			setTimeout(function(){
				jQuery(document).find('.hwl_custom_msg').trigger('keyup');
			},200);
			jQuery(document).on('keyup','.hwl_custom_msg', function(event) {
				var default_lines=$("#input_lines").val();
				text_max = default_words=$("#input_words").val();
				var total_lines=calulateLines(event);
				var remaining_lines=default_lines-total_lines;
				var word_count1 = 0;
				jQuery(this).parents(".single_row2").find('.textmsg').val(jQuery(this).val());
				var split = jQuery(this).val().split(' ');
				for (var i = 0; i < split.length; i++) {
					if (split[i] != "") {
						word_count1 += 1;
					}
				}
				var text_remaining = text_max - word_count1;
				if(text_remaining<=0){
					var str=jQuery(this).val();
					jQuery(this).val(str.substring(0, str.lastIndexOf(" ")));
					jQuery(this).parents(".single_row2").find('.wrd-cuntng').html(text_remaining + ' words remaining');
					jQuery(this).parents(".single_row2").find('.wrd-cuntng').attr('count',text_remaining);
					return false;
				}
				jQuery(this).parents(".single_row2").find('.wrd-cuntng').html(text_remaining + ' words remaining');
				jQuery(this).parents(".single_row2").find('.wrd-cuntng').attr('count',text_remaining);

				line_no=getLineNumber(this);
				line_no=line_no-1;
				word_c=checkwordsperline(this,line_no);
				if(word_c>10){
					var lastIndex = jQuery(this).val().lastIndexOf(" ");
					str = jQuery(this).val().substr(0, lastIndex) + '\n' + jQuery(this).val().substr(lastIndex + 1);
					//jQuery(this).val(str);
					set_target+=10;
				}
				jQuery('.p_preview').html(jQuery(this).val());
				
			});
			$(".ApplyLineBreaks").click(function(){
				var default_lines=$("#input_lines").val();
				var default_words=$("#input_words").val();
				
				var count=jQuery('.wrd-cuntng').attr('count');
				ApplyLineBreaks('hwl_custom_msg_1');
				console.log(parseInt(count));
				if(parseInt(count)<'0'){
					Alert.error("Message word's count should be less then equal to "+default_words+" words.",'Error',{displayDuration: 5000, pos: 'top'})
					return false;
				}
				console.log($(".textmsg").val());
				if($(".textmsg").val().split("<br />").length>default_lines){
					var lines = $(".textmsg").val().split("<br />").length;
					Alert.error("you have "+lines+" lines in your message. It should be less then equal to "+default_lines+" lines.",'Error',{displayDuration: 5000, pos: 'top'})
					return false;
				}
				
			})
			function calulateLines(){
				var text = $("#hwl_custom_msg_1").val();   
				var lines = text.split(/\r|\r\n|\n/);
				var count = lines.length;
				
				return count;
			}
			
			function ApplyLineBreaks(strTextAreaId) {
				var oTextarea = document.getElementById(strTextAreaId);
				if (oTextarea.wrap) {
					oTextarea.setAttribute("wrap", "off");
				}
				else {
					oTextarea.setAttribute("wrap", "off");
					var newArea = oTextarea.cloneNode(true);
					newArea.value = oTextarea.value;
					oTextarea.parentNode.replaceChild(newArea, oTextarea);
					oTextarea = newArea;
				}
			
				var strRawValue = oTextarea.value;
				oTextarea.value = "";
				var nEmptyWidth = oTextarea.scrollWidth;
				var nLastWrappingIndex = -1;
			
				function testBreak(strTest) {
					oTextarea.value = strTest;
					return oTextarea.scrollWidth > nEmptyWidth;
				}
				function findNextBreakLength(strSource, nLeft, nRight) {
					var nCurrent;
					if(typeof(nLeft) == 'undefined') {
						nLeft = 0;
						nRight = -1;
						nCurrent = 64;
					}
					else {
						if (nRight == -1)
							nCurrent = nLeft * 2;
						else if (nRight - nLeft <= 1)
							return Math.max(2, nRight);
						else
							nCurrent = nLeft + (nRight - nLeft) / 2;
					}
					var strTest = strSource.substr(0, nCurrent);
					var bLonger = testBreak(strTest);
					if(bLonger)
						nRight = nCurrent;
					else
					{
						if(nCurrent >= strSource.length)
							return null;
						nLeft = nCurrent;
					}
					return findNextBreakLength(strSource, nLeft, nRight);
				}
			
				var i = 0, j;
				var strNewValue = "";
				while (i < strRawValue.length) {
					var breakOffset = findNextBreakLength(strRawValue.substr(i));
					if (breakOffset === null) {
						strNewValue += strRawValue.substr(i);
						break;
					}
					nLastWrappingIndex = -1;
					var nLineLength = breakOffset - 1;
					for (j = nLineLength - 1; j >= 0; j--) {
						var curChar = strRawValue.charAt(i + j);
						if (curChar == ' ' || curChar == '-' || curChar == '+') {
							nLineLength = j + 1;
							break;
						}
					}
					strNewValue += strRawValue.substr(i, nLineLength) + "\n";
					i += nLineLength;
				}
				
				oTextarea.value = strNewValue;
				oTextarea.setAttribute("wrap", "");
				var final_html = oTextarea.value;
				final_html=final_html.replace(/\n$/, "");
				final_html = final_html.replace(new RegExp("\\n", "g"), "<br />");
				console.log(final_html);
				$(".textmsg").val(final_html);
			}

			function checkwordsperline(me,line_no){
				var lines = $(me).val().split('\n');
				for(var i = 0;i < lines.length;i++){
					if(line_no==i){
						var split = lines[i].split(' ');
						return split.length;
					}
				}
			}

			function getLineNumber(textarea) {

				return textarea.value.substr(0, textarea.selectionStart).split("\n").length;
			}

			function roundUpToAny($n,$x=5) {
				return Math.round(($n+$x/2)/$x)*$x;
			}

			$(document).on('paste','.hwl_custom_msg', function(e) {
				
				var me=$(this);
				var text=me.val();
				text.replace(/<[\/]{0,1}(p)[^><]*>/ig,"");
				me.val(text);
				// addbreak(me,e);
			})

			function addbreak(me,e){
				var word_count = 0;
				var total_word_count = 0;
				var final_message='';
				setTimeout(function(){
					var split = me.val().split(' ');
					for (var i = 0; i < split.length; i++) {
						if (split[i] != "") {
							word_count += 1;
							total_word_count +=1;
							if(word_count==11&&final_message.slice(-2)!="\n"){
								final_message+=" ";
								word_count=0;
							}else{
								final_message+=split[i]+" ";
							}
							if(text_max<total_word_count){
								break;
							}
						}
						
					}
					var text_remaining = text_max - total_word_count;
					me.parents(".single_row2").find('.wrd-cuntng').html(text_remaining + ' words remaining');
					me.parents(".single_row2").find('.wrd-cuntng').attr('count',text_remaining);
					console.log(final_message);
					console.log(final_message);
					set_target=roundUpToAny(split.length,10);
					//me.val(final_message);
				}, 100);
			}


			// Template Key words
			$(document).on('click','input.group-btn-item',function(){
						var textarea = $("textarea.hwl_custom_msg");
						var currentPos = textarea.prop('selectionStart');
						var textToInsert = $(this).data("placeholder");
						var text = textarea.val();
						var newText = text.substring(0, currentPos) + textToInsert + text.substring(currentPos);
						textarea.val(newText);
						textarea.focus();
						textarea.prop('selectionStart', currentPos + textToInsert.length);
						textarea.prop('selectionEnd', currentPos + textToInsert.length);
						//addbreak(textarea);
					});



	function removeRedcircle(){
		$.each($("#collapseTwo").find('.system_property'),function(){
			if($(this).val()!=''){
				var me=$(this).closest('tr').find('.fa_color_red');
				me.addClass('fa_color_green');
				me.addClass('fa-check-circle');
				me.removeClass('fa_color_red');
				me.removeClass('fa-times-circle');
			}
		})
	}
	$("body").on('click','.system_property',function(){
		removeRedcircle();
	})
	function adjustfontsize(){
		$(".final_preview").removeClass(["font-size-11", "font-size-13", "font-size-15", "font-size-20"]);
		var final_text = $(".final_preview").html();
		console.log(final_text.length);
		switch (true) {
			case final_text.length>=750:
				$(".final_preview").addClass('font-size-11');
				break;
			case final_text.length>=500 && final_text.length<750:
				$(".final_preview").addClass('font-size-13');
				break;
			case final_text.length>=250 && final_text.length<500:
				$(".final_preview").addClass('font-size-15');
				break;
			case final_text.length<250:
				$(".final_preview").addClass('font-size-20');
				break;
		}
	}
	function template(string, obj){
		var s = string;
		for(var prop in obj) {
			s = s.replace(new RegExp('{'+ prop +'}','g'), obj[prop]);
		}
		return s;
	}


    function addtocart(quantity){
        var str = '&product_id=21&quantity='+quantity+'&action=more_post_ajax';
        $.ajax({
            type: "POST",
            dataType: "html",
            url: '',
            data: str,
            success: function (data) {
				$('.woocommerce_checkout_data').html(data);
				xsl_upload(quantity);
				$('body').find("#createaccount").trigger('click');
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }

        });
        return false;
    };
	function xsl_upload(){
        $.ajax({
            type: "POST",
			url: '',
			data:  new FormData($("#xsl_upload")[0]),
			processData: false,
        	contentType: false,
            success: function (data) {
				$("body").find("#xls_files").val(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }

        });
        return false;
    };
	$(".save_message").click(function(){
		adjustfontsize();
		save_message();
        return false;
	})

	function save_message(){
		var str = '&message='+$(".hwl_custom_msg").val()+'&action=save_message';
        $.ajax({
            type: "POST",
            dataType: "html",
            url: '',
            data: str,
            success: function (data) {
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }

        });
	}



	$("body").on('click','.edit_tag',function(){
		if($(this).hasClass('fa-pencil-alt')){
			$(this).closest('div').find('input').prop("disabled", false);
			$(this).removeClass('fa-pencil-alt');
			$(this).addClass('fa-check');
		}else{
			$(this).closest('div').find('input').prop("disabled", true);
			$(this).removeClass('fa-check');
			$(this).addClass('fa-pencil-alt');
		}
	})
	$('.upload_recipients_button').click(function(){
		$(".file_message").html('');
		$('#upload_recipients').trigger('click'); // will behave as if #select-5 is clicked.
	});
	$(function () {
		// $('[data-toggle="tooltip"]').tooltip();
	})
	$(".create_custom_parameter").click(function(){
		var d = bootbox.prompt('Enter Parameter Name',
                                function(result) {
									if(result){
										var upper=result.toUpperCase().replace(/ /g,'_');
										$(`<input type="button" data-toggle="tooltip" data-placement="bottom" name="tags[`+result+`]" class="group-btn-item custom_param action-button action-button-tag" data-placeholder="{`+upper+`}" value="`+result+`" aria-label="`+result+`" data-bs-original-title="`+result+`"><input type="hidden" name="tags[`+upper+`]" value="`+result+`"> `).insertBefore(".create_custom_parameter");
										// $('[data-toggle="tooltip"]').tooltip();
									}

                                });
		d.find('.modal-dialog').addClass('modal-dialog-centered');
	})
	$(".add_campaign_list").click(function(){
		var token =$('meta[name="csrf-token"]').attr('content');
		var url =$("#list_create_url").val();
		var d = bootbox.confirm("<form id='infos' action='"+url+"' method='post'>\
		<input type='hidden' name='_token' value='"+token+"'>\
		<input type='hidden' name='campaign_name' value='"+$("#exampleInputEmail1").val()+"'>\
		Enter Campaign List Name <input type='text' name='campaign_list_name' /><br/>\
		</form>", function(result) {
			if(result){
				$('#infos').submit();
			}
	});
		d.find('.modal-dialog').addClass('modal-dialog-centered');
	})

	$(".assign_card_to_draft_order").click(function(){
		var token =$('meta[name="csrf-token"]').attr('content');
		var url =$(this).data('url');
		if(url==0){
			var d = bootbox.alert({
				message: 'Please add card first.'
				});
			d.find('.modal-dialog').addClass('modal-dialog-centered');
			return false;
		}
		var card_options =$('.payment_method_ids').html();
		var d = bootbox.confirm("<form id='infos' action='"+url+"' method='post'>\
		<input type='hidden' name='_token' value='"+token+"'>\
		Select Payment Card <br/>"+card_options+"\
		</form>", function(result) {
			if(result){
				$('#infos').submit();
			}
	});
		d.find('.modal-dialog').addClass('modal-dialog-centered');
	})

	$(".show_video").click(function(){
		var video_link=$("#"+$(this).data('element')).data('video_link');
		var d = bootbox.alert({
			message: video_link,
			size: 'large'
			});
		d.find('.modal-dialog').addClass('modal-dialog-centered');
	})
	$(".model_preview").click(function(){
		var style=$(this).attr('style');
		var img_link=$(this).data('url');
		var d = bootbox.alert({
			message: "<img style='"+style+"' src='"+img_link+"'>",
			size: 'large',
			backdrop: true
			});
		d.find('.modal-dialog').addClass('modal-dialog-centered');
	})
	$("body").on('change','.select_font',function(){
		console.log($(this).val());
		$(".font_change").css("font-family", $(this).val());
	})
	$("body").on('click','.action_btn',function(){
		var data = [
			['FIRST_NAME','LAST_NAME','COMPANY_NAME','PHONE','EMAIL','ADDRESS','CITY','STATE','ZIP'],
			['Kiley','Caldarera','Feiner Bros','310-498-5651','kiley.caldarera@email.com','25 E 75th St #69','Los Angeles','California ','90034'],
			['Dyan','Oldroyd','International Eyelets Inc','913-413-4604','doldroyd@email.com','7219 Woodfield Rd','Overland Park','Kansas','66204'],
		];
		// var custom_params=$('#custom_params').val();
		// console.log(custom_params);
		// $.each(JSON.parse(custom_params),function(k,v){
		// 	if(k!='FIRST_NAME'&&k!='LAST_NAME'){
		// 		data[0].push(k);
		// 		data[1].push(v+" 1");
		// 		data[2].push(v+" 2");
		// 	}
		// })
		var wscols = [
			{wch:25},
			{wch:25},
			{wch:25},
			{wch:25},
			{wch:25},
			{wch:25},
			{wch:25},
			{wch:25},
			{wch:25},
			{wch:25},
			{wch:25},
			{wch:25}
		];


		var workbook = XLSX.utils.book_new(),
			worksheet = XLSX.utils.aoa_to_sheet(data);
			worksheet['!cols'] = wscols;
		workbook.SheetNames.push("First");
		workbook.Sheets["First"] = worksheet;
		XLSX.writeFile(workbook, "Bulk file Default Fields and Data.xlsx");
		window.close();

	})


	$('.upload_last_file_and_message').on('click',function(){
		save_message();
		uploadDynamicfileServer();
	})

	function uploadDynamicfileServer(){
		var fileUpload = $("#upload_recipients")[0];

		var reader = new FileReader();

		//For Browsers other than IE.
		if (reader.readAsBinaryString) {
			reader.onload = function (e) {
				ProcessExcel1(e.target.result);
			};
			reader.readAsBinaryString(fileUpload.files[0]);
		} else {
			//For IE Browser.
			reader.onload = function (e) {
				var data = "";
				var bytes = new Uint8Array(e.target.result);
				for (var i = 0; i < bytes.byteLength; i++) {
					data += String.fromCharCode(bytes[i]);
				}
				ProcessExcel1(data);
			};
			reader.readAsArrayBuffer(fileUpload.files[0]);
		}

	}

	function ProcessExcel1(data){
		var wscols = [
			{wch:25},
			{wch:25},
			{wch:25},
			{wch:25},
			{wch:25},
			{wch:25},
			{wch:25},
			{wch:25},
			{wch:25},
			{wch:25},
			{wch:25},
			{wch:25}
		];

		var workbook = XLSX.read(data, {
            type: 'binary'
        });
		var worksheet=workbook.Sheets['First'];
		var range = XLSX.utils.decode_range(worksheet['!ref']);

		var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets['First']);

		var final_message=[];
		final_message[0]=['FINAL_MESSAGE'];

		Object.keys(excelRows).forEach(function (key) {
			var custom_properties_values={};
			Object.keys(excelRows[key]).forEach(function (key1) {
				custom_properties_values[key1]=excelRows[key][key1];

			})
			if(final_message[parseInt(key)+1]==undefined){
				final_message[parseInt(key)+1]=[];
			}
			final_message[parseInt(key)+1][0]=template($(".hwl_custom_msg").val(),custom_properties_values);
		})

		XLSX.utils.sheet_add_aoa(workbook.Sheets['First'],final_message, {origin:{r:0, c:range.e.c+1}});

		workbook.Sheets['First']['!cols'] = wscols;

        var data = XLSX.write(workbook, {bookType: 'xlsx', type: 'array'});

		var fdata = new FormData();
		fdata.append('upload_recipients', new File([data], 'sheetjs.xlsx'));
		fdata.append('action','upload_xls_files');
		fdata.append('meta_name','upload_recipients_file_final');
		fdata.append('file_rows',$(".file_rows").val());
		var req = new XMLHttpRequest();
		req.open("POST", "", true);
		req.send(fdata);
	}

	//================= set min date================
	// elem = document.getElementById("dateInput")
    // var iso = new Date().toISOString();
    // var minDate = iso.substring(0,iso.length-1);
    // elem.value = minDate
    // elem.min = minDate
	//================= set min date================
	$("#dateInput").hide();
	$('input[name="publish_type"]').change(function(){
		$("#dateInput").toggle();
	})


		});

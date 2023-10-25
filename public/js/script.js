$(document).ready(function() {

  $(".sidebar-parent-menu a").click(function(){
    var me_sidebar =$(this);
    $id = $(this).data('id');
    $(".sidebar-parent-menu i").not($(this).find('i')).addClass('fa-angle-down');
    $(".sidebar-parent-menu i").not($(this).find('i')).removeClass('fa-angle-up');
  	$(".sidebar-child-menu").not($(this).closest('li').find('.sidebar-child-menu')).css("display","none");
  	$(".sidebar-child-menu[data-content-id="+$id+"]").toggle( 'fast', function(){
      var $el = me_sidebar.find('i');
      if ($el.hasClass('fa-angle-down')) {
        $el.removeClass('fa-angle-down');
        $el.addClass('fa-angle-up');
      }else{
        $el.removeClass('fa-angle-up');
        $el.addClass('fa-angle-down');
      }
   });
  });

  $sidebarWidth = $("#sidebar").width();
 $(".container-fluid").not('.header').css("padding-left",$sidebarWidth + 20 +"px");

 $sidebarWidth1 = $("#header").height();
 $(".sidebar-menu").css("margin-top",$sidebarWidth1+"px");


  $("#sidebarCollapse").on("click", function() {
    $("#sidebar").slideToggle('slow','swing',function(){
        if($("#sidebarCollapse").hasClass('active')){
          $("#sidebarCollapse").removeClass('active');
          $(".container-fluid").not('.header').animate({
            'padding-left' : $sidebarWidth + 20 +"px",
          }, "slow");
        }else{
          $("#sidebarCollapse").addClass('active');
          $(".container-fluid").not('.header').animate({
            'padding-left' : "10px",
          }, "slow");
        }
    });
  });


});


$(document).ready(function() {
  $(".sidebar-parent-menu a").click(function(){
  	$(".sidebar-child-menu").removeClass("show");
  	$id = $(this).data('id');
  	
  	$(".sidebar-child-menu[data-content-id="+$id+"]").addClass("show");
  });

  $sidebarWidth = $("#sidebar").width();


 $('.wizard li').click(function() {
 $(this).prevAll().addClass("completed");
  $(this).nextAll().removeClass("completed");

});

$(".step-1-option").click(function(){
  var forRadio = $(this).attr("for");
  $('#'+forRadio).prop("checked", true);
  $(".step-1-option").removeClass("selected");
  $(this).addClass("selected");
});

// Custom File Upload 
 var isAdvancedUpload = function() {
  var div = document.createElement('div');
  return (('draggable' in div) || ('ondragstart' in div && 'ondrop' in div)) && 'FormData' in window && 'FileReader' in window;
}();

let draggableFileArea = document.querySelector(".drag-file-area");
let browseFileText = document.querySelector(".browse-files");
let uploadIcon = document.querySelector(".upload-icon");
let dragDropText = document.querySelector(".dynamic-message");
let fileInput = document.querySelector(".default-file-input");
let cannotUploadMessage = document.querySelector(".cannot-upload-message");
let cancelAlertButton = document.querySelector(".cancel-alert-button");
let uploadedFile = document.querySelector(".file-block");
let fileName = document.querySelector(".file-name");
let fileSize = document.querySelector(".file-size");
let progressBar = document.querySelector(".progress-bar");
let removeFileButton = document.querySelector(".remove-file-icon");
let uploadButton = document.querySelector(".upload-button");
let fileFlag = 0;

fileInput.addEventListener("click", () => {
	fileInput.value = '';
	console.log(fileInput.value);
});

fileInput.addEventListener("change", e => {
	console.log(" > " + fileInput.value)
	uploadIcon.classList.add("file-uploaded");
	// dragDropText.innerHTML = 'File Dropped Successfully!';
	// document.querySelector(".label").innerHTML = `drag & drop or <span class="browse-files"> <input type="file" class="default-file-input" style=""/> <span class="browse-files-text" style="top: 0;"> browse file</span></span>`;
	// uploadButton.innerHTML = `Upload`;
	fileName.innerHTML = fileInput.files[0].name;
	fileSize.innerHTML = (fileInput.files[0].size/1024).toFixed(1) + " KB";
	uploadedFile.style.cssText = "display: flex;";
	progressBar.style.width = 0;
	fileFlag = 0;
});

uploadButton.addEventListener("click", () => {
	let isFileUploaded = fileInput.value;
	if(isFileUploaded != '') {
		if (fileFlag == 0) {
    		fileFlag = 1;
    		var width = 0;
    		var id = setInterval(frame, 50);
    		function frame() {
      			if (width >= 390) {
        			clearInterval(id);
					uploadButton.innerHTML = `<span class="material-icons-outlined upload-button-icon"> check_circle </span> Uploaded`;
      			} else {
        			width += 5;
        			progressBar.style.width = width + "px";
      			}
    		}
  		}
	} else {
		cannotUploadMessage.style.cssText = "display: flex; animation: fadeIn linear 1.5s;";
	}
});

cancelAlertButton.addEventListener("click", () => {
	cannotUploadMessage.style.cssText = "display: none;";
});

if(isAdvancedUpload) {
	["drag", "dragstart", "dragend", "dragover", "dragenter", "dragleave", "drop"].forEach( evt => 
		draggableFileArea.addEventListener(evt, e => {
			e.preventDefault();
			e.stopPropagation();
		})
	);

	["dragover", "dragenter"].forEach( evt => {
		draggableFileArea.addEventListener(evt, e => {
			e.preventDefault();
			e.stopPropagation();
			uploadIcon.classList.add("file-uploaded");
			//uploadIcon.innerHTML = 'file_download';
			dragDropText.innerHTML = 'Drop your file here!';
		});
	});

	draggableFileArea.addEventListener("drop", e => {
		uploadIcon.classList.add("my-class");
		dragDropText.innerHTML = 'File Dropped Successfully!';
		// document.querySelector(".label").innerHTML = `drag & drop or <span class="browse-files"> <input type="file" class="default-file-input" style=""/> <span class="browse-files-text" style="top: -23px; left: -20px;"> browse file</span> </span>`;
		// uploadButton.innerHTML = `Upload`;
		
		let files = e.dataTransfer.files;
		fileInput.files = files;
		console.log(files[0].name + " " + files[0].size);
		console.log(document.querySelector(".default-file-input").value);
		fileName.innerHTML = files[0].name;
		fileSize.innerHTML = (files[0].size/1024).toFixed(1) + " KB";
		uploadedFile.style.cssText = "display: flex;";
		progressBar.style.width = 0;
		fileFlag = 0;
	});
}

removeFileButton.addEventListener("click", () => {
	uploadedFile.style.cssText = "display: none;";
	fileInput.value = '';
	uploadIcon.classList.remove("file-uploaded");
	//uploadIcon.innerHTML = 'file_upload';
	dragDropText.innerHTML = 'Drag & drop any file here';
	// document.querySelector(".label").innerHTML = `or <span class="browse-files"> <input type="file" class="default-file-input"/> <span class="browse-files-text">browse file</span> <span>from device</span> </span>`;
	// uploadButton.innerHTML = `Upload`;
});

// Custom File Upload Ends



// Custom Select 

$(".custom-select").each(function() {
  var classes = $(this).attr("class"),
      id      = $(this).attr("id"),
      name    = $(this).attr("name");
  var template =  '<div class="' + classes + '">';
      template += '<span class="custom-select-trigger">' + $(this).attr("placeholder") + '</span>';
      template += '<div class="custom-options">';
      $(this).find("option").each(function() {
        template += '<span class="custom-option ' + $(this).attr("class") + '" data-value="' + $(this).attr("value") + '">' + $(this).html() + '</span>';
      });
  template += '</div></div>';
  
  $(this).wrap('<div class="custom-select-wrapper"></div>');
  $(this).hide();
  $(this).after(template);
});
$(".custom-option:first-of-type").hover(function() {
  $(this).parents(".custom-options").addClass("option-hover");
}, function() {
  $(this).parents(".custom-options").removeClass("option-hover");
});
$(".custom-select-trigger").on("click", function() {
  $('html').one('click',function() {
    $(".custom-select").removeClass("opened");
  });
  $(this).parents(".custom-select").toggleClass("opened");
  event.stopPropagation();
});
$(".custom-option").on("click", function() {
  $(this).parents(".custom-select-wrapper").find("select").val($(this).data("value"));
  $(this).parents(".custom-options").find(".custom-option").removeClass("selection");
  $(this).addClass("selection");
  $(this).parents(".custom-select").removeClass("opened");
  $(this).parents(".custom-select").find(".custom-select-trigger").text($(this).text());
});



});




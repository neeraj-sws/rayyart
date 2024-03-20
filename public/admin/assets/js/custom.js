
$(function () {
	'use strict'

	$('.select2').select2({
		width: 'resolve'
	});

	$('.multiSelect2').select2({
		width: 'resolve'
	});

	$('#modal-lg').modal({
		backdrop: 'static',
		keyboard: false
	});

	// Input Password js
	$("#show_hide_password a").on('click', function (event) {
		event.preventDefault();
		if ($('#show_hide_password input').attr("type") == "text") {
			$('#show_hide_password input').attr('type', 'password');
			$('#show_hide_password i').addClass("bx-hide");
			$('#show_hide_password i').removeClass("bx-show");
		} else if ($('#show_hide_password input').attr("type") == "password") {
			$('#show_hide_password input').attr('type', 'text');
			$('#show_hide_password i').removeClass("bx-hide");
			$('#show_hide_password i').addClass("bx-show");
		}
	});


	$(".allowno").keypress(function (e) {
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			e.preventDefault();
		}
	});
	$('.allowno').on('paste', function (e) {
		if (e.originalEvent.clipboardData.getData('Text').match(/[^\d]/)) {
			e.preventDefault();
		}
	});

	if ($('.tinymceEditor').length) {

		tinymce.init({
			selector: '.tinymceEditor ',
			media_dimensions: false,
			media_alt_source: false,
			media_poster: false,
			paste_block_drop: false,
			plugins: 'contextmenu print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',

			imagetools_cors_hosts: ['picsum.photos'],
			menubar: 'file edit view insert format tools table help',
			toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample blockquote| ltr rtl | imageupload cut copy paste',
			toolbar_sticky: false,
			autosave_ask_before_unload: true,
			autosave_interval: '30s',
			height: 600,
			image_caption: true,

			content_style: "@import url('https://fonts.googleapis.com/css2?family=Oswald&display=swap'); body { font-family: Oswald; }",
			quickbars_selection_toolbar: 'bold italic underline strikethrough | cut copy paste | quicklink blockquote quickimage quicktable',
			noneditable_noneditable_class: 'mceNonEditable',
			toolbar_mode: 'wrap',
			contextmenu: 'cut copy paste | bold italic underline strikethrough | link image imagetools table',
			skin: 'oxide',
			content_css: 'default',
			content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
			image_title: true,
			automatic_uploads: true,
			images_upload_url: "{{ route('admin.product-image.upload') }}",
			images_upload_credentials: true,
			relative_urls: false,
			remove_script_host: false,
			file_picker_types: 'image',


			setup: function (editor) {
				editor.on('change', function () {
					editor.save();
				});
			},
		});

	}

	if ($('.tinymcetextarea').length) {

		tinymce.init({
			selector: '.tinymcetextarea',
			
			setup: function (editor) {
				editor.on('change', function () {
					editor.save();
				});
			},
		});

	}
	$('#modal-lg').on('shown.bs.modal', function () {
		if ($('.tinymceEditor').length) {

			tinymce.init({
				selector: '.tinymceEditor ',
				
				setup: function (editor) {
					editor.on('change', function () {
						editor.save();
					});
				},
			});
	
		}

		if ($('.tinymcetextarea').length) {

			tinymce.init({
				selector: '.tinymcetextarea',
				file_picker_types: 'file, media',
				file_browser_callback_types: 'file, media',
				file_picker_callback: false,
				media_dimensions: false,
				media_alt_source: false,
				media_poster: false,
				paste_block_drop: false,
				plugins: ' image link media imagetools advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount',
	
	
				imagetools_cors_hosts: ['picsum.photos'],
				menubar: 'file edit view insert format tools table help',
				toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen | insertfile image template link codesample ',
	
				toolbar_sticky: false,
				autosave_ask_before_unload: true,
				autosave_interval: '30s',
				height: 400,
				image_caption: false,
	
				content_style: "@import url('https://fonts.googleapis.com/css2?family=Oswald&display=swap'); body { font-family: Oswald; }",
				quickbars_selection_toolbar: 'bold italic underline strikethrough | cut copy paste | quicklink blockquote quickimage quicktable',
				noneditable_noneditable_class: 'mceNonEditable',
				toolbar_mode: 'wrap',
				contextmenu: 'cut copy paste | bold italic underline strikethrough | link image imagetools table',
				content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
				image_title: true,
				automatic_uploads: true,
				images_upload_url: "{{ route('admin.product-image.upload') }}",
	
				images_upload_credentials: true,
				relative_urls: false,
				remove_script_host: false,
				file_picker_types: 'image',
				setup: function (editor) {
					editor.on('change', function () {
						editor.save();
					});
				},
			});
	
		}

		$('.select2').select2({
			width: 'resolve'
		});

		$('.multiSelect2').select2({
			width: 'resolve'
		});
	});

	if ($('.dateTimePicker').length) {


		$('.dateTimePicker').appendDtpicker({
			"dateFormat": "MM-DD-YYYY HH:mm:TT",
			"closeOnSelected": true,
			"futureOnly": true,
			"amPmInTimeList": true,
			"autodateOnStart": false,
			"onSelect": function (handler, targetDate) {
				var hidDate = moment(handler.getDate()).format('YYYY-MM-DD hh:mm');
				// alert(hidDate);
				$('#hidDate').val(hidDate);
			}
		});

	}

}); (jQuery);




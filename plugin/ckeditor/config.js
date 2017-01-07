/**
 * @license Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	config.language = 'ko';
	config.uiColor = '#E6F0E5';
	// config.font_defaultLabel = '굴림';
	config.enterMode = CKEDITOR.ENTER_BR;
	config.shiftEnterMode = CKEDITOR.ENTER_P;
	// config.startupFocus = true;
	config.forcePasteAsPlainText = true;
	config.pasteFromWordRemoveFontStyles = true;
	config.pasteFromWordRemoveStyles = true;
	// config.fontSize_defaultLabel = '11px';
	config.fontSize_sizes = '8/8px;9/9px;10/10px;11/11px;12/12px; 13/13px; 14/14px; 15/15px; 16/16px;18/18px;20/20px;22/22px;24/24px;26/26px;28/28px;36/36px;48/48px;72/72px'
	// config.extraPlugins = 'autogrow';
	// config.autoGrow_onStartup = true;
	config.menu_subMenuDelay = 0;
	config.toolbar = 'Full';
	config.toolbar_Full =
	[
		{ name: 'insert', items : [ 'Source','Table','HorizontalRule','Smiley','SpecialChar','Iframe' ] },
		{ name: 'links', items : [ 'Link','Unlink','PageBreak','Anchor' ] },
		{ name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
		{ name: 'document', items : [ 'Preview','Print','-','Templates' ] },
		{ name: 'styles', items : [ 'Styles','FontSize' ] },
		'/',
		{ name: 'colors', items : [ 'TextColor','BGColor' ] },
		{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
		{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote',
		'-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] }
	];
	// config.toolbar_Full =
	// [
		// { name: 'document', items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
		// { name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
		// { name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
		// { name: 'forms', items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 
			// 'HiddenField' ] },
		// '/',
		// { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
		// { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv',
		// '-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
		// { name: 'links', items : [ 'Link','Unlink','Anchor' ] },
		// { name: 'insert', items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ] },
		// '/',
		// { name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
		// { name: 'colors', items : [ 'TextColor','BGColor' ] },
		// { name: 'tools', items : [ 'Maximize', 'ShowBlocks','-','About' ] }
	// ];
	// config.shiftEnterMode = CKEDITOR.ENTER_P;
	// config.extraPlugins = 'stylescombo';
	// config.extraPlugins = 'stylesheetparser';
	// config.stylesSet = 'default:mystyles.js';
	// config.height = 500;
};

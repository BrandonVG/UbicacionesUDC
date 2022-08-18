/**
* @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
* For licensing, see LICENSE.md or http://ckeditor.com/license
*/



CKEDITOR.editorConfig = function( config ) {
	//Define changes to default configuration here. For example:
	//config.language = 'fr';
	//config.uiColor = '#AADC6E';
	config.filebrowserBrowseUrl = '/ubicaciones/includes/editor/ckfinder/ckfinder.html';
    config.filebrowserImageBrowseUrl = '/ubicaciones/includes/editor/ckfinder/ckfinder.html?type=Images';
    config.filebrowserFlashBrowseUrl = '/ubicaciones/includes/editor/ckfinder/ckfinder.html?type=Flash';
    config.filebrowserUploadUrl = '/ubicaciones/includes/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
    config.filebrowserImageUploadUrl = '/ubicaciones/includes/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
    config.filebrowserFlashUploadUrl = '/ubicaciones/includes/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
	config.height = 800;
	config.skin = 'moono-lisa';
	config.allowedContent = true;
	config.language = 'es';
	config.removePlugins = 'print,language,smiley,locationmap,googledocs,accordionList,collapsibleItem,bootstrapTabs,forms,font';
	config.extraPlugins = 'youtube';
	config.forcePasteAsPlainText = true;
};

/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

// Register a templates definition set named "default".
CKEDITOR.addTemplates( 'default', {
	// The name of sub folder which hold the shortcut preview images of the
	// templates.
	imagesPath: CKEDITOR.getUrl( CKEDITOR.plugins.getPath( 'templates' ) + 'templates/images/' ),

	// The templates definitions.
  templates:[{
    title:'Two Columns',
    image:'two-columns.gif',
    description:'Div container with two columns.',
    html:'<p>Text before two columns.</p><div class="row two-columns"><div class="left-column"><p>Left Column</p></div><div class="right-column"><p>Right Column</p></div></div><p>Text after two columns.</p>'
    }
  ]});

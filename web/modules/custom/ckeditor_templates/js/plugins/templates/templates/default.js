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
  templates:[
		{
	    title:'Two Columns (Newspaper)',
	    image:'two-columns.gif',
	    description:'Div container with two columns.',
	    html:'<p>Text before two columns.</p><div class="two-columns newspaper"><div class="left-column"><p>Left Column</p></div><div class="right-column"><p>Right Column</p></div></div><p>Text after two columns.</p>'
		},
		{
			title:'Two Columns (Table)',
			image:'two-columns.gif',
			description:'Define a responsive friendly table to add rows too.',
			html:'<div class="two-columns table"><ul><li>Column One</li><li>Column 2</li></ul></div>'
		}
  ]});

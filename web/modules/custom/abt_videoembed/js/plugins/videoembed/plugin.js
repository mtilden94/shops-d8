/**
 * @file
 * Plugin to insert videoembed elements.
 *
 * Created out of the CKEditor Plugin SDK:
 * http://docs.ckeditor.com/#!/guide/plugin_sdk_sample_1
 */

(function ($) {

  // Register the plugin within the editor.
  CKEDITOR.plugins.add('videoembed', {
    lang: 'en',

    // Register the icons.
    icons: 'videoembed',

    // The plugin initialization logic goes inside this method.
    init: function (editor) {
      var lang = editor.lang.videoembed;

      // Define an editor command that opens our dialog.
      editor.addCommand('videoembed', new CKEDITOR.dialogCommand('videoembedDialog', {

        // Allow abbr tag with optional title.
        //allowedContent: 'abbr[title]',
        allowedContent: 'video iframe a',
        requiredContent: 'video',

        // Require abbr tag to be allowed to work.
        //requiredContent: 'abbr',

        // Prefer abbr over acronym. Transform acronyms into abbrs.
        //contentForms: [
        //        'abbr',
        //        'acronym'
        //]
      }));

      // Create a toolbar button that executes the above command.
      editor.ui.addButton('videoembed', {

        // The text part of the button (if available) and tooptip.
        label: lang.buttonTitle,

        // The command to execute on click.
        command: 'videoembed',

        // The button placement in the toolbar (toolbar group name).
        toolbar: 'insert',

        // The path to the icon.
        icon: this.path + 'icons/videoembed.png'
      });

      if (editor.contextMenu) {
        editor.addMenuGroup('videoembedGroup');
        editor.addMenuItem('videoembedItem', {
          label: lang.menuItemTitle,
          icon: this.path + 'icons/videoembed.png',
          command: 'videoembed',
          group: 'videoembedGroup'
        });

        editor.contextMenu.addListener(function (element) {
          if (element.getAscendant('video', true)) {
            return { videoItem: CKEDITOR.TRISTATE_OFF };
          }
        });
      }

      // Register our dialog file. this.path is the plugin folder path.
      CKEDITOR.dialog.add('videoembedDialog', this.path + 'dialogs/videoembed.js');
    }
  });
})(jQuery);

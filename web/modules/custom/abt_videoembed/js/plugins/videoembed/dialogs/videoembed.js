/**
 * @file
 * The vidoeembed dialog definition.
 *
 * Created out of the CKEditor Plugin SDK:
 * http://docs.ckeditor.com/#!/guide/plugin_sdk_sample_1
 */

// Our dialog definition.
CKEDITOR.dialog.add('videoembedDialog', function (editor) {
  var lang = editor.lang.videoembed;

  return {

    // Basic properties of the dialog window: title, minimum size.
    title: lang.dialogTitle,
    minWidth: 400,
    minHeight: 200,

    // Dialog window contents definition.
    contents: [
    {
      // Definition of the Basic Settings dialog tab (page).
      id: 'tab-basic',
      label: 'Basic Settings',

      // The tab contents.
      elements: [
      {
        // Text input field for the abbreviation text.
        type: 'textarea',
        id: 'div',
        label: lang.dialogVideoEmbedTitle,

        // Validation checking whether the field is not empty.
        validate: CKEDITOR.dialog.validate.notEmpty("Video Embed field cannot be empty"),

        // Called by the main setupContent call on dialog initialization.
        setup: function (element) {
          this.setValue(element.getElementsByTag('iframe').getItem(0).getOuterHtml());
        },

        // Called by the main commitContent call on dialog confirmation.
        commit: function (element) {
          if (element.getElementsByTag('iframe').count() > 0){
            element.getElementsByTag('iframe').getItem(0).replace(CKEDITOR.dom.element.createFromHtml(this.getValue()));
          }else{
            element.appendHtml('<div class="inline-colorbox-content" id="colorbox-youtube">' + this.getValue() + '</div>');
          }
        }
      },
      {
        // Text input field for the link text.
        type: 'text',
        id: 'linktext',
        label: lang.dialogLinkText,

        validate: CKEDITOR.dialog.validate.notEmpty("Link Text cannot be empty"),
        // Require title attribute to be enabled.
        //requiredContent: 'abbr[title]',

        // Called by the main setupContent call on dialog initialization.
        setup: function (element) {
          this.setValue(element.getElementsByTag('a').getItem(0).getText());
        },

        // Called by the main commitContent call on dialog confirmation.
        commit: function (element) {
          if (element.getElementsByTag('a').count() > 0){
            element.getElementsByTag('a').getItem(0).setText(this.getValue());
          }else{
            element.appendHtml('<a data-colorbox-inline="#colorbox-youtube">' + this.getValue() + '</a>');
          }
        }
      }
      ]
    },
    ],

    // Invoked when the dialog is loaded.
    onShow: function () {

      // Get the selection in the editor.
      var selection = editor.getSelection();

      // Get the element at the start of the selection.
      var element = selection.getStartElement();

      // Get the <abbr> element closest to the selection, if any.
      if (element) {
        element = element.getAscendant('div', true);
      }

      // Create a new <abbr> element if it does not exist.
      if (!element || element.getName() != 'div') {
        element = editor.document.createElement('div');

        // Flag the insertion mode for later use.
        this.insertMode = true;
      }
      else {
        this.insertMode = false;
      }

      // Store the reference to the <abbr> element in an internal property, for later use.
      this.element = element;

      // Invoke the setup methods of all dialog elements, so they can load the element attributes.
      if (!this.insertMode) {
        this.setupContent(this.element);
      }
    },

    // This method is invoked once a user clicks the OK button, confirming the dialog.
    onOk: function () {

      // The context of this function is the dialog object itself.
      // http://docs.ckeditor.com/#!/api/CKEDITOR.dialog
      var dialog = this;

      // Creates a new <abbr> element.
      var videoembed = this.element;

      // Invoke the commit methods of all dialog elements, so the <abbr> element gets modified.
      this.commitContent(videoembed);

      // Finally, in if insert mode, inserts the element at the editor caret position.
      if (this.insertMode) {
        editor.insertElement(videoembed);
      }
    }
  };
});

// Hello button code
var HelloModule = (function () {
  var wasButtonPushed = false;

  var triggerPush = function () {
    if (wasButtonPushed === false) {
      $.get(hello_button_object.ajax_url, { action: 'say_hello'})
      .done(function(data) {
        wasButtonPushed = true;
      })
    } else {
      console.log("No button mashing!")
    }
  };

  return {
    updateButton: function () {
      $('div#hello-button').children('p.send').fadeOut(300);
      $('div#hello-button').children('p.sent').fadeIn(600);
      triggerPush();
    }
  }
})();

// Hello Button Event Handler
$('div#hello-button').click(HelloModule.updateButton);

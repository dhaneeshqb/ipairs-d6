Drupal.behaviors.autologout = function (context) {

  if (context !== document) {
    return;
  }

  var paddingTimer;
  var t;
  var theDialog;

  // Activity is a boolean used to detect a user has
  // interacted with the page.
  var activity;

  if (Drupal.settings.autologout.refresh_only) {
    // On pages that cannot be logged out of don't start the logout countdown.
    t = setTimeout(keepAlive, Drupal.settings.autologout.timeout);
  }
  else {

    // Set no activity to start with.
    activity = false;

    // Make form editing keep the user logged in.
    var events = 'change click blur keyup';
    $('body')
      .find(':input').andSelf().filter(':input')
      .unbind(events).bind(events, function () {
        activity = true;
      });

    // Support for CKEditor.
    if (typeof CKEDITOR !== 'undefined') {
      CKEDITOR.on('instanceCreated', function(e) {
        e.editor.on('contentDom', function() {
          e.editor.document.on('keyup', function(event) {
            // Keyup event in ckeditor should prevent autologout.
            activity = true;
          });
        });
      });
    }

    // On pages where the user can be logged out, set the timer to popup
    // and log them out.
    t = setTimeout(init, Drupal.settings.autologout.timeout);
  }

  function init() {
    if (Drupal.settings.autologout.jquery_ui) {
      if (activity) {
        // The user has been active on the page.
        activity = false;
        refresh();
      }
      else {

        // The user has not been active, ask them if they want to stay logged in
        // and start the logout timer.
        paddingTimer = setTimeout(confirmLogout, Drupal.settings.autologout.timeout_padding);

        // While the countdown timer is going, lookup the remaining time. If there
        // is more time remaining (i.e. a user is navigating in another tab), then
        // reset the timer for opening the dialog.
        $.ajax({
          url : Drupal.settings.basePath + 'autologout_ajax_get_time_left',
          dataType: 'json',
          success: function(data) {
            if (data.time > 0) {
              clearTimeout(paddingTimer);
              t = setTimeout(init, data.time);
              refresh_timer(data.data);
            }
            else {
              theDialog = dialog();
            }
          },
          error: function(XMLHttpRequest, textStatus) {
            if (XMLHttpRequest.status == 403) {
              window.location = Drupal.settings.autologout.redirect_url;
            }
          }
        });
      }
    }
    else {
      if (confirm(Drupal.settings.autologout.message) ) {
        refresh();
      }
      else {
        logout();
      }
    }
  }

  function keepAlive() {
    $.ajax({
      url: Drupal.settings.basePath + "autologout_ahah_set_last",
      type: "POST",
      dataType: 'json',
      success: function(data) {
        // After keeping the connection alive, start the timer again.
        t = setTimeout(keepAlive, Drupal.settings.autologout.timeout);
        activity = false;
        refresh_timer(data.data);
      },
      error: function(XMLHttpRequest, textStatus) {
        if (XMLHttpRequest.status == 403) {
          window.location = Drupal.settings.autologout.redirect_url;
        }
      }
    });
  }

  function dialog() {
    var buttons = {};
    buttons[Drupal.t('Yes')] = function() {
      $(this).dialog("destroy");
      clearTimeout(paddingTimer);
      refresh();
    };

    buttons[Drupal.t('No')] = function() {
      $(this).dialog("destroy");
      logout();
    };

    return $('<div>' +  Drupal.settings.autologout.message + '</div>').dialog({
      modal: true,
      closeOnEscape: false,
      width: 'auto',
      dialogClass: 'autologout-dialog',
      buttons: buttons,
      title: Drupal.settings.autologout.title,
      close: function(event, ui) {
        logout();
      }
    });
  }

  function refresh() {
    $.ajax({
      url: Drupal.settings.basePath + 'autologout_ahah_set_last',
      type: "POST",
      dataType: 'json',
      success: function(data) {
        t = setTimeout(init, Drupal.settings.autologout.timeout);
        refresh_timer(data.data);
      },
      error: function(XMLHttpRequest, textStatus) {
        if (XMLHttpRequest.status == 403) {
          window.location = Drupal.settings.autologout.redirect_url;
        }
      }
    });
  }

  // A user could have used the reset button on the tab/window they're actively
  // using, so we need to double check before actually logging out.
  function confirmLogout() {
    $(theDialog).dialog('destroy');
    $.ajax({
      url : Drupal.settings.basePath + 'autologout_ajax_get_time_left',
      dataType: 'json',
      error: logout,
      success: function(data) {
        if (data.time > 0) {
          t = setTimeout(init, data.time);
          refresh_timer(data.data);
        }
        else {
          logout();
        }
      }
    });
  }

  function logout() {
    $.ajax({
      url: Drupal.settings.basePath + 'autologout_ahah_logout',
      type: "POST",
      success: function() {
        document.location.href = Drupal.settings.autologout.redirect_url;
      },
      error: function(XMLHttpRequest, textStatus) {
        if (XMLHttpRequest.status == 403) {
          window.location = Drupal.settings.autologout.redirect_url;
        }
      }
    });
  }

  function refresh_timer(markup) {
    var $timer = $('#timer');
    if ($timer.length !== 0) {
      // Replace the JS markup for timer.
      $timer.replaceWith(markup);
      // Force a refresh of all timers.
      Drupal.behaviors.jstimer(context);
    }
  }

  // Check if the page was loaded via a back button click.
  var $dirty_bit = $('#autologout-cache-check-bit');
  if ($dirty_bit.length !== 0) {
    if ($dirty_bit.val() == '1') {
      // Page was loaded via a back button click, we should
      // refresh the timer.
      refresh();
    }

    $dirty_bit.val('1');
  }
};

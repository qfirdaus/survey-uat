(function (window, document) {
  'use strict';

  var OVERLAY_ID = 'iqs-box-loader';
  var currentToken = 0;
  var forceTimer = null;
  var hideTimer = null;
  var exitTimer = null;
  var shownAt = 0;
  var MIN_VISIBLE_MS = 280;
  var EXIT_MS = 170;
  var defaultI18n = window.IQS_LOADER_I18N || {};

  function resolveMessage(message) {
    if (typeof message === 'string' && message.trim() !== '') {
      return message;
    }
    return defaultI18n.defaultMessage || 'Loading...';
  }

  function ensureOverlay() {
    var existing = document.getElementById(OVERLAY_ID);
    if (existing) {
      existing.classList.remove('is-hiding');
      return existing;
    }

    var overlay = document.createElement('div');
    overlay.id = OVERLAY_ID;
    overlay.className = 'iqs-box-loader';
    overlay.setAttribute('role', 'status');
    overlay.setAttribute('aria-live', 'polite');
    overlay.setAttribute('aria-busy', 'true');

    var panel = document.createElement('div');
    panel.className = 'iqs-box-loader__panel';

    var boxes = document.createElement('div');
    boxes.className = 'iqs-box-loader__boxes';
    boxes.setAttribute('aria-hidden', 'true');
    for (var i = 0; i < 4; i += 1) {
      boxes.appendChild(document.createElement('span'));
    }

    var text = document.createElement('div');
    text.className = 'iqs-box-loader__text';
    text.setAttribute('data-iqs-loader-text', '1');

    panel.appendChild(boxes);
    panel.appendChild(text);
    overlay.appendChild(panel);
    document.body.appendChild(overlay);
    return overlay;
  }

  function setText(overlay, message) {
    var text = overlay.querySelector('[data-iqs-loader-text]');
    if (text) {
      text.textContent = resolveMessage(message);
    }
  }

  function show(message, options) {
    var settings = options || {};
    var overlay = ensureOverlay();
    var token = String(++currentToken);

    clearTimeout(hideTimer);
    clearTimeout(exitTimer);
    shownAt = Date.now();
    overlay.dataset.iqsLoaderToken = token;
    setText(overlay, message || settings.message);
    overlay.hidden = false;
    overlay.classList.remove('is-hiding');
    overlay.setAttribute('aria-busy', 'true');

    clearTimeout(forceTimer);
    var timeout = Number(settings.timeout || 30000);
    if (timeout > 0) {
      forceTimer = setTimeout(function () {
        hide(token);
      }, timeout);
    }

    return token;
  }

  function hide(token) {
    var overlay = document.getElementById(OVERLAY_ID);
    if (!overlay) return;

    if (token && overlay.dataset.iqsLoaderToken && String(token) !== overlay.dataset.iqsLoaderToken) {
      return;
    }

    clearTimeout(forceTimer);
    clearTimeout(hideTimer);
    clearTimeout(exitTimer);

    var closeToken = overlay.dataset.iqsLoaderToken || '';
    var elapsed = Date.now() - shownAt;
    var delay = Math.max(0, MIN_VISIBLE_MS - elapsed);

    hideTimer = setTimeout(function () {
      var activeOverlay = document.getElementById(OVERLAY_ID);
      if (!activeOverlay) return;

      if (closeToken && activeOverlay.dataset.iqsLoaderToken !== closeToken) {
        return;
      }

      activeOverlay.classList.add('is-hiding');
      activeOverlay.setAttribute('aria-busy', 'false');

      exitTimer = setTimeout(function () {
        var closingOverlay = document.getElementById(OVERLAY_ID);
        if (!closingOverlay) return;

        if (closeToken && closingOverlay.dataset.iqsLoaderToken !== closeToken) {
          return;
        }

        closingOverlay.remove();
      }, EXIT_MS);
    }, delay);
  }

  function update(message) {
    var overlay = ensureOverlay();
    overlay.classList.remove('is-hiding');
    if (!shownAt) {
      shownAt = Date.now();
    }
    setText(overlay, message);
  }

  window.IQSLoader = window.IQSLoader || {};
  window.IQSLoader.show = show;
  window.IQSLoader.hide = hide;
  window.IQSLoader.update = update;

  // Compatibility aliases for the View As loader introduced before this shared API.
  window.showImpersonationBoxLoader = function (message) {
    return show(message || defaultI18n.impersonationStop || defaultI18n.defaultMessage);
  };
  window.hideImpersonationBoxLoader = function () {
    hide();
  };
})(window, document);

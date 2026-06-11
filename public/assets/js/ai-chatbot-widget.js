(function () {
  'use strict';

  const cfg = window.IQS_AI_CHATBOT || {};
  const i18n = cfg.i18n || {};
  let openTracked = false;
  const launcher = document.querySelector('[data-ai-chatbot-launcher]');
  const panel = document.querySelector('[data-ai-chatbot-panel]');
  const closeBtn = document.querySelector('[data-ai-chatbot-close]');
  const form = document.querySelector('[data-ai-chatbot-form]');
  const input = document.querySelector('[data-ai-chatbot-input]');
  const messages = document.querySelector('[data-ai-chatbot-messages]');
  const status = document.querySelector('[data-ai-chatbot-status]');
  const sendBtn = document.querySelector('[data-ai-chatbot-send]');

  if (!launcher || !panel || !form || !input || !messages) {
    return;
  }

  function setOpen(open) {
    panel.classList.toggle('is-open', open);
    launcher.setAttribute('aria-expanded', open ? 'true' : 'false');
    if (open) {
      trackOpened();
      input.focus();
      scrollToBottom();
    }
  }

  function setBusy(busy) {
    input.disabled = busy;
    if (sendBtn) {
      sendBtn.disabled = busy;
    }
    if (status) {
      status.textContent = busy
        ? (i18n.busy || 'Sedang menjawab...')
        : (cfg.enabled ? (i18n.ready || 'Prototype aktif') : (i18n.disabled || 'Belum aktif'));
    }
  }

  function scrollToBottom() {
    messages.scrollTop = messages.scrollHeight;
  }

  function addMessage(role, text) {
    const item = document.createElement('div');
    item.className = 'ai-chatbot-message ai-chatbot-message--' + role;

    const bubble = document.createElement('div');
    bubble.className = 'ai-chatbot-message__bubble';
    bubble.textContent = text;

    item.appendChild(bubble);
    messages.appendChild(item);
    scrollToBottom();
  }

  async function sendMessage(text) {
    setBusy(true);
    try {
      const response = await fetch(cfg.endpoint, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-Token': cfg.csrf || '',
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ message: text })
      });

      const payload = await response.json().catch(function () { return null; });
      if (!response.ok || !payload || payload.success !== true) {
        throw new Error((payload && payload.message) || (i18n.genericError || 'AI Chatbot tidak dapat menjawab buat masa ini.'));
      }

      addMessage('assistant', payload.message || '');
    } catch (error) {
      addMessage('assistant', error && error.message ? error.message : (i18n.genericError || 'AI Chatbot tidak dapat menjawab buat masa ini.'));
    } finally {
      setBusy(false);
    }
  }

  function trackOpened() {
    if (openTracked || !cfg.eventEndpoint) {
      return;
    }
    openTracked = true;

    fetch(cfg.eventEndpoint, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-Token': cfg.csrf || '',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: JSON.stringify({ action: 'opened' })
    }).catch(function () {});
  }

  launcher.addEventListener('click', function () {
    setOpen(!panel.classList.contains('is-open'));
  });

  if (closeBtn) {
    closeBtn.addEventListener('click', function () {
      setOpen(false);
    });
  }

  input.addEventListener('keydown', function (event) {
    if (event.key === 'Enter' && !event.shiftKey) {
      event.preventDefault();
      form.requestSubmit();
    }
  });

  form.addEventListener('submit', function (event) {
    event.preventDefault();
    const text = input.value.trim();
    if (!text) {
      input.focus();
      return;
    }

    addMessage('user', text);
    input.value = '';
    void sendMessage(text);
  });

  if (cfg.welcomeMessage) {
    addMessage('assistant', cfg.welcomeMessage);
  }

  setBusy(false);
})();

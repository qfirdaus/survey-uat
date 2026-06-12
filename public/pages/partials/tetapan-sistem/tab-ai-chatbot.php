<?php
/**
 * IQS FRAMEWORK CORE FILE
 *
 * READ ONLY for downstream project programmers.
 * Do not modify this file directly in template or cloned projects.
 * Custom changes must be implemented in project-specific files
 * or approved extension points.
 */
declare(strict_types=1);

$ai = is_array($aiChatbotSettings ?? null) ? $aiChatbotSettings : [];
$aiValue = static fn(string $key, mixed $default = ''): string => htmlspecialchars((string)($ai[$key] ?? $default), ENT_QUOTES, 'UTF-8');
$aiRaw = static fn(string $key, mixed $default = ''): string => (string)($ai[$key] ?? $default);
$aiChecked = static fn(string $key, bool $default = false): string => !empty($ai[$key] ?? $default) ? 'checked' : '';
$aiSelected = static fn(string $key, string $value, string $default = ''): string => ((string)($ai[$key] ?? $default) === $value) ? 'selected' : '';
$apiKeyConfigured = !empty($ai['api_key_configured']);
$configSource = (string)($ai['config_source'] ?? 'defaults');
$aiEnabled = !empty($ai['enabled']);
$aiProvider = $aiRaw('provider', 'ollama');
$aiModel = $aiRaw('model', 'llama3.2:3b');
$aiAccessMode = $aiRaw('access_mode', 'super_admin_only');
$aiProviderDefaults = [
    'ollama' => ['base_url' => 'http://127.0.0.1:11434'],
    'openai' => ['base_url' => 'https://api.openai.com/v1'],
    'gemini' => ['base_url' => 'https://generativelanguage.googleapis.com'],
    'grok' => ['base_url' => 'https://api.x.ai/v1'],
    'anthropic' => ['base_url' => 'https://api.anthropic.com'],
    'openrouter' => ['base_url' => 'https://openrouter.ai/api/v1'],
    'openai_compatible' => ['base_url' => 'https://api.openai.com/v1'],
];
?>

<div class="tab-pane fade <?= ($_GET['tab'] ?? '') === 'ai-chatbot' ? 'show active' : '' ?>" id="ai-chatbot-tab" role="tabpanel">
  <form id="form-ai-chatbot" method="post" data-no-loader="1" novalidate onsubmit="return window.__tetapanAjaxSubmit(event, this, 'btn-simpan-ai-chatbot', 'ai-chatbot');">
    <input type="hidden" name="form_type" value="ai_chatbot_settings">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">

    <div class="card auth-settings-card">
      <div class="card-header auth-settings-header-primary">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
          <div class="d-flex align-items-center">
            <div class="auth-settings-icon bg-primary bg-opacity-10 text-primary me-3">
              <i class="ri-chat-3-line fs-5"></i>
            </div>
            <div>
              <h5 class="mb-1 fw-semibold text-primary"><?= __('config_ai_chatbot_title') ?? 'AI Chatbot' ?></h5>
              <small class="text-muted"><?= __('config_ai_chatbot_subtitle') ?? 'Runtime settings for the core framework AI Chatbot widget.' ?></small>
            </div>
          </div>
          <div class="d-flex flex-wrap gap-2">
            <span class="badge <?= $aiEnabled ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-secondary-subtle text-secondary border border-secondary-subtle' ?>">
              <?= $aiEnabled ? 'Enabled' : 'Disabled' ?>
            </span>
            <span class="badge bg-info-subtle text-info border border-info-subtle">
              Source: <?= htmlspecialchars($configSource, ENT_QUOTES, 'UTF-8') ?>
            </span>
          </div>
        </div>
      </div>

      <div class="card-body">
        <ul class="nav nav-pills auth-subtabs mb-3" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#ai-chatbot-subtab-overview" type="button" role="tab">
              <i class="ri-dashboard-line me-1"></i>Overview
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#ai-chatbot-subtab-provider" type="button" role="tab">
              <i class="ri-plug-line me-1"></i>Provider
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#ai-chatbot-subtab-limits" type="button" role="tab">
              <i class="ri-speed-up-line me-1"></i>Limits
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#ai-chatbot-subtab-character" type="button" role="tab">
              <i class="ri-user-smile-line me-1"></i>Character
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#ai-chatbot-subtab-storage" type="button" role="tab">
              <i class="ri-database-2-line me-1"></i>Storage
            </button>
          </li>
        </ul>

        <div class="tab-content">
          <div class="tab-pane fade show active auth-subtab-pane" id="ai-chatbot-subtab-overview" role="tabpanel">
            <div class="row g-3 align-items-stretch">
              <div class="col-xl-8">
                <div class="auth-summary-box auth-summary-box-main h-100">
                  <div class="text-uppercase small fw-semibold text-muted mb-1">Runtime Snapshot</div>
                  <div class="fw-semibold text-body-emphasis mb-2">AI Chatbot Core Settings</div>
                  <div class="row g-2">
                    <div class="col-md-6">
                      <div class="p-3 rounded border bg-light-subtle h-100">
                        <div class="text-muted small mb-1">Provider</div>
                        <div class="fw-semibold"><?= htmlspecialchars($aiProvider, ENT_QUOTES, 'UTF-8') ?></div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="p-3 rounded border bg-light-subtle h-100">
                        <div class="text-muted small mb-1">Model</div>
                        <div class="fw-semibold"><?= htmlspecialchars($aiModel, ENT_QUOTES, 'UTF-8') ?></div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="p-3 rounded border bg-light-subtle h-100">
                        <div class="text-muted small mb-1">Access mode</div>
                        <div class="fw-semibold"><?= htmlspecialchars($aiAccessMode, ENT_QUOTES, 'UTF-8') ?></div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="p-3 rounded border bg-light-subtle h-100">
                        <div class="text-muted small mb-1">API key</div>
                        <div class="fw-semibold"><?= $apiKeyConfigured ? 'Configured' : 'Not configured' ?></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-4">
                <div class="auth-summary-box h-100">
                  <div class="text-uppercase small fw-semibold text-muted mb-3">Activation</div>
                  <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" id="ai_chatbot_enabled" name="ai_chatbot_enabled" value="1" <?= $aiChecked('enabled') ?>>
                    <label class="form-check-label fw-semibold" for="ai_chatbot_enabled">Aktifkan AI Chatbot</label>
                  </div>
                  <div class="text-muted small mb-3">Jika off, widget dan endpoint tidak akan aktif.</div>
                  <label class="form-label fw-semibold" for="ai_chatbot_access_mode">Access mode</label>
                  <select class="form-select mb-2" id="ai_chatbot_access_mode" name="ai_chatbot_access_mode">
                    <option value="super_admin_only" <?= $aiSelected('access_mode', 'super_admin_only', 'super_admin_only') ?>>Super admin only</option>
                    <option value="selected_groups" <?= $aiSelected('access_mode', 'selected_groups') ?>>Selected groups</option>
                    <option value="all_authenticated" <?= $aiSelected('access_mode', 'all_authenticated') ?>>All authenticated users</option>
                  </select>
                  <label class="form-label fw-semibold" for="ai_chatbot_allowed_groups">Allowed groups</label>
                  <input type="text" class="form-control" id="ai_chatbot_allowed_groups" name="ai_chatbot_allowed_groups" value="<?= $aiValue('allowed_groups') ?>" placeholder="ADM-SA, ADM-STAF atau ID group">
                </div>
              </div>
            </div>
          </div>

          <div class="tab-pane fade auth-subtab-pane" id="ai-chatbot-subtab-provider" role="tabpanel">
            <div class="auth-summary-box">
              <div class="row g-3">
                <div class="col-md-4">
                  <label class="form-label fw-semibold" for="ai_chatbot_provider">Provider</label>
                  <select class="form-select" id="ai_chatbot_provider" name="ai_chatbot_provider">
                    <option value="ollama" <?= $aiSelected('provider', 'ollama', 'ollama') ?>>Ollama</option>
                    <option value="openai" <?= $aiSelected('provider', 'openai') ?>>OpenAI</option>
                    <option value="gemini" <?= $aiSelected('provider', 'gemini') ?>>Gemini</option>
                    <option value="grok" <?= $aiSelected('provider', 'grok') ?>>Grok</option>
                    <option value="anthropic" <?= $aiSelected('provider', 'anthropic') ?>>Anthropic</option>
                    <option value="openrouter" <?= $aiSelected('provider', 'openrouter') ?>>OpenRouter</option>
                    <option value="openai_compatible" <?= $aiSelected('provider', 'openai_compatible') ?>>OpenAI Compatible</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <label class="form-label fw-semibold" for="ai_chatbot_model">Model</label>
                  <select class="form-select ai-chatbot-model-select" id="ai_chatbot_model" name="ai_chatbot_model" data-current-model="<?= htmlspecialchars($aiModel, ENT_QUOTES, 'UTF-8') ?>" data-placeholder="Pilih model">
                    <option value="<?= htmlspecialchars($aiModel, ENT_QUOTES, 'UTF-8') ?>" selected><?= $aiModel !== '' ? htmlspecialchars($aiModel, ENT_QUOTES, 'UTF-8') : 'Fetch models from provider' ?></option>
                  </select>
                  <small class="text-muted" id="ai_chatbot_model_status">Model list akan difetch secara dynamic daripada provider yang dipilih.</small>
                </div>
                <div class="col-md-4">
                  <label class="form-label fw-semibold" for="ai_chatbot_base_url">Provider base URL</label>
                  <input type="url" class="form-control" id="ai_chatbot_base_url" name="ai_chatbot_base_url" value="<?= $aiValue('base_url', 'http://127.0.0.1:11434') ?>" placeholder="http://172.17.0.1:11436">
                </div>
                <div class="col-12">
                  <label class="form-label fw-semibold" for="ai_chatbot_api_key">API key</label>
                  <input type="password" class="form-control" id="ai_chatbot_api_key" name="ai_chatbot_api_key" value="" autocomplete="new-password" placeholder="<?= $apiKeyConfigured ? 'API key telah diset. Biarkan kosong untuk kekalkan nilai semasa.' : 'Masukkan API key jika provider memerlukan key.' ?>">
                  <small class="text-muted"><?= $apiKeyConfigured ? 'API key telah disimpan dalam tbl_m_config.' : 'Tiada API key disimpan dalam tbl_m_config.' ?></small>
                </div>
              </div>
            </div>
          </div>

          <div class="tab-pane fade auth-subtab-pane" id="ai-chatbot-subtab-limits" role="tabpanel">
            <div class="auth-summary-box">
              <div class="row g-3">
                <div class="col-md-3">
                  <label class="form-label fw-semibold" for="ai_chatbot_timeout_seconds">Timeout seconds</label>
                  <input type="number" min="1" max="120" class="form-control" id="ai_chatbot_timeout_seconds" name="ai_chatbot_timeout_seconds" value="<?= $aiValue('timeout_seconds', '30') ?>">
                </div>
                <div class="col-md-3">
                  <label class="form-label fw-semibold" for="ai_chatbot_max_input_chars">Max input chars</label>
                  <input type="number" min="100" max="20000" class="form-control" id="ai_chatbot_max_input_chars" name="ai_chatbot_max_input_chars" value="<?= $aiValue('max_input_chars', '2000') ?>">
                </div>
                <div class="col-md-3">
                  <label class="form-label fw-semibold" for="ai_chatbot_max_output_tokens">Max output tokens</label>
                  <input type="number" min="64" max="8192" class="form-control" id="ai_chatbot_max_output_tokens" name="ai_chatbot_max_output_tokens" value="<?= $aiValue('max_output_tokens', '800') ?>">
                </div>
                <div class="col-md-3">
                  <label class="form-label fw-semibold" for="ai_chatbot_rate_limit_per_minute">Rate/minute</label>
                  <input type="number" min="1" max="120" class="form-control" id="ai_chatbot_rate_limit_per_minute" name="ai_chatbot_rate_limit_per_minute" value="<?= $aiValue('rate_limit_per_minute', '10') ?>">
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold" for="ai_chatbot_user_daily_request_limit">User daily request limit</label>
                  <input type="number" min="0" max="10000" class="form-control" id="ai_chatbot_user_daily_request_limit" name="ai_chatbot_user_daily_request_limit" value="<?= $aiValue('user_daily_request_limit', '100') ?>">
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold" for="ai_chatbot_global_daily_request_limit">Global daily request limit</label>
                  <input type="number" min="0" max="100000" class="form-control" id="ai_chatbot_global_daily_request_limit" name="ai_chatbot_global_daily_request_limit" value="<?= $aiValue('global_daily_request_limit', '1000') ?>">
                </div>
              </div>
            </div>
          </div>

          <div class="tab-pane fade auth-subtab-pane" id="ai-chatbot-subtab-character" role="tabpanel">
            <div class="auth-summary-box">
              <div class="row g-3">
                <div class="col-md-4">
                  <label class="form-label fw-semibold" for="ai_chatbot_character_name">Character name</label>
                  <input type="text" class="form-control" id="ai_chatbot_character_name" name="ai_chatbot_character_name" value="<?= $aiValue('character_name', 'IQS Assistant') ?>">
                </div>
                <div class="col-md-8">
                  <label class="form-label fw-semibold" for="ai_chatbot_character_avatar">Avatar path</label>
                  <input type="text" class="form-control" id="ai_chatbot_character_avatar" name="ai_chatbot_character_avatar" value="<?= $aiValue('character_avatar', 'assets/images/ai/assistant.png') ?>">
                  <small class="text-muted">Contoh: <code>assets/images/ai/assistant.png</code></small>
                </div>
                <div class="col-12">
                  <label class="form-label fw-semibold" for="ai_chatbot_welcome_message">Welcome message</label>
                  <textarea class="form-control" id="ai_chatbot_welcome_message" name="ai_chatbot_welcome_message" rows="3"><?= $aiValue('welcome_message', 'Hai, saya boleh bantu tentang penggunaan sistem ini.') ?></textarea>
                </div>
              </div>
            </div>
          </div>

          <div class="tab-pane fade auth-subtab-pane" id="ai-chatbot-subtab-storage" role="tabpanel">
            <div class="auth-summary-box">
              <div class="row g-3">
                <div class="col-md-4">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="ai_chatbot_persist_usage" name="ai_chatbot_persist_usage" value="1" <?= $aiChecked('persist_usage', true) ?>>
                    <label class="form-check-label fw-semibold" for="ai_chatbot_persist_usage">Persist usage</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="ai_chatbot_store_conversations" name="ai_chatbot_store_conversations" value="1" <?= $aiChecked('store_conversations') ?>>
                    <label class="form-check-label fw-semibold" for="ai_chatbot_store_conversations">Store conversations</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="ai_chatbot_log_message_content" name="ai_chatbot_log_message_content" value="1" <?= $aiChecked('log_message_content') ?>>
                    <label class="form-check-label fw-semibold" for="ai_chatbot_log_message_content">Log message content</label>
                  </div>
                  <small class="text-danger">Aktifkan hanya untuk debugging terkawal.</small>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold" for="ai_chatbot_app_url">App URL</label>
                  <input type="url" class="form-control" id="ai_chatbot_app_url" name="ai_chatbot_app_url" value="<?= $aiValue('app_url', 'https://iqs-framework.dev') ?>">
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold" for="ai_chatbot_app_title">App title</label>
                  <input type="text" class="form-control" id="ai_chatbot_app_title" name="ai_chatbot_app_title" value="<?= $aiValue('app_title', 'IQS-Framework AI Chatbot') ?>">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="lang-settings-actions d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3">
          <div class="text-muted small">
            <i class="ri-database-2-line me-1"></i> Semua tetapan AI Chatbot disimpan dalam <code>tbl_m_config</code> group <code>ai_chatbot</code>.
          </div>
          <button type="submit" class="btn btn-primary px-4" id="btn-simpan-ai-chatbot">
            <i class="ri-save-3-line me-2"></i> Simpan Tetapan AI Chatbot
          </button>
        </div>
      </div>
    </div>
  </form>
</div>

<script>
(function () {
  var providerDefaults = <?= json_encode($aiProviderDefaults, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
  var providerEl = document.getElementById('ai_chatbot_provider');
  var modelEl = document.getElementById('ai_chatbot_model');
  var baseUrlEl = document.getElementById('ai_chatbot_base_url');
  var apiKeyEl = document.getElementById('ai_chatbot_api_key');
  var statusEl = document.getElementById('ai_chatbot_model_status');
  var modelEndpoint = <?= json_encode(base_url('ajax/ai-chatbot-models.php'), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
  var csrfToken = (window.tetapanSistemConfig && window.tetapanSistemConfig.csrfToken) || window.csrfToken || <?= json_encode($csrfToken, JSON_UNESCAPED_UNICODE) ?>;
  var lastRequestId = 0;
  if (!providerEl || !modelEl || !baseUrlEl) return;

  function initModelSelect2() {
    if (!(window.jQuery && jQuery.fn && typeof jQuery.fn.select2 === 'function')) {
      return false;
    }

    var $model = jQuery(modelEl);
    if ($model.data('select2')) {
      return true;
    }

    $model.select2({
      width: '100%',
      placeholder: modelEl.getAttribute('data-placeholder') || 'Pilih model',
      dropdownParent: jQuery(document.body),
      dropdownCssClass: 'ai-chatbot-model-dropdown',
      minimumResultsForSearch: 0
    });
    return true;
  }

  window.__initAiChatbotModelSelect2 = initModelSelect2;

  function scheduleModelSelect2Init() {
    var attempts = 0;
    var timer = window.setInterval(function () {
      attempts += 1;
      if (initModelSelect2() || attempts >= 40) {
        window.clearInterval(timer);
      }
    }, 100);
  }

  function refreshModelSelect() {
    if (initModelSelect2() && window.jQuery) {
      jQuery(modelEl).trigger('change.select2');
    }
  }

  function setModelDisabled(disabled) {
    modelEl.disabled = !!disabled;
    if (window.jQuery) {
      jQuery(modelEl).prop('disabled', !!disabled).trigger('change.select2');
    }
  }

  function setStatus(message, tone) {
    if (!statusEl) return;
    statusEl.textContent = message || '';
    statusEl.classList.remove('text-muted', 'text-danger', 'text-success');
    statusEl.classList.add(tone === 'danger' ? 'text-danger' : (tone === 'success' ? 'text-success' : 'text-muted'));
  }

  function ensureOption(value, label) {
    value = String(value || '').trim();
    if (value === '') return;
    for (var i = 0; i < modelEl.options.length; i += 1) {
      if (modelEl.options[i].value === value) return;
    }
    var option = document.createElement('option');
    option.value = value;
    option.textContent = label || value;
    modelEl.insertBefore(option, modelEl.firstChild);
  }

  function rebuildModelOptions(models, preferredModel) {
    var normalizedPreferred = String(preferredModel || '').trim();
    var unique = [];
    (Array.isArray(models) ? models : []).forEach(function (model) {
      model = String(model || '').trim();
      if (model !== '' && unique.indexOf(model) === -1) unique.push(model);
    });

    modelEl.innerHTML = '';

    if (normalizedPreferred !== '' && unique.indexOf(normalizedPreferred) === -1) {
      ensureOption(normalizedPreferred, 'Saved: ' + normalizedPreferred);
    }

    unique.forEach(function (model) {
      var option = document.createElement('option');
      option.value = model;
      option.textContent = model;
      modelEl.appendChild(option);
    });

    if (normalizedPreferred !== '') {
      ensureOption(normalizedPreferred, 'Saved: ' + normalizedPreferred);
      modelEl.value = normalizedPreferred;
    } else if (unique.length > 0) {
      modelEl.value = unique[0];
    } else {
      var emptyOption = document.createElement('option');
      emptyOption.value = '';
      emptyOption.textContent = 'No models loaded';
      modelEl.appendChild(emptyOption);
    }

    refreshModelSelect();
  }

  function fetchModels(preferredModel) {
    var requestId = ++lastRequestId;
    var provider = providerEl.value;
    var currentModel = String(preferredModel || modelEl.value || modelEl.getAttribute('data-current-model') || '').trim();
    var payload = {
      provider: provider,
      base_url: baseUrlEl.value || '',
      api_key: apiKeyEl ? apiKeyEl.value : ''
    };

    setModelDisabled(true);
    setStatus('Fetching model list from provider...', 'muted');

    return fetch(modelEndpoint, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-Token': csrfToken,
        'X-Requested-With': 'XMLHttpRequest',
        'X-No-Loader': '1'
      },
      credentials: 'same-origin',
      body: JSON.stringify(payload),
      noLoader: true
    })
      .then(function (response) {
        return response.text().then(function (text) {
          var json = null;
          try {
            json = text ? JSON.parse(text) : null;
          } catch (ignore) {}

          if (!response.ok || !json || json.success !== true) {
            throw new Error((json && json.message) || ('Gagal fetch model list. HTTP ' + response.status));
          }
          return json;
        });
      })
      .then(function (json) {
        if (requestId !== lastRequestId) return;
        rebuildModelOptions(json.models || [], currentModel);
        setStatus((json.models || []).length + ' model loaded from provider.', 'success');
      })
      .catch(function (error) {
        if (requestId !== lastRequestId) return;
        rebuildModelOptions([], currentModel);
        setStatus(error && error.message ? error.message : 'Gagal fetch model list.', 'danger');
      })
      .finally(function () {
        if (requestId === lastRequestId) {
          setModelDisabled(false);
        }
      });
  }

  function applyProviderDefaultBaseUrl() {
    var defaults = providerDefaults[providerEl.value] || null;
    if (!defaults || !defaults.base_url) return;

    var knownBaseUrls = Object.keys(providerDefaults).map(function (key) {
      return String((providerDefaults[key] && providerDefaults[key].base_url) || '');
    }).filter(Boolean);

    if (String(baseUrlEl.value || '').trim() === '' || knownBaseUrls.indexOf(String(baseUrlEl.value || '').trim()) !== -1) {
      baseUrlEl.value = defaults.base_url;
    }
  }

  providerEl.addEventListener('change', function () {
    applyProviderDefaultBaseUrl();
    fetchModels('');
  });

  baseUrlEl.addEventListener('change', function () {
    fetchModels(modelEl.value);
  });

  if (apiKeyEl) {
    apiKeyEl.addEventListener('change', function () {
      fetchModels(modelEl.value);
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', scheduleModelSelect2Init);
  } else {
    scheduleModelSelect2Init();
  }
  window.addEventListener('load', scheduleModelSelect2Init);
  document.addEventListener('shown.bs.tab', function (event) {
    var target = event && event.target ? event.target.getAttribute('data-bs-target') : '';
    if (target === '#ai-chatbot-tab' || target === '#ai-chatbot-subtab-provider') {
      scheduleModelSelect2Init();
      refreshModelSelect();
    }
  });

  fetchModels(modelEl.value);
})();
</script>

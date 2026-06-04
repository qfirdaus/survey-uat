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

require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/User.php';
require_once __DIR__ . '/../classes/SystemTemplate.php';
require_once __DIR__ . '/../classes/TemplateRegistryService.php';
require_once __DIR__ . '/../classes/TemplateResolverService.php';
require_once __DIR__ . '/../classes/FileGenerationService.php';
require_once __DIR__ . '/../classes/SystemTemplateCreationService.php';

final class SystemTemplateController
{
    public string $lang = 'ms';
    public array $profile = [];
    public array $records = [];
    public array $templates = [];
    public string $csrf = '';
    public array $form = [
        'template_name' => '',
        'page_name' => '',
        'page_title_ms' => '',
        'page_title_en' => '',
        'page_icon' => '',
        'template_key' => '',
        'access_mode' => FileGenerationService::ACCESS_MODE_GROUP_MENU,
    ];
    public array $fieldErrors = [];
    public ?array $previewResult = null;
    public ?array $generationResult = null;
    public ?string $errorMessage = null;
    public ?string $successMessage = null;

    protected PDO $pdoMysql;
    protected SystemTemplate $systemTemplateModel;
    protected TemplateRegistryService $registryService;
    protected TemplateResolverService $resolverService;
    protected FileGenerationService $fileGenerationService;
    protected SystemTemplateCreationService $creationService;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->lang = $_SESSION['lang'] ?? 'ms';
        $this->pdoMysql = Database::getInstance('mysql')->getConnection();
        $this->profile = $this->loadProfile();
        $this->applyUserTheme();
        $this->systemTemplateModel = new SystemTemplate($this->pdoMysql);
        $this->registryService = new TemplateRegistryService();
        $this->resolverService = new TemplateResolverService($this->registryService);
        $this->fileGenerationService = new FileGenerationService($this->resolverService);
        $this->creationService = new SystemTemplateCreationService(
            $this->pdoMysql,
            $this->systemTemplateModel,
            $this->fileGenerationService
        );

        $this->ensureCsrfToken();
        $this->loadTemplateOptions();
        $this->consumeFlashState();
        $this->handleRequest();
        $this->loadRecords();
    }

    protected function loadProfile(): array
    {
        $userModel = new User($this->pdoMysql);
        $fStafID = $_SESSION['f_stafID'] ?? null;

        return $fStafID ? ($userModel->getProfile((string)$fStafID) ?: []) : [];
    }

    protected function applyUserTheme(): void
    {
        $settingJson = $this->profile['f_themeSetting'] ?? '{}';
        $themeSetting = json_decode((string)$settingJson, true);
        if (!is_array($themeSetting)) {
            $themeSetting = [];
        }

        $_SESSION['theme.menu'] = $themeSetting['sidebarColor'] ?? ($_SESSION['theme.menu'] ?? 'light');
        $_SESSION['theme.topbar'] = $themeSetting['topbarColor'] ?? ($_SESSION['theme.topbar'] ?? 'light');
        $_SESSION['theme.layout'] = $themeSetting['layoutMode'] ?? ($_SESSION['theme.layout'] ?? 'light');
    }

    protected function ensureCsrfToken(): void
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
        }

        $this->csrf = (string)$_SESSION['csrf_token'];
    }

    protected function loadTemplateOptions(): void
    {
        $this->templates = $this->registryService->getAllTemplates();
    }

    protected function loadRecords(): void
    {
        try {
            $this->records = $this->systemTemplateModel->getAll();
        } catch (Throwable $e) {
            error_log('[SystemTemplateController] loadRecords failed: ' . $e->getMessage());
            $this->records = [];
        }
    }

    protected function handleRequest(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            return;
        }

        $this->form = [
            'template_name' => trim((string)($_POST['template_name'] ?? '')),
            'page_name' => trim((string)($_POST['page_name'] ?? '')),
            'page_title_ms' => trim((string)($_POST['page_title_ms'] ?? '')),
            'page_title_en' => trim((string)($_POST['page_title_en'] ?? '')),
            'page_icon' => trim((string)($_POST['page_icon'] ?? '')),
            'template_key' => trim((string)($_POST['template_key'] ?? '')),
            'access_mode' => trim((string)($_POST['access_mode'] ?? FileGenerationService::ACCESS_MODE_GROUP_MENU)),
        ];

        $csrf = trim((string)($_POST['csrf_token'] ?? ''));
        if ($csrf === '' || $this->csrf === '' || !hash_equals($this->csrf, $csrf)) {
            $this->errorMessage = (string)__('pageTemplateGenerator_error_csrf');
            return;
        }

        $action = trim((string)($_POST['generator_action'] ?? 'preview'));
        $this->fieldErrors = $this->validateForm($this->form);
        if ($this->fieldErrors !== []) {
            $this->errorMessage = (string)__('pageTemplateGenerator_validation_required');
            return;
        }

        $generationInput = [
            'page_name' => $this->form['page_name'],
            'page_title_ms' => $this->form['page_title_ms'],
            'page_title_en' => $this->form['page_title_en'],
            'page_icon' => $this->form['page_icon'],
            'access_mode' => $this->form['access_mode'],
        ];

        try {
            $this->previewResult = $this->fileGenerationService->preview($this->form['template_key'], $generationInput);

            if ($action !== 'generate') {
                return;
            }

            $this->generationResult = $this->creationService->create($this->form, [
                'update_by' => (string)($this->profile['f_stafID'] ?? ($_SESSION['f_stafID'] ?? '')),
            ]);
            $this->successMessage = (string)__('pageTemplateGenerator_success_generate');
            $this->flashSuccessAndRedirect();
        } catch (Throwable $e) {
            $this->errorMessage = $this->mapUserFacingError($e);
        }
    }

    protected function consumeFlashState(): void
    {
        $flash = $_SESSION['template_generator_flash'] ?? null;
        if (!is_array($flash)) {
            return;
        }

        unset($_SESSION['template_generator_flash']);

        $this->successMessage = isset($flash['success_message']) ? (string)$flash['success_message'] : null;
        $this->generationResult = isset($flash['generation_result']) && is_array($flash['generation_result'])
            ? $flash['generation_result']
            : null;
        $this->form = [
            'template_name' => '',
            'page_name' => '',
            'page_title_ms' => '',
            'page_title_en' => '',
            'page_icon' => '',
            'template_key' => '',
            'access_mode' => FileGenerationService::ACCESS_MODE_GROUP_MENU,
        ];
        $this->fieldErrors = [];
        $this->previewResult = null;
    }

    protected function flashSuccessAndRedirect(): void
    {
        $_SESSION['template_generator_flash'] = [
            'success_message' => $this->successMessage,
            'generation_result' => $this->generationResult,
        ];

        $redirectTo = (string)($_SERVER['REQUEST_URI'] ?? '');
        if ($redirectTo === '') {
            $redirectTo = 'template-generator.php';
        }

        header('Location: ' . $redirectTo);
        exit;
    }

    protected function getQueryString(string $key, string $default = ''): string
    {
        return trim((string)($_GET[$key] ?? $default));
    }

    protected function getQueryInt(string $key, int $default = 0): int
    {
        $value = $_GET[$key] ?? $default;
        return is_numeric($value) ? (int)$value : $default;
    }

    protected function isAjaxRequest(): bool
    {
        $requestedWith = strtolower(trim((string)($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '')));
        $accept = strtolower(trim((string)($_SERVER['HTTP_ACCEPT'] ?? '')));

        return $requestedWith === 'xmlhttprequest' || str_contains($accept, 'application/json');
    }

    protected function jsonSuccess(array $payload = [], int $status = 200): void
    {
        if (!headers_sent()) {
            http_response_code($status);
            header('Content-Type: application/json; charset=UTF-8');
        }

        echo json_encode(array_merge(['success' => true], $payload), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    protected function jsonError(string $message, int $status = 400, array $extra = []): void
    {
        if (!headers_sent()) {
            http_response_code($status);
            header('Content-Type: application/json; charset=UTF-8');
        }

        echo json_encode(array_merge([
            'success' => false,
            'message' => $message,
        ], $extra), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    public function setLang(string $lang): void
    {
        $this->lang = trim($lang) !== '' ? trim($lang) : 'ms';
        $_SESSION['lang'] = $this->lang;
    }

    /**
     * @param array<string,string> $form
     * @return array<string,string>
     */
    protected function validateForm(array $form): array
    {
        $errors = [];

        if (trim((string)($form['template_name'] ?? '')) === '') {
            $errors['template_name'] = (string)__('pageTemplateGenerator_required_field');
        }
        if (trim((string)($form['template_key'] ?? '')) === '') {
            $errors['template_key'] = (string)__('pageTemplateGenerator_required_field');
        }
        if (trim((string)($form['page_title_ms'] ?? '')) === '') {
            $errors['page_title_ms'] = (string)__('pageTemplateGenerator_required_field');
        }
        if (trim((string)($form['page_title_en'] ?? '')) === '') {
            $errors['page_title_en'] = (string)__('pageTemplateGenerator_required_field');
        }
        if (trim((string)($form['page_name'] ?? '')) === '') {
            $errors['page_name'] = (string)__('pageTemplateGenerator_required_field');
        }
        if (trim((string)($form['page_icon'] ?? '')) === '') {
            $errors['page_icon'] = (string)__('pageTemplateGenerator_required_field');
        }
        if (!in_array(trim((string)($form['access_mode'] ?? '')), [FileGenerationService::ACCESS_MODE_GROUP_MENU, FileGenerationService::ACCESS_MODE_SUPER_ADMIN_ONLY], true)) {
            $errors['access_mode'] = (string)__('pageTemplateGenerator_required_field');
        }

        return $errors;
    }

    protected function mapUserFacingError(Throwable $e): string
    {
        $message = trim($e->getMessage());
        $knownMessages = [
            'Template record already exists for this page slug.',
            'Template record already exists for this controller class.',
        ];

        if (in_array($message, $knownMessages, true)) {
            return $message;
        }

        error_log('[SystemTemplateController] create failed: ' . $e->getMessage());
        return (string)__('pageTemplateGenerator_error_create_failed');
    }
}

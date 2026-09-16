<?php

declare(strict_types=1);

namespace Modules\Languages\Controllers;

use App\Http\Controllers\Controller;
use App\Services\LocalizationService;
use Core\Http\RedirectResponse;
use Core\Http\Request;
use Core\Http\Response;
use Core\Http\Session;

class LanguageController extends Controller
{
    public function __construct(
        private readonly LocalizationService $localization,
        private readonly Session $session,
    ) {
    }

    public function index(): Response
    {
        return $this->view('languages::Admin.index', [
            'title' => trans('common.languages'),
            'languages' => $this->localization->languages(),
        ]);
    }

    public function store(Request $request): Response
    {
        $data = $request->validate([
            'code' => 'required|string|max:10|unique:languages,code',
            'name' => 'required|string|max:50',
            'native_name' => 'required|string|max:50',
            'dir' => 'required|in:ltr,rtl',
            'active' => 'required|in:0,1',
            'sort_order' => 'nullable|integer',
        ]);

        $this->localization->storeLanguage($data);

        return $this->redirect(route('admin.languages.index'))
            ->with('_success', trans('common.saved'));
    }

    public function toggle(int $id): Response
    {
        $this->localization->toggleLanguage($id);

        return $this->redirect(route('admin.languages.index'))
            ->with('_success', trans('common.saved'));
    }

    public function switchLocale(string $code): RedirectResponse
    {
        $this->session->set('_locale', $code);

        $referer = request()->header('HTTP_REFERER');

        return new RedirectResponse(is_string($referer) && $referer !== '' ? $referer : url('/'));
    }
}

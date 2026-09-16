<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Core\Http\RedirectResponse;
use Core\Http\Response;
use Core\Localization\Translator;

class HomeController extends Controller
{
    public function __construct(private readonly Translator $translator)
    {
    }

    public function root(): RedirectResponse
    {
        return new RedirectResponse(route('home'));
    }

    public function index(): Response
    {
        return $this->view('home', [
            'title' => trans('home.hero_title'),
            'supportedLocales' => $this->translator->supported(),
        ]);
    }
}

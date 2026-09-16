<?php

declare(strict_types=1);

namespace Modules\Media\Controllers;

use App\Http\Controllers\Controller;
use App\Services\MediaService;
use Core\Http\RedirectResponse;
use Core\Http\Request;
use Core\Http\Response;

class MediaController extends Controller
{
    public function __construct(private readonly MediaService $media)
    {
    }

    public function index(): Response
    {
        return $this->view('media::Admin.index', [
            'title' => trans('common.media_library'),
            'items' => $this->media->all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['file' => 'required|file']);

        /** @var array<string, mixed> $file */
        $file = $request->file('file');
        $this->media->storeFromUpload($file, (string) $request->input('collection', 'general'), auth()->id());

        return $this->redirect(route('admin.media.index'))
            ->with('_success', trans('common.uploaded'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->media->delete($id);

        return $this->redirect(route('admin.media.index'))
            ->with('_success', trans('common.deleted'));
    }
}

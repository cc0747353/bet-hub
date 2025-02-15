<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLanguageRequest;
use App\Http\Requests\UpdateLanguageRequest;
use App\Models\Language;
use App\Repositories\LanguageRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Laracasts\Flash\Flash;

class LanguageController extends AppBaseController
{

    /** @var LanguageRepository */
    private LanguageRepository $languageRepository;

    /**
     * @param LanguageRepository $languageRepo
     */
    public function __construct(LanguageRepository $languageRepo)
    {
        $this->languageRepository = $languageRepo;
    }

    public function index(): Application|Factory|View
    {
        return view('languages.index');
    }

    public function store(CreateLanguageRequest $request): JsonResponse
    {
        $input = $request->all();

        $language = $this->languageRepository->create($input);
        $translation = $this->languageRepository->translationFileCreate($language);
        Artisan::call('lang:js');

        return $this->sendResponse($language, __('messages.placeholder.language_save'));
    }

    public function edit(Language $language): JsonResponse
    {
        return $this->sendResponse($language, __('messages.flash.language_retrieved'));
    }

    public function show(Language $language): JsonResponse
    {
        return $this->sendResponse($language, __('messages.flash.language_retrieved'));
    }

    public function update(UpdateLanguageRequest $request, Language $language): JsonResponse
    {
        $input = $request->all();

        $this->languageRepository->updateLanguage($input, $language);

        return $this->sendSuccess(__('messages.flash.language_update'));
    }

    public function destroy(Language $language): JsonResponse
    {
        if ($language->is_default == true) {
            return $this->sendError(__('messages.flash.default_language_cant_delete'));
        }

        $path = lang_path().'/'.$language->iso_code;
        if (\File::exists($path)) {
            \File::deleteDirectory($path);
        }
        $language->delete();

        Artisan::call('lang:js');


        return $this->sendSuccess(__('messages.flash.language_deleted'));
    }

    public function showTranslation(Language $language, Request $request): View|Factory|RedirectResponse|Application
    {

        $selectedLang = $request->get('name', $language->iso_code);
        $selectedFile = $request->get('file', 'messages.php');
        $langExists = $this->languageRepository->checkLanguageExistOrNot($selectedLang);
        if (!$langExists) {
            return redirect()->back()->withErrors($selectedLang.__('messages.flash.language_not_found'));
        }

        $fileExists = $this->languageRepository->checkFileExistOrNot($selectedLang, $selectedFile);
        if (!$fileExists) {
            return redirect()->back()->withErrors($selectedFile.__('messages.flash.file_not_found'));
        }

        $oldLang = app()->getLocale();
        $data = $this->languageRepository->getSubDirectoryFiles($selectedLang, $selectedFile);
        $data['id'] = $language->id;
        app()->setLocale($oldLang);

        return view('languages.translation-manager.index', compact('selectedLang', 'selectedFile'))->with($data);
    }

    public function updateTranslation(Language $language, Request $request): RedirectResponse
    {
        $lName = $language->iso_code;
        $fileName = $request->get('file_name');
        $fileExists = $this->languageRepository->checkFileExistOrNot($lName, $fileName);

        if (!$fileExists) {
            return redirect()->back()->withErrors(__('messages.flash.file_not_found'));
        }

        if (!empty($lName)) {
            $result = $request->except(['_token', 'translate_language', 'file_name']);

            File::put(lang_path().'/'.$lName.'/'.$fileName, '<?php return '.var_export($result, true).'?>');
        }
        Artisan::call('lang:js');

        Flash::success(__('messages.flash.language_update'));

        return redirect()->route('languages.translation', $language->id);
    }

    public function getAllLanguage(): JsonResponse
    {
        $getAllLanguage = Language::get();
        $currentLanguage = getCurrentLanguageName();

        return $this->sendResponse(['getAllLanguage' => $getAllLanguage, 'currentLanguage' => $currentLanguage],
            __('messages.flash.language_retrieved'));
    }
}

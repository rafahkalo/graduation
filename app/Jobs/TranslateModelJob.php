<?php

namespace App\Jobs;

use App\Models\Language;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Throwable;

class TranslateModelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $model;

    protected $fields;

    protected $languages;

    public function __construct($model, $fields)
    {
        $this->model = $model;
        $this->fields = $fields;
        $this->languages = Language::pluck('code')->toArray();
    }

    public function handle()
    {
        Log::info('Languages to translate:', $this->languages);

        if (! $this->model) {
            Log::error('Model is not provided.');

            return;
        }

        $this->fields = array_filter($this->fields, function ($field) {
            return isset($this->model->{$field}) && ! empty($this->model->{$field});
        });

        if (empty($this->fields)) {
            Log::info('No fields to translate for model ID: '.$this->model->id);

            return;
        }

        $translator = new GoogleTranslate;
        $translations = [];

        foreach ($this->languages as $lang) {
            $translator->setTarget($lang);
            $translatedTexts = [];

            foreach ($this->fields as $field) {
                $cacheKey = "translation:{$field}:{$lang}:{$this->model->{$field}}";
                $cachedTranslation = Cache::get($cacheKey);

                if (is_null($cachedTranslation)) {
                    try {
                        $translation = $translator->translate($this->model->{$field});
                        Cache::put($cacheKey, $translation, now()->addDays(7));
                    } catch (\Exception $e) {
                        Log::error("Translation failed for lang: {$lang}, error: {$e->getMessage()}");
                        $translation = null;
                    }
                } else {
                    $translation = $cachedTranslation;
                }

                $translatedTexts[] = $translation;
            }

            if (count($this->fields) === count($translatedTexts)) {
                $translations[$lang] = array_combine($this->fields, $translatedTexts);
            } else {
                Log::warning("Translation count mismatch for lang: {$lang}");
            }
        }

        try {
            $this->model->translation = $translations;
            $this->model->save();
        } catch (\Exception $e) {
            Log::error("Failed to update translations for model ID {$this->model->id}: {$e->getMessage()}");
        }
    }

    public function failed(Throwable $exception)
    {
        // يُنفَّذ هذا تلقائيًا عندما تنفد جميع المحاولات
        Log::error("TranslateModelJob failed permanently for model {$this->model->getTable()} ID {$this->model->id}. Exception: {$exception->getMessage()}");
        // إذا أردت، ترسل تنبيه أو بريد هنا
    }
}

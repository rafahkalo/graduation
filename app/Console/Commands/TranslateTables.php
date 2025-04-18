<?php

namespace App\Console\Commands;

use App\Jobs\TranslateModelJob;
use App\Models\Direction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TranslateTables extends Command
{
    protected $signature = 'app:translate-tables';

    protected $description = 'Translate records in tables that have no translation';

    public function handle()
    {
        $this->dispatchTranslation(Direction::class);
        $this->info('All untranslated records have been dispatched for translation.');

        return Command::SUCCESS;
    }

    private function dispatchTranslation($modelClass)
    {
        $modelName = class_basename($modelClass);

        $modelClass::where('translation', 'LIKE', '[]')
        // $modelClass::where('translation', '=', null)
            ->chunk(100, function ($records) use ($modelName) {
                foreach ($records as $record) {
                    if (! isset($record::$translatable)) {
                        Log::warning("Skipping {$modelName} ID {$record->id} - no translatable fields defined.");

                        continue;
                    }

                    Log::info("Dispatching TranslateModelJob for {$modelName} ID: {$record->id}");
                    TranslateModelJob::dispatch($record, $record::$translatable);
                }
            });
    }
}

<?php

namespace Anam\SmsVerification\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Finder\SplFileInfo;

class ControllersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms-verification:controllers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold the sms verification controllers';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (!is_dir($directory = app_path('Http/Controllers/Auth'))) {
            mkdir($directory, 0755, true);
        }

        $filesystem = new Filesystem;

        collect($filesystem->allFiles(__DIR__ . '/../../stubs/Auth'))
            ->each(function (SplFileInfo $file) use ($filesystem) {
                if (!$filesystem->exists($filepath = app_path('Http/Controllers/Auth/' . Str::replaceLast('.stub', '.php', $file->getFilename())))) {
                    $filesystem->copy($file->getPathname(), $filepath);
                }
            });

        $this->info('SMS verification scaffolding generated successfully.');
    }
}

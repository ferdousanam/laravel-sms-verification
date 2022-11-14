<?php

namespace Anam\SmsVerification\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Finder\SplFileInfo;

class ChannelsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms-verification:channels';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold the sms verification channels';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (!is_dir($directory = app_path('Notifications'))) {
            mkdir($directory, 0755, true);
        }

        $filesystem = new Filesystem;

        collect($filesystem->allFiles(__DIR__ . '/../../stubs/Notifications'))
            ->each(function (SplFileInfo $file) use ($filesystem) {
                if (!$filesystem->exists($filepath = app_path('Notifications/' . Str::replaceLast('.stub', '.php', $file->getFilename())))) {
                    $filesystem->copy($file->getPathname(), $filepath);
                }
            });

        $this->info('SMS verification channel scaffolding generated successfully.');
    }
}

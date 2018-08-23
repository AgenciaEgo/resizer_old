<?php

namespace AgenciaEgo\Resizer\Commands;

use Illuminate\Console\Command;

class ClearResizerCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resizer:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear resizer cache folders';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $leave_files = array('.gitkeep');

        foreach (glob("storage/img_cache/*") as $file) {
            if (!in_array(basename($file), $leave_files)) {
                unlink($file);
                $this->line("Deleted {$file}");
            }
        }

        foreach (glob("public/img_cache/*") as $file) {
            if (!in_array(basename($file), $leave_files)) {
                unlink($file);
                $this->line("Deleted {$file}");
            }
        }

        $this->info('Resizer cache folders cleared!');
    }
}

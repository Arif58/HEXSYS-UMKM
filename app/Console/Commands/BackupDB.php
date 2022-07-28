<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class BackupDB extends Command
{
    protected $signature = 'db:backup';

    protected $description = 'Backup the database';

    protected $process;

    public function __construct()
    {
        parent::__construct();

        $this->process = new Process(sprintf(
            'pg_dump -U %s --data-only --exclude-table=public.migrations --column-inserts > "%s"',
            config('database.connections.pgsql.username'),
            // config('database.connections.pgsql.password'),
            // config('database.connections.pgsql.port'),
            // config('database.connections.pgsql.database'),
            storage_path("backups/backup.sql")
        ));
    }

    public function handle()
    {
        try {
            $this->process->mustRun();

            $this->info('The backup has been proceed successfully.');
        } catch (ProcessFailedException $exception) {
            $this->error($exception);
        }
    }
}
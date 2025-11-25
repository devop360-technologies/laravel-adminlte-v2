<?php

namespace Devop360Technologies\LaravelAdminLte\Console;

use Illuminate\Console\Command;

class AdminLteInstallCommand extends Command
{
    protected $signature = 'adminlte:install';

    protected $description = 'Install AdminLTE with authentication scaffolding and all required files';

    protected $authViews = [
        'auth/login.blade.php'           => '@extends(\'adminlte::login\')',
        'auth/register.blade.php'        => '@extends(\'adminlte::register\')',
        'auth/passwords/email.blade.php' => '@extends(\'adminlte::passwords.email\')',
        'auth/passwords/reset.blade.php' => '@extends(\'adminlte::passwords.reset\')',
    ];

    protected $basicViews = [
        'home.stub' => 'home.blade.php',
    ];

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Installing AdminLTE...');

        $this->exportAssets();
        $this->generateUiAuth();
        $this->removeConflictingViews();
        $this->exportAuthViews();
        $this->exportBasicViews();
        $this->exportRoutes();
        $this->exportConfig();

        $this->info('AdminLTE Installation completed successfully!');
    }

    /**
     * Generate Laravel UI authentication scaffolding.
     *
     * @return void
     */
    protected function generateUiAuth()
    {
        $this->call('ui', [
            'type' => 'bootstrap',
            '--auth' => true,
        ]);

        $this->comment('Laravel UI authentication scaffolding generated successfully.');
    }

    /**
     * Remove conflicting views created by Laravel UI.
     *
     * @return void
     */
    protected function removeConflictingViews()
    {
        $conflictingViews = [
            $this->getViewPath('layouts/app.blade.php'),
        ];

        foreach ($conflictingViews as $view) {
            if (file_exists($view)) {
                unlink($view);
            }
        }

        $this->comment('Conflicting Laravel UI views removed successfully.');
    }

    /**
     * Export the authentication views.
     *
     * @return void
     */
    protected function exportAuthViews()
    {
        $this->ensureDirectoriesExist($this->getViewPath('auth/passwords'));
        foreach ($this->authViews as $file => $content) {
            file_put_contents($this->getViewPath($file), $content);
        }
        $this->comment('Authentication views installed successfully.');
    }

    /**
     * Export the basic views.
     *
     * @return void
     */
    protected function exportBasicViews()
    {
        foreach ($this->basicViews as $key => $value) {
            copy(
                __DIR__.'/stubs/'.$key,
                $this->getViewPath($value)
            );
        }
        $this->comment('Basic views installed successfully.');
    }

    /**
     * Export the authentication routes.
     *
     * @return void
     */
    protected function exportRoutes()
    {
        file_put_contents(
            base_path('routes/web.php'),
            file_get_contents(__DIR__.'/stubs/routes.stub'),
            FILE_APPEND
        );
        $this->comment('Authentication routes installed successfully.');
    }

    /**
     * Copy all the content of the Assets Folder to Public Directory.
     */
    protected function exportAssets()
    {
        $this->directoryCopy(__DIR__.'/../../resources/assets/', public_path(), true);
        $this->comment('Assets Installation complete.');
    }

    /**
     * Install the config file.
     */
    protected function exportConfig()
    {
        copy(
            __DIR__.'/../../config/adminlte.php',
            config_path('adminlte.php')
        );

        $this->comment('Configuration Files Installation complete.');
    }

    /**
     * Check if the directories for the files exists.
     *
     * @param $directory
     * @return void
     */
    protected function ensureDirectoriesExist($directory)
    {
        // CHECK if directory exists, if not create it
        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
    }

    /**
     * Get full view path relative to the application's configured view path.
     *
     * @param  string  $path
     * @return string
     */
    protected function getViewPath($path)
    {
        return implode(DIRECTORY_SEPARATOR, [
            config('view.paths')[0] ?? resource_path('views'), $path,
        ]);
    }

    /**
     * Recursive function that copies an entire directory to a destination.
     *
     * @param $source_directory
     * @param $destination_directory
     */
    protected function directoryCopy($source_directory, $destination_directory, $recursive)
    {
        //Checks destination folder existance
        $this->ensureDirectoriesExist($destination_directory);
        //Open source directory
        $directory = opendir($source_directory);
        while (false !== ($file = readdir($directory))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($source_directory.'/'.$file) && $recursive) {
                    $this->directoryCopy($source_directory.'/'.$file, $destination_directory.'/'.$file, true);
                } else {
                    copy($source_directory.'/'.$file, $destination_directory.'/'.$file);
                }
            }
        }
        closedir($directory);
    }
}

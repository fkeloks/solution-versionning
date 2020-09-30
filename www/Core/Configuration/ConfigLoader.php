<?php

namespace ESGI\Core\Configuration;

class ConfigLoader
{
    /** @var string $basePath */
    private $basePath;

    /** @var string $text */
    private $text = '';

    public function __construct(string $basePath = __DIR__)
    {
        $this->basePath = $basePath;
        $this->getFileEnv();
    }

    /**
     * Parse configuration files from .env and from json files (in www/config folder)
     */
    public function parseFiles(): void
    {
        // Configuration from .env
        $lines = explode(PHP_EOL, str_replace(["\r\n", "\r", "\n"], PHP_EOL, $this->text));
        foreach ($lines as $line) {
            $line = explode('=', $line);

            $name = $line[0];
            $value = trim($line[1] ?? '');

            if (!Config::has($name)) {
                // Shell script protection (terminal)
                if (PHP_SAPI === 'cli' && $name === 'DB_HOST' && $value === 'database') {
                    $value = '127.0.0.1';
                }

                Config::set($name, $value !== '' ? $value : null);
            }
        }

        // Configuration from config directory
        $configFilesPath = $this->basePath . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . '*.json';
        $configFiles = glob($configFilesPath);
        if (is_array($configFiles)) {
            foreach ($configFiles as $configFile) {
                $file = file_get_contents($configFile);
                if (is_string($file)) {
                    $configuration = json_decode($file, true);
                    foreach ($configuration as $key => $value) {
                        Config::set($key, $value);
                    }
                }
            }
        }
    }

    /**
     * Parse and returns configuration file (.env)
     */
    private function getFileEnv(): void
    {
        $envPath = $this->basePath . DIRECTORY_SEPARATOR;

        if (!file_exists($envPath . '.env')) {
            if (file_exists($envPath . '.env.example')) {
                copy($envPath . '.env.example', $envPath . '.env');
            } else {
                die('Le fichier .env n\'existe pas.');
            }
        }

        $file = file_get_contents($this->basePath . DIRECTORY_SEPARATOR . '.env');
        if ($file) {
            $this->text = trim($file);
        }
    }
}

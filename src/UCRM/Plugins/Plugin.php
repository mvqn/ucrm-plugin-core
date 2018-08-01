<?php
declare(strict_types=1);

namespace UCRM\Plugins;


final class Plugin
{



    public function __construct(string $root_path)
    {
        $this->root_path = realpath($root_path);
    }



    private $root_path;




    public function executing(): bool
    {
        return file_exists(
            $this->root_path.
            DIRECTORY_SEPARATOR.
            ".ucrm-plugin-execution-requested"
        );
    }

    public function running(): bool
    {
        return file_exists(
            $this->root_path.
            DIRECTORY_SEPARATOR.
            ".ucrm-plugin-running"
        );
    }



    public function config(): ?array
    {
        $config_file =
            $this->root_path.
            DIRECTORY_SEPARATOR."data".
            DIRECTORY_SEPARATOR."config.json";

        if(!file_exists($config_file))
            return null;

        return json_decode(file_get_contents($config_file), true);
    }



    public function logs(int $tail = 0): ?array
    {
        $log_file =
            $this->root_path.
            DIRECTORY_SEPARATOR."data".
            DIRECTORY_SEPARATOR."plugin.log";

        if(!file_exists($log_file))
            return null;

        $lines = explode(PHP_EOL, file_get_contents($log_file));

        if($tail < 0)
            return null;

        if($tail === 0)
            return $lines;

        return array_slice($lines, -$tail, $tail);
    }

    public function log(string $message): void //array
    {
        $log_file =
            $this->root_path.
            DIRECTORY_SEPARATOR."data".
            DIRECTORY_SEPARATOR."plugin.log";

        if(!file_exists(dirname($log_file)))
            mkdir(dirname($log_file));

        file_put_contents(
            $log_file,
            sprintf(
                "[%s] %s %s",
                (new \DateTimeImmutable())->format("Y-m-d G:i:s.u"),
                $message,
                PHP_EOL
            ),
            FILE_APPEND | LOCK_EX
        );

        //return explode(PHP_EOL, file_get_contents($log_file));
    }


    public function manifest(): array
    {
        $manifest_file =
            $this->root_path.
            DIRECTORY_SEPARATOR."manifest.json";

        if(!file_exists($manifest_file))
            return null;

        return json_decode(file_get_contents($manifest_file), true);
    }



    public function manifestVersion(): string
    {
        $value = $this->manifest()["version"];
        return $value;
    }

    public function name(): string
    {
        $value = $this->manifest()["information"]["name"];
        return $value;
    }

    public function displayName(): string
    {
        $value = $this->manifest()["information"]["displayName"];
        return $value;
    }

    public function description(): string
    {
        $value = $this->manifest()["information"]["description"];
        return $value;
    }

    public function url(): string
    {
        $value = $this->manifest()["information"]["url"];
        return $value;
    }

    public function version(): string
    {
        $value = $this->manifest()["information"]["version"];
        return $value;
    }

    public function ucrmMinVersion(): string
    {
        $value = $this->manifest()["information"]["ucrmVersionCompliancy"]["min"];
        return $value;
    }

    public function ucrmMaxVersion(): string
    {
        $value = $this->manifest()["information"]["ucrmVersionCompliancy"]["max"];
        return $value;
    }

    public function author(): string
    {
        $value = $this->manifest()["information"]["author"];
        return $value;
    }

    public function manifestConfiguration(): ?array
    {
        $manifest = $this->manifest();
        $value = array_key_exists("configuration", $manifest) ? $manifest["configuration"] : null;
    }

    public function settings(): ?array
    {
        return $this->manifestConfiguration();
    }



    private function ucrmConfig(): ?array
    {
        $config_file =
            $this->root_path.
            DIRECTORY_SEPARATOR."ucrm.json";

        if(!file_exists($config_file))
            return null;

        return json_decode(file_get_contents($config_file), true);
    }

    public function ucrmUrl(): string
    {
        $config = $this->ucrmConfig();
        return $config["ucrmPublicUrl"] ?: "";
    }

    public function pluginUrl(): string
    {
        $config = $this->ucrmConfig();
        return $config["pluginPublicUrl"] ?: "";
    }

    public function appKey(): string
    {
        $config = $this->ucrmConfig();
        return $config["pluginAppKey"] ?: "";
    }




}


<?php namespace Foostart\English\Trait;

trait WordResourceTrait {

    public $packageConfig = 'package-english';
    /**
     * Load configuration
     * @return ARRAY $configs list of configurations
     */
    public function loadConfigs()
    {

        $configs = config($this->packageConfig);
        return $configs;
    }
}
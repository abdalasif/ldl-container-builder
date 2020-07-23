<?php

namespace LDL\Service\Finder\Options;

class ServiceFileFinderOptions
{
    /**
     * @var array
     */
    private $directories = [];

    /**
     * @var array
     */
    private $files = [
        'services'
    ];

    private function __construct()
    {
    }

    public static function fromArray(array $options) : self
    {
        $instance = new static();
        $defaults = get_object_vars($instance);

        foreach($options as $opt=>$value){
            if(array_key_exists($opt, $defaults)) {
                continue;
            }
            $msg = sprintf(
                'Unknown option: "%s", valid options are: %s',
                $opt,
                implode(', ', array_keys($defaults))
            );

            throw new Exception\UnknownOptionException($msg);
        }

        $merge = array_merge($defaults, $options);

        return $instance->setDirectories($merge['directories'])
            ->setFiles($merge['files']);
    }

    /**
     * @return array
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    /**
     * @param array $files
     * @return ServiceFileFinderOptions
     * @throws Exception\InvalidOptionException
     */
    private function setFiles(array $files): ServiceFileFinderOptions
    {
        if(0 === count($files)){
            throw new Exception\InvalidOptionException('No files to find were given');
        }

        $this->files = $files;
        return $this;
    }

    /**
     * @return array
     */
    public function getDirectories(): array
    {
        return $this->directories;
    }

    /**
     * @param array $directories
     * @return ServiceFileFinderOptions
     */
    private function setDirectories(array $directories): ServiceFileFinderOptions
    {
        if(0 === count($directories)){
            $directories[] = \getcwd();
        }

        $this->directories = $directories;
        return $this;
    }
}
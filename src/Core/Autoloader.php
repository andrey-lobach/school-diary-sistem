<?php
/**
 * Created by PhpStorm.
 * UserModel: andrei
 * Date: 14.11.18
 * Time: 17.09
 */

namespace Core;


class Autoloader
{
    /**
     * @param array $dirs
     */
    private $dirs;

    public function __construct(array $dirs)
    {
        $this->dirs = $dirs;
    }

    public function load(string $class)
    {
        $subPath = str_replace('\\', DIRECTORY_SEPARATOR, $class);
        foreach ($this->dirs as $dir){
            $path = sprintf('%s/%s.php', $dir,$subPath);
            if (file_exists($path)) {
                require_once $path;
                break;
            }
        }
    }
}
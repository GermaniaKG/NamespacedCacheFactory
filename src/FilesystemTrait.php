<?php
namespace Germania\NamespacedCache;

trait FilesystemTrait
{

    /**
     * @var string
     */
    public $path;



    /**
     * Returns default cache pool path
     *
     * @return string
     */
    public function getPath() : string
    {
        return $this->path;
    }


    /**
     * Sets default cache pool path.
     *
     * @param string $directory
     */
    public function setPath( string $path)
    {
        $this->path = $path;
        return $this;
    }
}

<?php
namespace Germania\NamespacedCache;

class StashSqliteCacheItemPoolFactory extends StashCacheItemPoolFactory implements PsrCacheItemPoolFactoryInterface {

    use FilesystemTrait;


    /**
     * @param ?string  $directory Main cache directory, defaults to current work dir.
     */
    public function __construct( string $directory = null)
    {
        $this->setPath($directory ?: getcwd());
    }




    /**
     * @inheritDoc
     */
    protected function createCacheDriver() : \Stash\Driver\AbstractDriver
    {
        $directory = $this->getPath();
        $driver = new \Stash\Driver\Sqlite([
            'path' => $directory
        ]);
        return $driver;
    }
}

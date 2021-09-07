<?php
namespace Germania\NamespacedCache;

class StashSqliteCacheItemPoolFactory extends StashCacheItemPoolFactory {

    use FilesystemTrait;


    /**
     * @param ?string  $directory Main cache directory, defaults to current work dir.
     */
    public function __construct( string $directory = null)
    {
        $directory = $directory ?: getcwd();
        if (!is_dir($directory)) {
            $msg = sprintf("Stash Cache requires a directory path to store the sqlite file, instead got this: '%s'", $directory);
            throw new \UnexpectedValueException($msg);
        }

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

<?php
namespace App\AssetVersionStrategy;
use Symfony\Component\Asset\VersionStrategy\VersionStrategyInterface;

class DateVersionStrategy implements VersionStrategyInterface
{
    private $version;

    public function __construct()
    {
        $this->version = date('Ymd');
    }
    

    /**
     * Get the value of version
     *
     * @return void
     */
    public function getVersion($path)
    {
        return $this->version;
    }

    /**
     * Apply Version
     *
     * @return string
     */
    public function applyVersion($path)
    {
        return sprintf('%s?vdate=%s', $path, $this->getVersion($path));
    }
}
<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use App\AssetVersionStrategy\DateVersionStrategy;

final class DateVersionStrategyTest extends TestCase
{
    /**
     * Test GetVersion
     *
     * @return void
     */
    public function testGetVersion(): void
    {
        $path = 'test';
        $date = date('Ymd');

        $this->assertSame($date, (new DateVersionStrategy($path))->getVersion($path));
    }

    /**
     * Test ApplyVersion
     *
     * @return void
     */
    public function testApplyVersion(): void
    {
        $path = 'test';
        $date = date('Ymd');
        $pathVersion = "$path?vdate=$date";

        $this->assertSame($date, (new DateVersionStrategy())->getVersion($path));
    }
}
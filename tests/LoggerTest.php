<?php
namespace Idearia\Tests;

use Idearia\Logger;
use PHPUnit\Framework\TestCase;

class LoggerTest extends TestCase
{
    protected function setUp(): void
    {
        Logger::$print_log = false;
    }

    protected function tearDown(): void
    {
        Logger::clear_log();
    }

    public function testDebug()
    {
        Logger::$log_level = 'debug';
        $msg = "variable x is false";
        Logger::debug( $msg );
        $result = Logger::dump_to_string();

        $this->assertStringContainsString( $msg, $result );
        $this->assertStringContainsStringIgnoringCase( 'debug', $result );
    }

    public function testInfo()
    {
        Logger::$log_level = 'info';
        $msg = "variable x is false";
        Logger::info( $msg );
        $result = Logger::dump_to_string();

        $this->assertStringContainsString( $msg, $result );
        $this->assertStringContainsStringIgnoringCase( 'info', $result );
    }

    public function testWarning()
    {
        Logger::$log_level = 'warning';
        $msg = "variable x is false";
        Logger::warning( $msg );
        $result = Logger::dump_to_string();

        $this->assertStringContainsString( $msg, $result );
        $this->assertStringContainsStringIgnoringCase( 'warning', $result );
    }

    public function testError()
    {
        Logger::$log_level = 'error';
        $msg = "variable x is false";
        Logger::error( $msg );
        $result = Logger::dump_to_string();

        $this->assertStringContainsString( $msg, $result );
        $this->assertStringContainsStringIgnoringCase( 'error', $result );
    }

    public function testLogLevelTooLow()
    {
        Logger::$log_level = 'info';
        $msg = "variable x is false";
        Logger::debug( $msg );
        $result = Logger::dump_to_string();

        $this->assertSame( '', $result );
    }

    public function testSingleTimer()
    {
        $seconds = 0.5;

        $microSeconds = $seconds * 1e6;
        Logger::$log_level = 'debug';
        Logger::time( 'Testing the timing' );
        usleep($microSeconds);
        $result = Logger::timeEnd( 'Testing the timing', 6, 'debug' );
        
        $this->assertEqualsWithDelta($seconds, $result, 0.01);
    }
 
    public function testMultipleTimers()
    {
        $seconds = 1;

        Logger::$log_level = 'debug';
        Logger::time('outer timer');
        sleep($seconds);
        Logger::time('inner timer');
        sleep($seconds);
        $result_2 = Logger::timeEnd('inner timer', 6, 'debug' );
        $result_1 = Logger::timeEnd('outer timer', 6, 'debug' );
        
        $this->assertEqualsWithDelta(2*$seconds, $result_1, 0.01);
        $this->assertEqualsWithDelta($seconds, $result_2, 0.01);
    }

    public function testTimingWithDefaultParameters()
    {
        $seconds = 1;

        $microSeconds = $seconds * 1e6;
        Logger::$log_level = 'debug';
        Logger::time();
        usleep($microSeconds);
        $result = Logger::timeEnd();

        $this->assertEqualsWithDelta($seconds, $result, 0.01);
    }
}
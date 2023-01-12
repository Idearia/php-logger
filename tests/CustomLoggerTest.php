<?php
/**
 * Same tests as in LoggerTest, but subclassing the logger
 * instead of setting the static properties at run time.
 */

namespace Idearia\Tests;

use Idearia\Logger;
use PHPUnit\Framework\TestCase;

class DebugLevelLogger extends Logger
{
    public static $log_level = 'debug';
    public static $print_log = false;
}

class InfoLevelLogger extends Logger
{
    public static $log_level = 'info';
    public static $print_log = false;
}

class WarningLevelLogger extends Logger
{
    public static $log_level = 'warning';
    public static $print_log = false;
}

class ErrorLevelLogger extends Logger
{
    public static $log_level = 'error';
    public static $print_log = false;
}

class CustomLoggerTest extends TestCase
{
    public function testDebug()
    {
        DebugLevelLogger::clear_log();
        $msg = "variable x is false";
        DebugLevelLogger::debug( $msg );
        $result = DebugLevelLogger::dump_to_string();

        $this->assertStringContainsString( $msg, $result );
        $this->assertStringContainsStringIgnoringCase( 'debug', $result );
    }

    public function testInfo()
    {
        InfoLevelLogger::clear_log();
        $msg = "variable x is false";
        InfoLevelLogger::info( $msg );
        $result = InfoLevelLogger::dump_to_string();

        $this->assertStringContainsString( $msg, $result );
        $this->assertStringContainsStringIgnoringCase( 'info', $result );
    }

    public function testWarning()
    {
        WarningLevelLogger::clear_log();
        $msg = "variable x is false";
        WarningLevelLogger::warning( $msg );
        $result = WarningLevelLogger::dump_to_string();

        $this->assertStringContainsString( $msg, $result );
        $this->assertStringContainsStringIgnoringCase( 'warning', $result );
    }

    public function testError()
    {
        ErrorLevelLogger::clear_log();
        $msg = "variable x is false";
        ErrorLevelLogger::error( $msg );
        $result = ErrorLevelLogger::dump_to_string();

        $this->assertStringContainsString( $msg, $result );
        $this->assertStringContainsStringIgnoringCase( 'error', $result );
    }

    public function testLogLevelTooLow()
    {
        InfoLevelLogger::clear_log();
        $msg = "variable x is false";
        InfoLevelLogger::debug( $msg );
        $result = InfoLevelLogger::dump_to_string();

        $this->assertSame( '', $result );
    }

    public function testSingleTimer()
    {
        $seconds = 0.5;

        $microSeconds = $seconds * 1e6;
        DebugLevelLogger::clear_log();
        DebugLevelLogger::time( 'Testing the timing' );
        usleep($microSeconds);
        $result = DebugLevelLogger::timeEnd( 'Testing the timing', 6, 'debug' );
        
        $this->assertEqualsWithDelta($seconds, $result, 0.01);
    }
 
    public function testMultipleTimers()
    {
        $seconds = 1;

        DebugLevelLogger::clear_log();
        DebugLevelLogger::time('outer timer');
        sleep($seconds);
        DebugLevelLogger::time('inner timer');
        sleep($seconds);
        $result_2 = DebugLevelLogger::timeEnd('inner timer', 6, 'debug' );
        $result_1 = DebugLevelLogger::timeEnd('outer timer', 6, 'debug' );

        $this->assertEqualsWithDelta(2*$seconds, $result_1, 0.01);
        $this->assertEqualsWithDelta($seconds, $result_2, 0.01);
    }

    public function testTimingWithDefaultParameters()
    {
        $seconds = 1;

        $microSeconds = $seconds * 1e6;
        DebugLevelLogger::clear_log();
        DebugLevelLogger::time();
        usleep($microSeconds);
        $result = DebugLevelLogger::timeEnd();

        $this->assertEqualsWithDelta($seconds, $result, 0.01);
    }
}
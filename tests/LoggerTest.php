<?php
namespace Idearia\Tests;

use Idearia\Logger;
use PHPUnit\Framework\TestCase;

class LoggerTest extends TestCase
{
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
}
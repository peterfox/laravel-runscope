<?php

namespace Runscope\GuzzleHttp\Plugin;

use GuzzleHttp\Adapter\Transaction;
use GuzzleHttp\Client;
use GuzzleHttp\Event\BeforeEvent;
use GuzzleHttp\Message\Request;

use Runscope\Plugin\GuzzleHttp\RunscopePlugin;

/**
 * @covers Runscope\Plugin\RunscopePlugin
 */
class RunscopePluginTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_supports_on_before_send_event()
    {
        $plugin = new RunscopePlugin(new \Runscope\Runscope('bucketKeyHere'));
        $this->assertNotEmpty($plugin->getEvents());
        $event = new BeforeEvent($this->getTransaction());
        $plugin->onBefore($event);
    }

    private function getTransaction()
    {
        return new Transaction(new Client(), new Request('GET', 'https://api.github.com'));
    }
}
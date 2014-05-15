<?php

namespace Runscope\Guzzle\Plugin;

use Guzzle\Http\Message\Request;
use Guzzle\Common\Event;
use Guzzle\Tests\GuzzleTestCase;

use Runscope\Plugin\Guzzle\RunscopePlugin;

/**
 * @covers Runscope\Plugin\RunscopePlugin
 */
class RunscopePluginTest extends GuzzleTestCase
{
    /** @test */
    public function it_supports_on_before_send_event()
    {
        $plugin = new RunscopePlugin(new \Runscope\Runscope('bucketKeyHere'));
        $this->assertNotEmpty($plugin->getSubscribedEvents());
        $event = new Event(array('request' => new Request('GET', 'https://api.github.com')));
        $plugin->onBeforeSend($event);
    }
}
<?php

namespace Runscope\Plugin\Guzzle;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Guzzle\Common\Event;

use Runscope\Runscope;

/**
 * Plugin class that will transform all requests to go through Runscope.
 *
 * @author Runscope <help@runscope.com>, Peter Fox <peter.fox@peterfox.me>
 */
class RunscopePlugin implements EventSubscriberInterface
{

    private $runscope;

    public function __construct(Runscope $runscope)
    {
        $this->runscope = $runscope;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'request.before_send' => array('onBeforeSend', 255),
        );
    }

    /**
     * Event triggered right before sending a request
     *
     * @param Event $event
     */
    public function onBeforeSend(Event $event)
    {
        /** @var \Guzzle\Http\Message\Request $request */
        $request = $event['request'];

        list($newUrl, $port) = $this->runscope->proxify(
            $request->getUrl()
        );

        $request->setUrl($newUrl);

        if ($port) {
            $request->setHeader('Runscope-Request-Port', $port);
        }

        if ($this->runscope->getAuthToken()) {
            $request->setHeader('Runscope-Bucket-Auth', $this->runscope->getAuthToken());
        }
    }
}

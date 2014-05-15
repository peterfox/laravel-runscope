<?php

namespace Runscope\Plugin\GuzzleHttp;

use GuzzleHttp\Event\BeforeEvent;
use GuzzleHttp\Event\SubscriberInterface;

use Runscope\Runscope;

/**
 * Plugin class that will transform all requests to go through Runscope.
 *
 * @author Runscope <help@runscope.com>, Peter Fox <peter.fox@peterfox.me>
 */
class RunscopePlugin implements SubscriberInterface
{
    private $runscope;

    public function __construct(Runscope $runscope)
    {
        $this->runscope = $runscope;
    }

    public function getEvents()
    {
        return [
            'before' => ['onBefore']
        ];
    }

    /**
     * Event triggered right before sending a request that replaces the Url with one for the runscope bucket
     *
     * @param \GuzzleHttp\Event\BeforeEvent $event
     */
    public function onBefore(BeforeEvent $event)
    {

        $request = $event->getRequest();

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

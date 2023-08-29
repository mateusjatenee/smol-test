<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Event;

class Bus
{
    protected static array $events = [];

    protected static array $listeners = [];

    public static function dispatch(Event $event): void
    {
        $listeners = self::$listeners[get_class($event)] ?? [];

        foreach ($listeners as $listener) {
            if (is_callable($listener)) {
                $listener($event);
            } else {
                $listener->handle($event);
            }
        }
    }

    /**
     * @param  class-string<\Mateusjatenee\SmolTest\Event\Event>  $event
     * @param  \Mateusjatenee\SmolTest\Event\Listener|callable  $listener
     */
    public static function listen(string $event, Listener|callable $listener): void
    {
        static::$listeners[$event][] = $listener;
    }
}

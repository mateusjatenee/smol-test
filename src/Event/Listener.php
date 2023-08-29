<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Event;

interface Listener
{
    public function handle(Event $event);
}

<?php

namespace Tests\Unit;

use App\Models\Event;
use PHPUnit\Framework\TestCase;

class EventModelTest extends TestCase
{
    public function test_event_dates_are_cast_to_datetime(): void
    {
        $event = new Event();

        $this->assertSame('datetime', $event->getCasts()['start_date']);
        $this->assertSame('datetime', $event->getCasts()['end_date']);
    }
}

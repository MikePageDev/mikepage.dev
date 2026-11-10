<?php

namespace Tests\Feature;

use Tests\TestCase;

class MailConfigTest extends TestCase
{
    public function test_smtp_timeout_is_bounded_so_a_hung_server_cannot_outlast_the_request(): void
    {
        $timeout = config('mail.mailers.smtp.timeout');

        $this->assertIsNumeric($timeout);
        $this->assertGreaterThan(0, $timeout);
        $this->assertLessThanOrEqual(15, $timeout);
    }
}

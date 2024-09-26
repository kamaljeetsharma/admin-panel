<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_a_basic_request(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_returns_error_response_if_email_is_invalid()
    {
        // Simulate user signup with an invalid email
        $response = $this->post('/signup', [
            'name' => 'John Doe',
            'email' => 'Invalid-email', // Invalid email format
            'mobile_number' => '1234567890',
        ]);

        // Assert the response status and message
        $response->assertStatus(302); // Unprocessable Entity
        $response->assertJsonValidationErrors(['email']); // Check for email validation error
    }
}

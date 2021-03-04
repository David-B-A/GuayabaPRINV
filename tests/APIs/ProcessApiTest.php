<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Process;

class ProcessApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_process()
    {
        $process = Process::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/processes', $process
        );

        $this->assertApiResponse($process);
    }

    /**
     * @test
     */
    public function test_read_process()
    {
        $process = Process::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/processes/'.$process->id
        );

        $this->assertApiResponse($process->toArray());
    }

    /**
     * @test
     */
    public function test_update_process()
    {
        $process = Process::factory()->create();
        $editedProcess = Process::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/processes/'.$process->id,
            $editedProcess
        );

        $this->assertApiResponse($editedProcess);
    }

    /**
     * @test
     */
    public function test_delete_process()
    {
        $process = Process::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/processes/'.$process->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/processes/'.$process->id
        );

        $this->response->assertStatus(404);
    }
}

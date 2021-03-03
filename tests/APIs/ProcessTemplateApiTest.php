<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ProcessTemplate;

class ProcessTemplateApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_process_template()
    {
        $processTemplate = ProcessTemplate::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/process_templates', $processTemplate
        );

        $this->assertApiResponse($processTemplate);
    }

    /**
     * @test
     */
    public function test_read_process_template()
    {
        $processTemplate = ProcessTemplate::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/process_templates/'.$processTemplate->id
        );

        $this->assertApiResponse($processTemplate->toArray());
    }

    /**
     * @test
     */
    public function test_update_process_template()
    {
        $processTemplate = ProcessTemplate::factory()->create();
        $editedProcessTemplate = ProcessTemplate::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/process_templates/'.$processTemplate->id,
            $editedProcessTemplate
        );

        $this->assertApiResponse($editedProcessTemplate);
    }

    /**
     * @test
     */
    public function test_delete_process_template()
    {
        $processTemplate = ProcessTemplate::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/process_templates/'.$processTemplate->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/process_templates/'.$processTemplate->id
        );

        $this->response->assertStatus(404);
    }
}

<?php namespace Tests\Repositories;

use App\Models\ProcessTemplate;
use App\Repositories\ProcessTemplateRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ProcessTemplateRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ProcessTemplateRepository
     */
    protected $processTemplateRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->processTemplateRepo = \App::make(ProcessTemplateRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_process_template()
    {
        $processTemplate = ProcessTemplate::factory()->make()->toArray();

        $createdProcessTemplate = $this->processTemplateRepo->create($processTemplate);

        $createdProcessTemplate = $createdProcessTemplate->toArray();
        $this->assertArrayHasKey('id', $createdProcessTemplate);
        $this->assertNotNull($createdProcessTemplate['id'], 'Created ProcessTemplate must have id specified');
        $this->assertNotNull(ProcessTemplate::find($createdProcessTemplate['id']), 'ProcessTemplate with given id must be in DB');
        $this->assertModelData($processTemplate, $createdProcessTemplate);
    }

    /**
     * @test read
     */
    public function test_read_process_template()
    {
        $processTemplate = ProcessTemplate::factory()->create();

        $dbProcessTemplate = $this->processTemplateRepo->find($processTemplate->id);

        $dbProcessTemplate = $dbProcessTemplate->toArray();
        $this->assertModelData($processTemplate->toArray(), $dbProcessTemplate);
    }

    /**
     * @test update
     */
    public function test_update_process_template()
    {
        $processTemplate = ProcessTemplate::factory()->create();
        $fakeProcessTemplate = ProcessTemplate::factory()->make()->toArray();

        $updatedProcessTemplate = $this->processTemplateRepo->update($fakeProcessTemplate, $processTemplate->id);

        $this->assertModelData($fakeProcessTemplate, $updatedProcessTemplate->toArray());
        $dbProcessTemplate = $this->processTemplateRepo->find($processTemplate->id);
        $this->assertModelData($fakeProcessTemplate, $dbProcessTemplate->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_process_template()
    {
        $processTemplate = ProcessTemplate::factory()->create();

        $resp = $this->processTemplateRepo->delete($processTemplate->id);

        $this->assertTrue($resp);
        $this->assertNull(ProcessTemplate::find($processTemplate->id), 'ProcessTemplate should not exist in DB');
    }
}

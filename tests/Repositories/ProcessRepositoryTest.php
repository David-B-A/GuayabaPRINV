<?php namespace Tests\Repositories;

use App\Models\Process;
use App\Repositories\ProcessRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ProcessRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ProcessRepository
     */
    protected $processRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->processRepo = \App::make(ProcessRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_process()
    {
        $process = Process::factory()->make()->toArray();

        $createdProcess = $this->processRepo->create($process);

        $createdProcess = $createdProcess->toArray();
        $this->assertArrayHasKey('id', $createdProcess);
        $this->assertNotNull($createdProcess['id'], 'Created Process must have id specified');
        $this->assertNotNull(Process::find($createdProcess['id']), 'Process with given id must be in DB');
        $this->assertModelData($process, $createdProcess);
    }

    /**
     * @test read
     */
    public function test_read_process()
    {
        $process = Process::factory()->create();

        $dbProcess = $this->processRepo->find($process->id);

        $dbProcess = $dbProcess->toArray();
        $this->assertModelData($process->toArray(), $dbProcess);
    }

    /**
     * @test update
     */
    public function test_update_process()
    {
        $process = Process::factory()->create();
        $fakeProcess = Process::factory()->make()->toArray();

        $updatedProcess = $this->processRepo->update($fakeProcess, $process->id);

        $this->assertModelData($fakeProcess, $updatedProcess->toArray());
        $dbProcess = $this->processRepo->find($process->id);
        $this->assertModelData($fakeProcess, $dbProcess->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_process()
    {
        $process = Process::factory()->create();

        $resp = $this->processRepo->delete($process->id);

        $this->assertTrue($resp);
        $this->assertNull(Process::find($process->id), 'Process should not exist in DB');
    }
}

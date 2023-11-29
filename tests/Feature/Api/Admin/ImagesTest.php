<?php

namespace Tests\Feature\Api\Admin;

use App\Http\Resources\Api\Admin\ImagesResource;
use App\Models\Users;
use App\Models\Images;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\Feature\Api\ApiTestCase;

class ImagesTest extends ApiTestCase
{
	private FilesystemAdapter $storage;
	
	protected string $baseRouteName = 'api.admin.images';

    public function setUp(): void
    {
        parent::setUp();
		
		$this->storage = Storage::fake('uploads');
		Sanctum::actingAs(Users::factory()->create(), ['*'], 'admin');
	}

	/** @test */
    public function can_upload_an_image()
    {
        $payload = [
            'file' => UploadedFile::fake()->image('sample.jpg')
        ];

        $response = $this->post($this->getRoute('upload'), $payload)
            ->assertStatus(201)
            ->json();

        $image = Images::findOrFail($response['data']['id']);
        $this->assertEquals(ImagesResource::make($image)->resolve(), $response['data']);

        $this->storage->assertExists("$image->id/$image->filename");

        foreach(Images::RESPONSIVE_IMAGE_WIDTHS as $name => $value) {
            $this->storage->assertExists("$image->id/$name/$image->filename");
        }
    }

	/** @test */
	public function can_destroy_an_image()
	{
		$this->markTestSkipped("it works but I'm thinking about keeping images just in case");

		$imageId = Images::factory()->create()->id;

        $this->delete($this->getRoute('destroy', $imageId))
            ->assertStatus(204);

        $this->assertNull(Images::find($imageId));
	}
}

<?php

namespace Tests\Feature\DataMaster\DataMedis;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\AuthUser;

class TindakanControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;
    use WithoutMiddleware;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testStore()
    {
        $user = factory(AuthUser::class)->create();

        $response = $this->actingAs($user)
            ->post('data-master/data-medis/tindakan/', [
                'treatment_cd'   => $this->faker->unique()->word,
                'treatment_nm'   => $this->faker->unique()->word,
        ]);

        $response->assertStatus(200);

    }
}

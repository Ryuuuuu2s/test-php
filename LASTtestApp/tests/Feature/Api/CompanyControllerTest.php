<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Company;
use App\Models\CompanyBilling;

class CompanyControllerTest extends TestCase
{

    use WithFaker;


    public function setUp(): void
    {
        parent::setUp();
    }

     /**
     * @test
     */
    public function 会社情報の登録成功()
    {

        $companyData = Company::factory()->make()->toArray();

        $response = $this->postJson(route('api.company.create'), $companyData);

        $response->assertStatus(200);
            
    }

    /**
     * @test
     */
    public function 会社情報詳細の取得成功()
    {
        $company = Company::factory()->create();

        $response = $this->get(route('api.company.show', ['id' => $company->id]));

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function 会社情報の更新成功()
    {
        $company = Company::factory()->create(); 
        $updateData = ['name' => $this->faker->company];

        $response = $this->putJson(route('api.company.update', ['id' => $company->id]), $updateData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('companies', ['id' => $company->id, 'name' => $updateData['name']]);
    }

    /**
     * @test
     */
    public function 会社情報を論理削除成功()
    {
        $company = Company::factory()->create();
        $billing = CompanyBilling::factory()->create(['company_id' => $company->id]);

        $response = $this->deleteJson(route('api.company.destroy', ['id' => $company->id]));

        $response->assertStatus(200)
                ->assertJson(['message' => 'ok']);

        $this->assertSoftDeleted('companies', ['id' => $company->id]);
        $this->assertSoftDeleted('company_billings', ['id' => $billing->id]);
    }

    /**
     * @test
     */
    public function 会社情報と請求先情報を同時に取得成功()
    {
        $company = Company::factory()->create();
        $billing = CompanyBilling::factory()->create(['company_id' => $company->id]);

        $response = $this->getJson(route('api.company.show.with.billing', ['id' => $company->id]));

        $response->assertStatus(200);
      
    }

    /**
     * @test
     */
    public function 会社情報の登録失敗_必須フィールド欠落()
    {
        $companyData = Company::factory()->make([
            'name' => null,
        ])->toArray();

        $response = $this->postJson(route('api.company.create'), $companyData);

        $response->assertStatus(422);  
        $response->assertJsonValidationErrors(['name']);
    }

    /**
     * @test
     */
    public function 会社情報詳細の取得失敗_存在しないID()
    {
        $nonExistentId = Company::max('id') + 1;

        $response = $this->getJson(route('api.company.show', ['id' => $nonExistentId]));

        $response->assertStatus(404); 
    }

    /**
     * @test
     */
    public function 会社情報の更新失敗_必須フィールド欠落()
    {
        $company = Company::factory()->create();

        $updateData = ['name' => null];

        $response = $this->putJson(route('api.company.update', ['id' => $company->id]), $updateData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    /**
     * @test
     */
    public function 会社情報を論理削除失敗_存在しないID()
    {
        $nonExistentId = Company::max('id') + 1;

        $response = $this->deleteJson(route('api.company.destroy', ['id' => $nonExistentId]));

        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function 会社情報と請求先情報を同時に取得失敗_存在しないID()
    {
        $nonExistentId = Company::max('id') + 1;

        $response = $this->getJson(route('api.company.show.with.billing', ['id' => $nonExistentId]));

        $response->assertStatus(404);
    }

}
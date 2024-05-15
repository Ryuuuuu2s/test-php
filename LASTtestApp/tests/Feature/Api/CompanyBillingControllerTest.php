<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Company;
use App\Models\CompanyBilling;

class CompanyBillingControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @var Company
     */
    private $company;

    public function setUp(): void
    {
        parent::setUp();
        $this->company = Company::factory()->create();
    }

    public function 請求先情報の登録成功()
    {
        $billingData = CompanyBilling::factory()->make([
            'company_id' => $this->company->id,
        ])->toArray();

        $response = $this->postJson(route('company-billings.store'), $billingData);

        $response->assertStatus(200);
    }

    /** 
     * @test 
     */
    public function 請求先情報のみ取得成功()
    {
        $billing = CompanyBilling::factory()->create();

        $response = $this->getJson(route('company-billings.show', ['company_billing' => $billing->id]));

        $response->assertStatus(200);
    }

   /** 
     * @test 
     */
    public function 請求先情報を更新成功()
    {
        $billing = CompanyBilling::factory()->create([
            'company_id' => $this->company->id
        ]);

        $updateData = [
            'name' => $this->faker->name,
            'name_kana' => $this->faker->name,
            'address' => $this->faker->address,
            'tel' => $this->faker->phoneNumber,
            'department' => $this->faker->word,
            'billing_name' => $this->faker->name,
            'billing_name_kana' => $this->faker->name
        ];

        $response = $this->putJson(route('company-billings.update', ['company_billing' => $billing->id]), $updateData);

        $response->assertStatus(200)
                ->assertJson($updateData);
    }

    /**
     * @test
     */
    public function 請求先情報を論理削除成功()
    {
        $billing = CompanyBilling::factory()->create();

        $response = $this->deleteJson(route('company-billings.destroy', ['company_billing' => $billing->id]));

        $response->assertStatus(200)
                ->assertJson(['message' => 'Billing information deleted successfully.']);

        $this->assertSoftDeleted('company_billings', ['id' => $billing->id]);
    }

    /**
     * @test
     */
    public function 請求先情報の登録失敗_必須フィールド欠落()
    {
        $company = Company::factory()->create();
        $billingData = [
            'name' => null,
            'name_kana' => 'テストカナ',
            'address' => 'テスト住所',
            'tel' => '0120-333-906',
            'department' => 'テスト部門',
            'billing_name' => 'テスト請求名',
            'billing_name_kana' => 'テスト請求名カナ'
        ];

        $response = $this->postJson("/api/companies/{$company->id}/billings", $billingData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }
        

    /** 
     * @test 
     */
    public function 請求先情報の取得失敗_存在しないID()
    {
        $nonExistentId = CompanyBilling::max('id') + 1;

        $response = $this->getJson(route('company-billings.show', ['company_billing' => $nonExistentId]));

        $response->assertStatus(404);
    }

    /** 
     * @test 
     */
    public function 請求先情報の更新失敗_必須フィールド欠落()
    {
        $billing = CompanyBilling::factory()->create([
            'company_id' => $this->company->id
        ]);

        $updateData = [
            'name' => null, 
        ];

        $response = $this->putJson(route('company-billings.update', ['company_billing' => $billing->id]), $updateData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    /** 
     * @test 
     */
    public function 請求先情報の論理削除失敗_存在しないID()
    {
        $nonExistentId = CompanyBilling::max('id') + 1;

        $response = $this->deleteJson(route('company-billings.destroy', ['company_billing' => $nonExistentId]));

        $response->assertStatus(404);
    }
}
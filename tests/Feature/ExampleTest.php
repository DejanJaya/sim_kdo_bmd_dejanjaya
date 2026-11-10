<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Test the login page is accessible.
     */
    public function test_the_login_page_is_accessible(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('SI-KDO');
    }

    /**
     * Test root redirects to dashboard or login.
     */
    public function test_root_redirects_to_login_for_guests(): void
    {
        $response = $this->get('/');
        $response->assertStatus(302);
    }

    /**
     * Test dashboard API summary returns valid json.
     */
    public function test_dashboard_api_returns_success(): void
    {
        $response = $this->getJson('/api/dashboard/summary');
        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'cards' => [
                    'total_kdo',
                    'kondisi_baik',
                    'kondisi_rusak_ringan',
                    'kondisi_rusak_berat',
                ],
                'chart_kondisi',
                'chart_pd',
            ]
        ]);
    }

    /**
     * Test API KDO endpoint.
     */
    public function test_api_kdo_returns_data(): void
    {
        $response = $this->getJson('/api/kdo');
        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
    }

    /**
     * Test API Perangkat Daerah endpoint.
     */
    public function test_api_perangkat_daerah_returns_data(): void
    {
        $response = $this->getJson('/api/perangkat-daerah');
        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
    }

    /**
     * Test API PNS endpoint.
     */
    public function test_api_pns_returns_data(): void
    {
        $response = $this->getJson('/api/pns');
        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
    }

    /**
     * Test authenticated user can access view CRUD pages.
     */
    public function test_authenticated_user_can_access_crud_views(): void
    {
        $user = User::first();

        $responseKdo = $this->actingAs($user)->get('/kdo');
        $responseKdo->assertStatus(200);
        $responseKdo->assertSee('Daftar Inventaris Kendaraan Dinas Operasional');

        $responsePns = $this->actingAs($user)->get('/pns');
        $responsePns->assertStatus(200);
        $responsePns->assertSee('Daftar Pegawai Penanggung Jawab KDO');

        $responsePd = $this->actingAs($user)->get('/perangkat-daerah');
        $responsePd->assertStatus(200);
        $responsePd->assertSee('Daftar Satuan Kerja Perangkat Daerah');
    }

    /**
     * Test API Authentication login.
     */
    public function test_api_auth_login_successful(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'admin@kdo.go.id',
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonStructure([
            'data' => [
                'user',
                'token',
            ]
        ]);
    }
}

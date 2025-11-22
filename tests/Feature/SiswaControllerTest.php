<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Guru;
use App\Models\Sekolah;
use App\Models\KelompokKelas;
use App\Models\Siswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiswaControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $guru;
    private $sekolah;
    private $kelas;

    protected function setUp(): void
    {
        parent::setUp();

        // Create sekolah
        $this->sekolah = Sekolah::factory()->create();

        // Create user with guru profile
        $this->user = User::factory()->create([
            'role' => 'guru',
        ]);

        // Create guru
        $this->guru = Guru::create([
            'user_id' => $this->user->id,
            'sekolah_id' => $this->sekolah->id,
            'nama_guru' => 'Test Guru',
            'nip' => '123456789',
            'student_quota' => 30,
            'student_count' => 0,
        ]);

        // Create class
        $this->kelas = KelompokKelas::create([
            'guru_id' => $this->guru->id,
            'sekolah_id' => $this->sekolah->id,
            'nama_kelas' => 'Class A',
            'tahun_ajaran' => '2025-2026',
        ]);
    }

    /**
     * Test that student_count is incremented when a student is added.
     */
    public function test_student_count_increments_on_create()
    {
        $this->actingAs($this->user);

        $initialCount = $this->guru->fresh()->student_count;
        $this->assertEquals(0, $initialCount);

        // Add student
        $response = $this->postJson(route('guru.siswa.store'), [
            'nama_lengkap' => 'John Doe',
            'nisn' => '1234567890',
            'kelompok_kelas_id' => $this->kelas->id,
        ]);

        $response->assertJson(['success' => true]);

        // Verify student_count incremented
        $updatedCount = $this->guru->fresh()->student_count;
        $this->assertEquals(1, $updatedCount);
    }

    /**
     * Test that student_count doesn't go negative on delete.
     */
    public function test_student_count_cannot_go_negative()
    {
        $this->actingAs($this->user);

        // Set student_count to 0
        $this->guru->update(['student_count' => 0]);

        // Create a siswa
        $siswa = Siswa::create([
            'kelompok_kelas_id' => $this->kelas->id,
            'sekolah_id' => $this->sekolah->id,
            'nama_lengkap' => 'Test Student',
        ]);

        // Try to delete (should not cause error)
        $response = $this->deleteJson(route('guru.siswa.destroy', $siswa));

        $response->assertRedirect(route('guru.siswa.index'));

        // Verify student_count is still 0 (not negative)
        $finalCount = $this->guru->fresh()->student_count;
        $this->assertEquals(0, $finalCount);
    }

    /**
     * Test that student_count decrements correctly on delete.
     */
    public function test_student_count_decrements_on_delete()
    {
        $this->actingAs($this->user);

        // Create student via API
        $this->postJson(route('guru.siswa.store'), [
            'nama_lengkap' => 'John Doe',
            'nisn' => '1234567890',
            'kelompok_kelas_id' => $this->kelas->id,
        ]);

        // Verify count is 1
        $this->assertEquals(1, $this->guru->fresh()->student_count);

        // Delete student
        $siswa = $this->kelas->siswas()->first();
        $this->deleteJson(route('guru.siswa.destroy', $siswa));

        // Verify count went back to 0
        $finalCount = $this->guru->fresh()->student_count;
        $this->assertEquals(0, $finalCount);
    }

    /**
     * Test that multiple students are tracked correctly.
     */
    public function test_multiple_students_tracked_correctly()
    {
        $this->actingAs($this->user);

        // Add 3 students
        for ($i = 1; $i <= 3; $i++) {
            $this->postJson(route('guru.siswa.store'), [
                'nama_lengkap' => "Student $i",
                'nisn' => "123456789$i",
                'kelompok_kelas_id' => $this->kelas->id,
            ]);
        }

        $this->assertEquals(3, $this->guru->fresh()->student_count);

        // Delete 1 student
        $siswa = $this->kelas->siswas()->first();
        $this->deleteJson(route('guru.siswa.destroy', $siswa));

        $this->assertEquals(2, $this->guru->fresh()->student_count);

        // Delete another
        $siswa = $this->kelas->siswas()->first();
        $this->deleteJson(route('guru.siswa.destroy', $siswa));

        $this->assertEquals(1, $this->guru->fresh()->student_count);
    }
}

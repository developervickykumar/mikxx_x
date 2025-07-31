<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeatureAccessMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $role;
    protected $permission;
    protected $adminRole;
    protected $childRole;

    protected function setUp(): void
    {
        parent::setUp();

        // Create admin role
        $this->adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'System Administrator',
            'status' => true,
            'is_system' => true
        ]);

        // Create a test role
        $this->role = Role::create([
            'name' => 'Test Role',
            'slug' => 'test-role',
            'description' => 'Test Role Description',
            'status' => true,
            'is_system' => false
        ]);

        // Create a child role
        $this->childRole = Role::create([
            'name' => 'Child Role',
            'slug' => 'child-role',
            'description' => 'Child Role Description',
            'status' => true,
            'is_system' => false,
            'parent_id' => $this->role->id
        ]);

        // Create test permissions
        $this->permission = Permission::create([
            'name' => 'form-builder',
            'slug' => 'form-builder',
            'description' => 'Form Builder Access',
            'category' => 'form-builder',
            'status' => true,
            'is_system' => false
        ]);

        $this->categoriesPermission = Permission::create([
            'name' => 'categories',
            'slug' => 'categories',
            'description' => 'Categories Access',
            'category' => 'categories',
            'status' => true,
            'is_system' => false
        ]);

        // Create a test user
        $this->user = User::factory()->create([
            'status' => true,
            'user_type' => 'team'
        ]);
        $this->user->role()->associate($this->role);
        $this->user->save();
    }

    /** @test */
    public function it_denies_access_when_user_has_no_permission()
    {
        $response = $this->actingAs($this->user)
            ->get('/test/form-builder');

        $response->assertStatus(403);
    }

    /** @test */
    public function it_grants_access_when_user_has_direct_permission()
    {
        $this->user->permissions()->attach($this->permission);

        $response = $this->actingAs($this->user)
            ->get('/test/form-builder');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Form Builder access granted']);
    }

    /** @test */
    public function it_grants_access_when_user_role_has_permission()
    {
        $this->role->permissions()->attach($this->permission);

        $response = $this->actingAs($this->user)
            ->get('/test/form-builder');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Form Builder access granted']);
    }

    /** @test */
    public function it_denies_access_to_unauthorized_features()
    {
        $this->user->permissions()->attach($this->permission);

        $response = $this->actingAs($this->user)
            ->get('/test/categories');

        $response->assertStatus(403);
    }

    /** @test */
    public function it_grants_access_when_user_has_inherited_permission()
    {
        $this->role->permissions()->attach($this->permission);
        $this->user->role()->associate($this->childRole);
        $this->user->save();

        $response = $this->actingAs($this->user)
            ->get('/test/form-builder');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Form Builder access granted']);
    }

    /** @test */
    public function it_denies_access_when_user_is_inactive()
    {
        $this->user->update(['status' => false]);
        $this->user->permissions()->attach($this->permission);

        $response = $this->actingAs($this->user)
            ->get('/test/form-builder');

        $response->assertStatus(403);
    }

    /** @test */
    public function it_grants_access_when_user_is_admin()
    {
        $adminUser = User::factory()->create([
            'status' => true,
            'user_type' => 'admin'
        ]);
        $adminUser->role()->associate($this->adminRole);
        $adminUser->save();

        $response = $this->actingAs($adminUser)
            ->get('/test/form-builder');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Form Builder access granted']);
    }

    /** @test */
    public function it_denies_access_when_permission_is_inactive()
    {
        $this->permission->update(['status' => false]);
        $this->user->permissions()->attach($this->permission);

        $response = $this->actingAs($this->user)
            ->get('/test/form-builder');

        $response->assertStatus(403);
    }

    /** @test */
    public function it_denies_access_when_role_is_inactive()
    {
        $this->role->update(['status' => false]);
        $this->role->permissions()->attach($this->permission);

        $response = $this->actingAs($this->user)
            ->get('/test/form-builder');

        $response->assertStatus(403);
    }
} 
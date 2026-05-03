<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('profile page loads correctly', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('profile.index'))
        ->assertOk()
        ->assertSee($user->name)
        ->assertSee($user->email);
});

test('profile edit page loads correctly', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('profile.edit'))
        ->assertOk();
});

test('guest cannot access profile page', function () {
    $this->get(route('profile.index'))
        ->assertRedirect(route('login'));
});

test('user can update their profile information', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->put(route('profile.update'), [
            'name'  => 'Updated Name',
            'email' => 'updated@example.com',
            'phone' => '+91 9876543210',
            'bio'   => 'This is my bio',
        ])
        ->assertRedirect(route('profile.index'))
        ->assertSessionHasNoErrors();

    $user->refresh();

    $this->assertSame('Updated Name',        $user->name);
    $this->assertSame('updated@example.com', $user->email);
    $this->assertSame('+91 9876543210',      $user->phone);
    $this->assertSame('This is my bio',      $user->bio);
});

test('profile update requires a name', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->put(route('profile.update'), [
            'name'  => '',
            'email' => $user->email,
        ])
        ->assertSessionHasErrors('name');
});

test('profile update requires a valid email', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->put(route('profile.update'), [
            'name'  => $user->name,
            'email' => 'not-a-valid-email',
        ])
        ->assertSessionHasErrors('email');
});

test('email must be unique when updating profile', function () {
    User::factory()->create(['email' => 'taken@example.com']);
    $user = User::factory()->create();

    $this->actingAs($user)
        ->put(route('profile.update'), [
            'name'  => $user->name,
            'email' => 'taken@example.com',
        ])
        ->assertSessionHasErrors('email');
});

test('user can upload an avatar', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    $file = UploadedFile::fake()->image('avatar.jpg', 100, 100);

    $this->actingAs($user)
        ->put(route('profile.update'), [
            'name'   => $user->name,
            'email'  => $user->email,
            'avatar' => $file,
        ])
        ->assertRedirect(route('profile.index'))
        ->assertSessionHasNoErrors();

    $user->refresh();

    $this->assertNotNull($user->avatar);
    Storage::disk('public')->assertExists($user->avatar);
});

test('avatar must be an image file', function () {
    $user = User::factory()->create();
    $file = UploadedFile::fake()->create('document.pdf', 100);

    $this->actingAs($user)
        ->put(route('profile.update'), [
            'name'   => $user->name,
            'email'  => $user->email,
            'avatar' => $file,
        ])
        ->assertSessionHasErrors('avatar');
});

test('user can remove their avatar', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    Storage::disk('public')->put('avatars/avatar.jpg', '');
    $user->update(['avatar' => 'avatars/avatar.jpg']);

    $this->actingAs($user)
        ->delete(route('profile.avatar.remove'))
        ->assertRedirect()
        ->assertSessionHasNoErrors();

    $this->assertNull($user->refresh()->avatar);
});

test('user can change their password', function () {
    $user = User::factory()->create([
        'password' => bcrypt('oldpassword123'),
    ]);

    $this->actingAs($user)
        ->put(route('profile.password'), [
            'current_password'      => 'oldpassword123',
            'password'              => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ])
        ->assertRedirect()
        ->assertSessionHasNoErrors();
});

test('wrong current password fails validation', function () {
    $user = User::factory()->create([
        'password' => bcrypt('correctpassword'),
    ]);

    $this->actingAs($user)
        ->put(route('profile.password'), [
            'current_password'      => 'wrongpassword',
            'password'              => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ])
        ->assertSessionHasErrors('current_password');
});

test('new password must be confirmed', function () {
    $user = User::factory()->create([
        'password' => bcrypt('password123'),
    ]);

    $this->actingAs($user)
        ->put(route('profile.password'), [
            'current_password'      => 'password123',
            'password'              => 'newpassword123',
            'password_confirmation' => 'doesnotmatch',
        ])
        ->assertSessionHasErrors('password');
});

test('new password must be at least 8 characters', function () {
    $user = User::factory()->create([
        'password' => bcrypt('password123'),
    ]);

    $this->actingAs($user)
        ->put(route('profile.password'), [
            'current_password'      => 'password123',
            'password'              => 'short',
            'password_confirmation' => 'short',
        ])
        ->assertSessionHasErrors('password');
});

test('avatar url returns ui-avatars when no avatar uploaded', function () {
    $user = User::factory()->create(['avatar' => null]);

    $this->assertStringContainsString('ui-avatars.com', $user->avatarUrl());
});

test('avatar url returns storage url when avatar exists', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    Storage::disk('public')->put('avatars/test.jpg', '');
    $user->update(['avatar' => 'avatars/test.jpg']);

    $this->assertStringContainsString('storage', $user->avatarUrl());
});

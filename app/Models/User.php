<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * USER ATTRIBUTES
 * $this->attributes['id'] - int - primary key
 * $this->attributes['name'] - string - full name of the user
 * $this->attributes['email'] - string - email address, unique
 * $this->attributes['password'] - string - hashed password
 * $this->attributes['role'] - string - 'admin' or 'customer'
 * $this->attributes['created_at'] - string - creation timestamp
 * $this->attributes['updated_at'] - string - update timestamp
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- SETTERS ---
    public function setId(int $id): void
    {
        $this->attributes['id'] = $id;
    }

    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    public function setEmail(string $email): void
    {
        $this->attributes['email'] = $email;
    }

    public function setRole(string $role): void
    {
        $this->attributes['role'] = $role;
    }

    // Nota: sin setPassword() simple a propósito — el hasheo se maneja
    // explícitamente con Hash::make() en el flujo de registro de Breeze,
    // no como una asignación directa de atributo.

    // Getters
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function getEmail(): string
    {
        return $this->attributes['email'];
    }

    public function getRole(): string
    {
        return $this->attributes['role'];
    }

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
    }

    // Non-primitive methods/relations
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function isAdmin(): bool
    {
        return $this->getRole() === 'admin';
    }
}

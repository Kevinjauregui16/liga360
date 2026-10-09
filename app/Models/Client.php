<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Client
 *
 * @property $id
 * @property $name
 * @property $slug
 * @property $email
 * @property $phone
 * @property $address
 * @property $logo
 * @property $status
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 *
 * @property User[] $users
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Client extends Model
{
    use SoftDeletes;

    public const STATUSES = [
        'active' => 'Activo',
        'inactive' => 'Inactivo',
        'suspended' => 'Suspendido',
    ];

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'slug', 'email', 'phone', 'address', 'logo', 'status'];


    /**
     * Etiqueta en español del estado.
     */
    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    /**
     * Usuarios que pertenecen al cliente.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(\App\Models\User::class, 'client_id');
    }
}

<?php

declare(strict_types = 1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

/**
 * @property int         $id
 * @property string      $login
 * @property string      $display_name
 * @property string      $password Password hash
 * @property string      $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
class User extends AbstractBaseModel implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, Notifiable, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login',
        'display_name',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Generate password hash.
     *
     * @param string $password
     *
     * @return string
     */
    public static function hashPassword(string $password): string
    {
        return Hash::make($password);
    }

    /**
     * Password attribute mutator.
     *
     * @param string $value
     */
    protected function setPasswordAttribute($value): void
    {
        $value = (string) $value;

        // Hash input value only if needed
        if ((Hash::info($value)['algoName'] ?? 'unknown') !== config('hashing.driver')) {
            $value = static::hashPassword($value);
        }

        $this->attributes['password'] = $value;
    }

    public function projects()
    {
        return $this->hasMany(Project::class , 'owner_id');
    }
}

<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function assignRole(Role $role)
    {
        return $this->roles()->attach($role);
    }

    public function removeRole(Role $role)
    {
        return $this->roles()->detach($role);
    }

    public function isUser() {
        return $this->roles()->where('name', 'User')->exists();
    }
    public function isAdministrator() {
        return $this->roles()->where('name', 'Admin')->exists();
    }

    public function cards()
    {
        return $this->hasMany(Card::class)->where('deleted','=','0');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}

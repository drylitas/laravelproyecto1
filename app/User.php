<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
//	protected $fillable = ['name', 'email', 'password'];
    protected $fillable = ['first_name', 'last_name', 'email', 'password', 'type', 'full_name'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function profile()
    {
        return $this->hasOne('App\UserProfile'); // nombre de la clase
    }

    public function getFullNameAttribute()
    {
        return $this->full_name = $this->first_name . ' ' . $this->last_name;
    }

    /*SCOPES*/
    public function scopeEjemplo($query)
    {
        return $query->where('type', '=', 'admin');
    }

    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = bcrypt($value);
        }
    }

}

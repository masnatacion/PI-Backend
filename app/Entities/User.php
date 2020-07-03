<?php
namespace App\Entities;

use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'lastname', 'email', 'username', 'password', 'role', 'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
      $this->attributes['password'] = bcrypt($value);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function isActive()
    {
        return $this->status == 'active';
    }

    public function isAdmin()
    {
        return $this->role == 'admin';
    }


    public function attachDocument($type="picture", $file)
    {

        $filename  = $file->getClientOriginalName();
        $extension = $file->extension();

        $document = $this->documents()->create([
            "filename"  => $filename,
            "extension" => $extension,
            "type"      => $type,
        ]);

        $file->storeAs('documents/',$document->id.'.'.$extension);

        return $document;
    }

    public function attachPicture($file)
    {
        $this->documents()->picture()->delete();
        return $this->attachDocument("picture",$file);
    }

    public function attachCV($file)
    {
        $this->documents()->cv()->delete();
        return $this->attachDocument("cv",$file);
    }
    /*
    |--------------------------------------------------------------------------
    | Model Query Scopes
    |--------------------------------------------------------------------------
    |
    |
    */
    public function scopeActive($query)
    {
        $query->where('status','active');
    }

    public function scopeAdmin($query)
    {
        $query->where('role','admin');
    }

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    |
    |
    */

    public function picture()
    {
        return $this->hasOne('App\Entities\Document')->where("type","picture");
    }

    public function cv()
    {
        return $this->hasOne('App\Entities\Document')->where("type","cv");
    }

    public function documents()
    {
        return $this->hasMany('App\Entities\Document');
    }
}

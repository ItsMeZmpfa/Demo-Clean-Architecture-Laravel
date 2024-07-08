<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Domain\Interfaces\User\UserEntity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements UserEntity
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'userId',
        'password',
        'name',
        'email',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'updated_at',
        'created_at',
        'email_verified_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // UserEntity methods

    /**
     * Get the id of the user
     * @return int
     */
    public function getUserId(): int
    {
        return $this->attributes['userId'] ?? '';
    }

    /**
     * Get the Name of the user
     * @return string
     */
    public function getUserName(): string
    {
        return $this->attributes['name'] ?? '';
    }

    /**
     * Get the first name of the user
     * @return string
     */
    public function getUserFirstName(): string
    {
        return $this->attributes['firstName'] ?? '';
    }

    /**
     * set the first name of the user
     * @param  string  $userFirstName
     * @return void
     */
    public function setUserFirstName(string $userFirstName): void
    {
        $this->attributes['firstName'] = $userFirstName;
    }

    /**
     * Get the last name of the user
     * @return string
     */
    public function getUserLastName(): string
    {
        return $this->attributes['lastName'] ?? '';
    }

    /**
     * set the last name of the user
     * @param  string  $userLastName
     * @return void
     */
    public function setUserLastName(string $userLastName): void
    {
        $this->attributes['lastName'] = $userLastName;
    }

    /**
     * Get the email of the user
     * @return EmailValueObject
     */
    public function getUserEmail(): EmailValueObject
    {
        return new EmailValueObject($this->attributes['email']);
    }

    /**
     * set the email of the user
     * @param  EmailValueObject  $email
     * @return void
     */
    public function setUserEmail(EmailValueObject $email): void
    {
        $this->attributes['email'] = (string) $email;
    }

    /**
     * Get the password of the user
     * @return HashedPasswordValueObject
     */
    public function getUserPassword(): HashedPasswordValueObject
    {
        return new HashedPasswordValueObject($this->attributes['password']);
    }

    /**
     * set the password of the user
     * @param  PasswordValueObject  $userUserPassword
     * @return void
     */
    public function setUserPassword(PasswordValueObject $userUserPassword): void
    {
        $this->attributes['password'] = (string) $userUserPassword->hashed();
    }

    /**
     * The roles that belong to the User
     *
     * @return BelongsToMany
     */
    public function schedule(): BelongsToMany
    {
        return $this->belongsToMany(Schedule::class, 'user_schedule_table', 'user_id', 'schedule_id');
    }
}

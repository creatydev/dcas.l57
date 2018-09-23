<?php

namespace App\Models\Roles;

use App\Ticket;
use Bpocallaghan\Sluggable\HasSlug;
use Bpocallaghan\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Passport\HasApiTokens;
use Laravel\Scout\Searchable;
use QCod\ImageUp\HasImageUploads;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\Roles\WhiteGlove
 *
 * @property int $id
 * @property string $account_id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property bool|\DateTime $email_verified_at
 * @property string $password
 * @property string|null $stripe_id
 * @property string|null $card_brand
 * @property string|null $card_last_four
 * @property bool|\DateTime $trial_ends_at
 * @property string|null $cover
 * @property string|null $avatar
 * @property string|null $remember_token
 * @property bool|\DateTime $deleted_at
 * @property bool|\DateTime $created_at
 * @property bool|\DateTime $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Cashier\Subscription[] $subscriptions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Support\Ticket[] $tickets
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Roles\WhiteGlove onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Roles\WhiteGlove permission($permissions)
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Roles\WhiteGlove role($roles)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Roles\WhiteGlove whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Roles\WhiteGlove whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Roles\WhiteGlove whereCardBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Roles\WhiteGlove whereCardLastFour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Roles\WhiteGlove whereCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Roles\WhiteGlove whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Roles\WhiteGlove whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Roles\WhiteGlove whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Roles\WhiteGlove whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Roles\WhiteGlove whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Roles\WhiteGlove whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Roles\WhiteGlove wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Roles\WhiteGlove whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Roles\WhiteGlove whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Roles\WhiteGlove whereTrialEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Roles\WhiteGlove whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Roles\WhiteGlove whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Roles\WhiteGlove withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Roles\WhiteGlove withoutTrashed()
 * @mixin \Eloquent
 */
class WhiteGlove extends Authenticatable
{

    use Billable, HasApiTokens, HasImageUploads, HasRoles, HasSlug, Notifiable, Searchable, SoftDeletes;

    /**
     * @var array
     */
    protected static $imageFields = [
        'cover',
        'avatar',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'whitegloves';

    /**
     * @var string
     */
    protected $guard = 'whiteglove';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'email_verified_at',
        'password',
        'stripe_id',
        'card_brand',
        'card_last_four',
        'trial_ends_at',
        'remember_token',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Set the email_verified_at.
     *
     * @param  string $value
     *
     * @return void
     */
    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = ! empty($value) ? \DateTime::createFromFormat($this->getDateFormat(), $value) : null;
    }

    /**
     * Set the trial_ends_at.
     *
     * @param  string $value
     *
     * @return void
     */
    public function setTrialEndsAtAttribute($value)
    {
        $this->attributes['trial_ends_at'] = ! empty($value) ? \DateTime::createFromFormat($this->getDateFormat(), $value) : null;
    }

    /**
     * Get email_verified_at in array format
     *
     * @param  string $value
     *
     * @return bool|\DateTime
     */
    public function getEmailVerifiedAtAttribute($value)
    {
        return \DateTime::createFromFormat('j/n/Y g:i A', $value);
    }

    /**
     * Get trial_ends_at in array format
     *
     * @param  string $value
     *
     * @return bool|\DateTime
     */
    public function getTrialEndsAtAttribute($value)
    {
        return \DateTime::createFromFormat('j/n/Y g:i A', $value);
    }

    /**
     * Get deleted_at in array format
     *
     * @param  string $value
     *
     * @return bool|\DateTime
     */
    public function getDeletedAtAttribute($value)
    {
        return \DateTime::createFromFormat('j/n/Y g:i A', $value);
    }

    /**
     * Get created_at in array format
     *
     * @param  string $value
     *
     * @return bool|\DateTime
     */
    public function getCreatedAtAttribute($value)
    {
        return \DateTime::createFromFormat('j/n/Y g:i A', $value);
    }

    /**
     * Get updated_at in array format
     *
     * @param  string $value
     *
     * @return bool|\DateTime
     */
    public function getUpdatedAtAttribute($value)
    {
        return \DateTime::createFromFormat('j/n/Y g:i A', $value);
    }

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs(): string
    {
        return 'whitegloves_index';
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray(): array
    {
        $array = $this->toArray();

        // Customize array...

        return $array;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(\App\Models\Support\Ticket::class);
    }

    /**
     * @return mixed
     */
    protected function getSlugOptions()
    {
        return SlugOptions::create()->slugSeperator('-')->generateSlugFrom('name')->saveSlugTo('username');
    }
}
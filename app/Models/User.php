<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    const PENDING_INFO_ENTRY = 'PENDING_INFO_ENTRY';
    const PENDING_ADMIN_ENTRY = 'PENDING_ADMIN_APPROVE';
    const APPROVED = 'APPROVED';
    const TYPE = 'vendor';
    const ADMIN = 010;
    const CUSTOMER = 111;

        /**
         * The attributes that are mass assignable.
         *
         * @var array<int, string>
         */
       // protected $table='user';
        protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function vendorProducts(): HasMany
    {
        return $this->hasMany(Product::class, 'vendor_id', 'id')/*->where('isApprove','authorize')*/->orderBy('id','desc');
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class,'supplierId','id');
    }

    public function purchasesReturn(): HasMany
    {
        return $this->hasMany(PurchaseReturn::class,'supplierId','id');
    }

    public function vendorProfile(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'id', 'vendor_id');
    }

}

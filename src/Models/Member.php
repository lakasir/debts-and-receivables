<?php

namespace Modules\DebtsAndReceivables\Models;

use App\Models\Tenants\Member as TenantsMember;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperMember
 */
class Member extends TenantsMember
{
    use HasFactory;

    protected $guarded = ['id'];

    public function receivables(): HasMany
    {
        return $this->hasMany(Receivable::class);
    }
}

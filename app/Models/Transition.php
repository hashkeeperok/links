<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Transition
 *
 * @property int $id
 * @property string|null $user_agent
 * @property string $ip
 * @property int $link_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Transition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transition query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transition whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transition whereLinkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transition whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transition whereUserAgent($value)
 * @mixin \Eloquent
 */
class Transition extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];
}

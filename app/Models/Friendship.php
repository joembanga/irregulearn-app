<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $sender_id
 * @property int $recipient_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Friendship newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Friendship newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Friendship query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Friendship whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Friendship whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Friendship whereRecipientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Friendship whereSenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Friendship whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Friendship whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Friendship extends Model
{
    protected $table = 'friendships';
    protected $fillable = ['sender_id', 'recipient_id', 'status'];

    public $timestamps = true;
}

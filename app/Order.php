<?php

namespace App;

use App\Events\OrderCompletedEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    const STATUS_NEW = 0;
    const STATUS_CONFIRMED = 10;
    const STATUS_COMPLETED = 20;

    protected $with = ['partner'];
    protected $appends = ['sum'];

    protected static function boot()
    {
        parent::boot();
        static::updating(function (self $model) {
            $originalOrder = $model->getOriginal();
            // Если ордер был выполен отправляем евент
            if (($originalOrder['status'] !== $model->status) && $model->isCompleted()) {
                event(new OrderCompletedEvent($model));
            }
        });

    }


    protected $guarded = [];

    public static function statues()
    {
        return [self::STATUS_NEW, self::STATUS_COMPLETED, self::STATUS_CONFIRMED];
    }

    /**
     * @return BelongsTo
     */
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    /**
     * @return HasMany
     */
    public function products()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function getSumAttribute()
    {
        return $this->products->sum(function ($product) {
            return $product['quantity'] * $product['price'];
        });
    }

    /**
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->status == self::STATUS_COMPLETED;
    }

    public function isConfirmed(): bool
    {
        return $this->status == self::STATUS_CONFIRMED;
    }
}

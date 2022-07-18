<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Lampiran;
use App\KendaliUsulan;
use App\User;
use Illuminate\Database\Eloquent\Relations\HasOne;
class Log extends Model
{
    protected $table = 'tb_log';
    
    /**
     * Get the lampiran associated with the Log
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lampiran(): HasOne
    {
        return $this->hasOne(Lampiran::class, 'id', 'lampiran_log')->withDefault();
    }

    /**
     * Get the kendali associated with the Log
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function kendali(): HasOne
    {
        return $this->hasOne(KendaliUsulan::class, 'id', 'kendali_log')->withDefault();
    }

    /**
     * Get the user associated with the Log
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_log')->withDefault();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    // all these fields are optional because i'm use the standard names
    // to change the names of the timestamps fields
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $table = 'stores'; // to specify the table name if not named standard
    protected $connection = 'mysql'; // to specify the connection name if there two conn
    protected $primaryKey = 'id'; // to specify the primary key if not named id
    public $incrementing = true; // for id
    public $timestamps = true; // for created_at , updated_at =>> (false) if deleted


    public function products()
    {
        return $this->hasMany(Product::class,"store_id",'id');
    }
}

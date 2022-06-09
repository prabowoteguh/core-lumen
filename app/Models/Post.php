<?php

/* ==============================================================
| Author        : prabowoteguh
| Created at    : Tue, April 06 2021 23:49:20
| Modify at     : Tue, April 06 2021 23:49:20
| Location      : Unknown
| Description   : Post Model Example
=================================================================*/

/**
 * @OA\Schema(@OA\Xml(name="PostModelExample"))
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Hasfactory;

class Post extends Model
{
    use Hasfactory;

    /**
     * @OA\Property(format="string")
     * @var string
     */
    public $title;

    /**
     * @OA\Property(format="string")
     * @var string
     */
    public $body;

    protected $fillable = [
    	'title',
    	'body'
    ];
}

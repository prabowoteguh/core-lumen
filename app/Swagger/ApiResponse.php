<?php

namespace PetstoreIO;

/**
 * @OA\Schema()
 */
class ApiResponse
{

    /**
     * @OA\Property(format="int32")
     * @var int
     */
    public $code;

    /**
     * @OA\Property
     * @var string
     */
    public $status;

    /**
     * @OA\Property
     * @var string
     */
    public $message;

    /**
     * @OA\Property
     * @var object
     */
    public $data;
}
<?php

namespace PetstoreIO;

/**
 * @OA\Schema(@OA\Xml(name="User"))
 */
class User
{

    /**
     * @OA\Property(format="int64")
     * @var int
     */
    public $id;

    /**
     * User Name
     * @var string
     * @OA\Property(format="int32")
     */
    public $name;

    /**
     * User Email
     * @var string
     */
    public $email;

    /**
     * User Status
     * @var string
     */
    public $phone;

    /**
     * User Role
     * @var int
     * @OA\Property(format="int32")
     */
    public $role;

    /**
     * User Address
     * @var text
     */
    public $address;

    /**
     * User Birth Date
     * @var date
     */
    public $birth;

    /**
     * User avatar
     * @var text
     */
    public $avatar;

    /**
     * User position
     * @var string
     */
    public $position;

    /**
     * User Status
     * @var boolean
     */
    public $status;

    /**
     * User otp
     * @var string
     */
    public $otp;

    /**
     * User otp expired
     * @var date
     */
    public $otp_expired;

}
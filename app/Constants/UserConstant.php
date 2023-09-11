<?php

namespace App\Constants;

/**
 * Class HttpResponse
 *
 * @package App\Constants
 */
class UserConstant
{
    /**
     * @var integer Gender
     */

    /**
     * @var integer status
     */
    const ACTIVE = 1;
    const INACTIVE = 0;

    const MAN = 1;
    const FEMALE = 2;

    const STATUS_TEXT = [
        UserConstant::ACTIVE   => 'Đang hoạt động',
        UserConstant::INACTIVE => 'Đã khóa',
    ];
}

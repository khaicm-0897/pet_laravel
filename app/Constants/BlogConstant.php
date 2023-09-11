<?php

namespace App\Constants;

/**
 * Class HttpResponse
 *
 * @package App\Constants
 */
class BlogConstant
{
    /**
     * @var integer status
     */
    const ACTIVE = 1;
    const INACTIVE = 0;

    const STATUS_TEXT = [
        // SettingConstant::SEARCH_ALL => SettingConstant::SEARCH_ALL_TEXT,
        BlogConstant::ACTIVE => 'Đang hoạt động',
        BlogConstant::INACTIVE => 'Không hiển thị',
    ];
}

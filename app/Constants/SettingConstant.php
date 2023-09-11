<?php

namespace App\Constants;

class SettingConstant
{
    /**
     * @var int
     */
    const DEFAULT_PAGINATE = 10;

    /**
     * @var int
     */
    const DEFAULT_OFFSET = 0;

    /**
     * @var integer status
     */
    const ACTIVE = 1;
    const INACTIVE = 0;

    const STATUS_TEXT = [
        SettingConstant::ACTIVE => 'Đang hoạt động',
        SettingConstant::INACTIVE => 'Đã khóa',
    ];

    const AJAX_SEARCH = 0;
    const AJAX_PAGINATION = 1;

    const CUSTOM_PER_PAGE_20 = 20;
    const CUSTOM_PER_PAGE_50 = 50;
    const CUSTOM_PER_PAGE_100 = 100;

    const CUSTOM_PER_PAGE_TEXT = [
        SettingConstant::DEFAULT_PAGINATE => '10 (mặc định)',
        SettingConstant::CUSTOM_PER_PAGE_20 => SettingConstant::CUSTOM_PER_PAGE_20,
        SettingConstant::CUSTOM_PER_PAGE_50 => SettingConstant::CUSTOM_PER_PAGE_50,
        SettingConstant::CUSTOM_PER_PAGE_100 => SettingConstant::CUSTOM_PER_PAGE_100,
    ];
}

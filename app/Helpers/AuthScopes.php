<?php

namespace App\Helpers;

class AuthScopes
{
    const SCOPE_CATEGORY_SHOW = 'category:show';
    const SCOPE_CATEGORY_CREATE = 'category:create';
    const SCOPE_CATEGORY_UPDATE = 'category:update';
    const SCOPE_CATEGORY_DELETE = 'category:delete';
    const SCOPE_CATEGORY_LIST = 'category:list';


    const ADMIN_SCOPE = [
        self::SCOPE_CATEGORY_SHOW,
        self::SCOPE_CATEGORY_CREATE,
        self::SCOPE_CATEGORY_UPDATE,
        self::SCOPE_CATEGORY_DELETE,
        self::SCOPE_CATEGORY_LIST,
    ];

    const EMPLOYER_SCOPE = [
        self::SCOPE_CATEGORY_LIST,
    ];

    public static function getEmployerScopesToAbilities(): array
    {
        return self::EMPLOYER_SCOPE;
    }

    public static function getAdminScopesToAbilities(): array
    {
        return self::ADMIN_SCOPE;
    }


}

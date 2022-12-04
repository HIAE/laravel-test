<?php

namespace App\Helpers;

class AuthScopes
{
    const SCOPE_CATEGORY_SHOW = 'category:show';
    const SCOPE_CATEGORY_CREATE = 'category:create';
    const SCOPE_CATEGORY_UPDATE = 'category:update';
    const SCOPE_CATEGORY_DELETE = 'category:delete';
    const SCOPE_CATEGORY_LIST = 'category:list';
    const SCOPE_USER_UPDATE = 'user:update';
    const SCOPE_IDEA_SHOW = 'idea:show';
    const SCOPE_IDEA_CREATE = 'idea:create';
    const SCOPE_IDEA_UPDATE = 'idea:update';
    const SCOPE_IDEA_DELETE = 'idea:delete';
    const SCOPE_IDEA_LIST = 'idea:list';


    const ADMIN_SCOPE = [
        self::SCOPE_CATEGORY_SHOW,
        self::SCOPE_CATEGORY_CREATE,
        self::SCOPE_CATEGORY_UPDATE,
        self::SCOPE_CATEGORY_DELETE,
        self::SCOPE_CATEGORY_LIST,
        self::SCOPE_USER_UPDATE,
        self::SCOPE_IDEA_SHOW,
        self::SCOPE_IDEA_CREATE,
        self::SCOPE_IDEA_UPDATE,
        self::SCOPE_IDEA_DELETE,
        self::SCOPE_IDEA_LIST,
    ];

    const EMPLOYER_SCOPE = [
        self::SCOPE_CATEGORY_LIST,
        self::SCOPE_USER_UPDATE,
        self::SCOPE_IDEA_SHOW,
        self::SCOPE_IDEA_CREATE,
        self::SCOPE_IDEA_UPDATE,
        self::SCOPE_IDEA_DELETE,
        self::SCOPE_IDEA_LIST,
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

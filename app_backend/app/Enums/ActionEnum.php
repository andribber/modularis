<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum ActionEnum: string
{
    use Values;

    case ADD_USERS = 'add_users';
    case CREATE = 'create';
    case DELETE = 'delete';
    case EDIT = 'edit';
    case GET_USERS = 'get_users';
    case INDEX = 'index';
    case REMOVE_USERS = 'remove_users';
    case SHOW = 'show';
}

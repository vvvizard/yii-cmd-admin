<?php

namespace app\enums;

enum ArticleStatus: int
{
    case DRAFT = 1;
    case PENDING = 2;
    case PUBLISHED = 3;
    case ARCHIVED = 4;
    case DELETED = 5;
}
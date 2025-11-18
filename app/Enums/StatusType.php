<?php 

namespace App\Enums;

enum StatusType: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case ARCHIVED = 'archived';
    case PENDING = 'pending';
}
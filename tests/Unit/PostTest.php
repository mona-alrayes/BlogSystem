<?php

use App\Models\V1\Post\Post;
use App\Enums\StatusType;

it('returns status as string when accessed and when converted to array', function () {
    $post = new Post(['status' => StatusType::PUBLISHED]);

    expect($post->status)->toBe('published');
    expect($post->toArray()['status'])->toBe('published');
});

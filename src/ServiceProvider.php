<?php

namespace Highland\StatamicArrayGet;

use Highland\StatamicArrayGet\Tags\ArrayGet;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $tags = [ArrayGet::class];
}

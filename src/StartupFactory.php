<?php

namespace trevormh\LaravelStartupHelper;

class StartupFactory
{
    use ContentStore;
    use ValidationHelper;

    /**
     * @return StartupFactory
     */
    public static function resolve()
    {
        return app()->make('trevormh\LaravelStartupHelper\StartupFactory');
    }
}
<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Cache Time
    |--------------------------------------------------------------------------
    |
    | This option specifies the time in minutes to cache API requests.
    | Setting it to 0 will disable caching. 15 minutes might be a good value.
    | Normally, only GET requests are cached, however as a last parameter in
    | requests, you may override this and ask other methods to be cached too.
    | Note that if this value is set to 0, overriding will have no affect
    | because the override will just tell it to follow the GET caching rules.
    | You can also override GET request caching in the same way to disable it.
    |
    | Default: 0
    |
    */

    'cache'  => 0,

);

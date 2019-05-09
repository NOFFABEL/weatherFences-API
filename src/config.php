<?php
    define('DB_HOST', getenv('HOST'));
    define('DB_NAME', getenv('NAME'));
    define('DB_USER', getenv('USER'));
    define('DB_PASS', getenv('PASS'));

    define('TB_ACCOUNT', getenv('DB_TB_ACCOUNT_NAME'));
    define('TB_WEATHER', getenv('DB_TB_WEATHER_NAME'));

?>
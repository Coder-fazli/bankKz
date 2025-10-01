<?php
define( 'DB_NAME',     'bankkz_wp' );
define( 'DB_USER',     'bankkz_user' );
define( 'DB_PASSWORD', 'S3cure!Kz_2025' );
define( 'DB_HOST',     '127.0.0.1' );
define( 'DB_CHARSET',  'utf8mb4' );
define( 'DB_COLLATE',  '' );
/* Authentication Unique Keys and Salts: (inserted below) */
define('AUTH_KEY',         '_0(Qv4fkFFvok21i8k*<OY)nn(wJQ%Kjzra-r-EjPz9|nee$_sE7^I1$u2WP8M~^');
define('SECURE_AUTH_KEY',  '#X=;+z.P}@rm,2op!GJ.2EiKZ*9VM6O@+C^-`?s+ZZ89/+f_wu%V7?O-TpEhv ]+');
define('LOGGED_IN_KEY',    ')a&Nm>K:`.~Y^VSmH=6 a#4u<-1^2cL)}B`XLC|9jzmK=0!9{Hi@+BK.,<vPYa5k');
define('NONCE_KEY',        'U8Lvue|2~zqWol6<f#N]_pW]ZSpxIG^&_HLx3|[y8G^X.8t09.QEcs79sEN?Mqfi');
define('AUTH_SALT',        'Mx|#qHZ-_agqB$ z/ =9bC-[4dmiyLfy[MoXz]lLvO^E]U[}$uF-Et)b@PlszvXQ');
define('SECURE_AUTH_SALT', '{|E%cbaB?DK%%#wr1o|HY+WR]~|_{2pcH/&I2d6B+B`_/.%@8+WHT+X-^&nnCgRV');
define('LOGGED_IN_SALT',   '*x6%UWCuRZJpRJ>C.Y$yocZf^Dre{7T^QRHly%R./vJ8^CJ7EJ>oab(V=ijR_+IY');
define('NONCE_SALT',       'm}K|TC7CRDz*Q5AoDm:NSKVdWy.9}eeFt8t G<=4nv@9$fS%CiN&aJ+yWl|hCYpV');
$table_prefix = 'wp_';
define( 'WP_DEBUG', false );
if ( ! defined( 'ABSPATH' ) ) { define( 'ABSPATH', __DIR__ . '/' ); }
require_once ABSPATH . 'wp-settings.php';

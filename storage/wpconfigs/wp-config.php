<?php
# Created automatically by dg_auto [193.106.56.72] on 12-01-2021 02:13:51 Europe/Kiev

require_once __DIR__ .'/wp-config-extend.php';

define( 'DB_NAME',     'adg_auto_mercedes_benz'  );
define( 'DB_USER',     'au_adg_auto_mercedes_benz'  );
define( 'DB_PASSWORD', 'j81iyogumpto6rwn'  );

define( 'DB_HOST',       '100.21.64.57' );
define( 'DB_HOST_SLAVE', '100.21.64.57' );
define( 'DB_CHARSET', 'utf8'             );
define( 'DB_COLLATE', 'utf8_unicode_ci'  );
$table_prefix = 'wp_';

define( 'AUTH_KEY',         'R0jq1O~~[G||Z{[&a7xaVpR0A@9IdaU&iMad-(#Ey:+U_!6sZ1@%5Ud1@bhl~Dj^' );
define( 'SECURE_AUTH_KEY',  '|ddiuP>m+r25/{{P=>L}*8m+>#=}hD,Hm5M+f$]g*w;/BdY+C~2v(fN+f^ugfrsc' );
define( 'LOGGED_IN_KEY',    '!fe(~i/y7iJX<q4W!R8N~2{DAdB=Z%>D;!Yp-H9;r5p*9WqO}++s>aC`Mkbl2]&#' );
define( 'NONCE_KEY',        'uc$|Pqy@)#HE=a-$aFHV[m2I6,@VUFSk%<G_-+N4E*)vVW- R>}mNrtx=`=||kR4' );
define( 'AUTH_SALT',        'mqy=-*21)e0}c-j07Iv&5~NDOB[8n9phmX|zQM&AO,5c{,dj4k%fY[xitH+m[9g!' );
define( 'SECURE_AUTH_SALT', 'tYW]O+,WnuT^c fb^cx.W2nx=Q-XsF<.:z7n/9Yse_x_rio?syRPp qg1+VuX]nT' );
define( 'LOGGED_IN_SALT',   'm[HBczWsN7FX}P:MC+?WCtweToXizmW|z0>r`n+Ul8cO:hFT]5!18;-G#s4b?M}i' );
define( 'NONCE_SALT',       'IB!{HCBSPm-`4$|bAdG&/fSf-Vd0FYJ=o0kCe=BZ|8#*8<&nOG/5GW#{McGuVV_e' );

define( 'WP_REDIS_PASSWORD', 'r0CO7ki98903m4I' );
define( 'WP_REDIS_SERVERS', [
        'tcp://54.188.129.59:6379?database=1&alias=master',
] );

if ( !defined('ABSPATH') )
        define( 'ABSPATH', dirname(__FILE__) . '/' );


require_once ABSPATH . 'wp-settings.php';
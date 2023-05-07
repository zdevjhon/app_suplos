<?php
date_default_timezone_set('America/Lima');
setlocale(LC_ALL, 'es_ES');
setlocale(LC_NUMERIC, 'C');

define('STATUS_OK', 2);
define('STATUS_FAIL', 1);

// estados de registro
define('ST_ACTIVO', 1);
define('ST_PUBLICADO', 2);
define('ST_EVALUACION', 3);

// MONEDA
define('M_COP', 1);
define('M_USD', 2);
define('M_EUR', 3);
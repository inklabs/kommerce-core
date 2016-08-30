<?php
namespace inklabs\kommerce\Lib;

error_reporting(E_ALL);
date_default_timezone_set('UTC');
ini_set('memory_limit', '256M');

define('FLOAT_DELTA', 0.000001);

function is_uploaded_file($fileName)
{
    return file_exists($fileName);
}

<?php
use Joomla\CMS\Uri\Uri;
$uri = Uri::getInstance();
$url = $uri->toString();

echo $url;
?>
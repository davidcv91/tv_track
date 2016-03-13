<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'main';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['download_episode'] = 'main/download_episode';
$route['edit_field_serie'] = 'main/edit_field_serie';
$route['add_serie'] = 'main/add_serie';
$route['login'] = 'main/login';
$route['following'] = 'main/following';
$route['series'] = 'main/series';
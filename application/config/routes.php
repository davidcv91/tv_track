<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'main';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['download_episode'] = 'main/download_episode';
$route['postpone_episode'] = 'main/postpone_episode';
$route['login'] = 'main/login';
$route['following'] = 'main/following';

$route['change_status'] = 'series/change_status_serie';
$route['add_serie'] = 'series/add_serie';
$route['edit_serie'] = 'series/edit_serie';
$route['delete_serie'] = 'series/delete_serie';
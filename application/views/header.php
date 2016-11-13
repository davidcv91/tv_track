<!DOCTYPE html>
<html lang='es'>

<head>
    <meta charset='UTF-8'>
    <link rel='stylesheet' href='https://code.getmdl.io/1.2.1/material.indigo-red.min.css' />
    <script defer src='https://code.getmdl.io/1.2.1/material.min.js'></script>
    <link rel='stylesheet' href='https://fonts.googleapis.com/icon?family=Material+Icons'>
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' type='text/css'>

    <link href='assets/bootstrap/css/bootstrap.min.css' rel='stylesheet'>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js'></script>
    <script src='assets/bootstrap/js/bootstrap.min.js'></script>

    <title><?php echo 'TV Track - '.$page_title; ?></title>
</head>
<body>
<div class='mdl-layout mdl-js-layout'>
    <header class='mdl-layout__header'>
        <div class='mdl-layout__header-row'>
            <span class='mdl-layout-title'>TV Track</span>
            <nav class='mdl-navigation'>
                <a class='mdl-navigation__link' href='<?php echo base_url().'following'; ?>'>Siguiendo</a>
                <a class='mdl-navigation__link' href='<?php echo base_url().'series'; ?>'>Series</a>
            </nav>
        </div>
    </header>

    <div class='mdl-layout__drawer'>
        <span class='mdl-layout-title'>TV Track</span>
    </div>
    <main class="mdl-layout__content">
        <div class='mdl-grid'>
            <div class='mdl-cell mdl-cell--12-col'>

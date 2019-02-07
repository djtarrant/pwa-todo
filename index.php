<?php
require_once("calendar.class.php");
?>

<!doctype html>
<html class="no-js" lang="">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/main.css">
    </head>

    <body>
        <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->
        <?php 
        $djt_CalendarObject = new djt_Calendar();
        $djt_CalendarObject->showCalendar();
        
        //TODO - scroll calendar < and > for more months
        //TODO - click on a calendar day to see the TODO for the day = all day, general and specific time, ordering
        //TODO - on a calendar day - CRUD TODO - time = all day, general and specific time, ordering (push up/down order), recurring (day, week, month, year)
        // => categories: appointment, todolist, birthday, moon, friends and family, work
        //TODO - calendar page, visual indication of todo on the day - colorised and abbreviated based on category
        //TODO - mobile styling        
        //TODO - PWA caching - how to cache a CRUD action?
        //TODO - auth of some kind, and perhaps logging
        ?>



    </body>

</html>
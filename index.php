<?php
require_once("calendar.class.php");
?>

<!doctype html>
<html class="no-js" lang="">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>TODO</title>
        <meta name="description" content="TODO">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="js/main.js"></script>
        <link rel="apple-touch-icon" sizes="76x76" href="apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
        <link rel="manifest" href="manifest.json">
        <link rel="mask-icon" href="safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#752424">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <link rel="apple-touch-startup-image" href="/apple-touch-icon.png">
        <!-- iOS Splash Screen Images -->
        <link rel="apple-touch-startup-image" href="apple-splash-640.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
        <link rel="apple-touch-startup-image" href="apple-splash-750.png" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
        <link rel="apple-touch-startup-image" href="apple-splash-1242.png" media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
        <link rel="apple-touch-startup-image" href="apple-splash-1125.png" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
        <link rel="apple-touch-startup-image" href="apple-splash-1536.png" media="(min-device-width: 768px) and (max-device-width: 1024px) and (-webkit-min-device-pixel-ratio: 2) and (orientation: portrait)">
        <link rel="apple-touch-startup-image" href="apple-splash-1668.png" media="(min-device-width: 834px) and (max-device-width: 834px) and (-webkit-min-device-pixel-ratio: 2) and (orientation: portrait)">
        <link rel="apple-touch-startup-image" href="apple-splash-2048.png" media="(min-device-width: 1024px) and (max-device-width: 1024px) and (-webkit-min-device-pixel-ratio: 2) and (orientation: portrait)">

        <link rel="stylesheet" href="css/main.css">
    </head>

    <body>
        <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->
        <section id="addToHomeScreen" class = "alertBox">
            <strong>Install App</strong><br/>Add TODO to your home screen?<br/>
            <a href="javascript:void(0)" onClick="hidePrompt()">No,&nbsp;Thanks</a> <button id = "addToHomeScreen" onClick="installApp()">Yes, Please!</button> 
        </section>


        <?php 
        $djt_CalendarObject = new djt_Calendar();
        if( isset($_GET['startMonth']) && preg_match("/^\d+$/", $_GET['startMonth']) ){
            $djt_CalendarObject->startMonth = $_GET['startMonth'];
        }else{
            $djt_CalendarObject->startMonth = date("n");
        }
        if( isset($_GET['startYear']) && preg_match("/^\d+$/", $_GET['startYear']) ){
            $djt_CalendarObject->startYear = $_GET['startYear'];
        }else{
            $djt_CalendarObject->startYear = date("Y");
        }
        if( ($djt_CalendarObject->startMonth-$djt_CalendarObject->numMonths)<=0){
            $previousMonth = ($djt_CalendarObject->startMonth-$djt_CalendarObject->numMonths)+12;
        }else{
            $previousMonth = $djt_CalendarObject->startMonth-$djt_CalendarObject->numMonths;
        }
        if( ($djt_CalendarObject->startMonth+$djt_CalendarObject->numMonths)>12){
            $nextMonth = ($djt_CalendarObject->startMonth+$djt_CalendarObject->numMonths)-12;
        }else{
            $nextMonth = $djt_CalendarObject->startMonth+$djt_CalendarObject->numMonths;
        }
        $djt_CalendarObject->showCalendarLink($previousMonth, $direction = 'backwards');
        $djt_CalendarObject->showCalendar();
        $djt_CalendarObject->showCalendarLink($nextMonth, $direction = 'forward');
        
        //TODO - add lets encrypt certificate to hosting
        //TODO - mobile CSS styling
        //TODO - test PWA
        //TODO - data storage
        //TODO - click on a calendar day to see the TODO for the day = all day, general and specific time, ordering
        //TODO - on a calendar day - CRUD TODO - time = all day, general and specific time, ordering (push up/down order), recurring (day, week, month, year)
        // => categories: appointment, todolist, birthday, moon, friends and family, work
        //TODO - calendar page, visual indication of todo on the day - colorised and abbreviated based on category        
        //TODO - PWA caching - how to cache a CRUD action?
        //TODO - auth of some kind, and perhaps logging
        ?>



    </body>

</html>
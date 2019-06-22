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
        
        //TODO - mobile CSS styling
        //TODO - apply PWA
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
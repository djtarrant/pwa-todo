<?php

class djt_Calendar{

    private $startDay;
    public $startMonth;
    public $startYear;
    private $daysOfWeek;
    private $daysInMonth;
    private $daysInWeek;
    private $calendarInfo = array();
    public $numMonths = 3;

    public function __construct( $startDay = null, $startMonth = null, $startYear = null ){
        
        if( is_null($startDay) ){
            $this->startDay = date("d");
        }else{
            $this->startDay = $startDay;
        }
        if( is_null($startMonth) ){
            $this->startMonth = date("n");
        }else{
            $this->startMonth = $startMonth;
        }
        if( is_null($startYear) ){
            $this->startYear = date("Y");
        }else{
            $this->startYear = $startYear;
        }
        if( !preg_match("/^\d+$/", $this->startDay) || !preg_match("/^\d+$/", $this->startMonth) || !preg_match("/^\d+$/", $this->startYear) ){
            //echo "FALSE";
            return false;
        }

        $this->daysInWeek = array("M","Tu","W","Th","F","Sa","Su");
        $this->daysInMonth = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        if( ($this->startYear % 4) == 0){
            //leap year
            $this->daysInMonth[1] = 29;
        }
    }
    
    
    public function showCalendar($startMonth=null, $startYear=null){

        //controlling function to show a certain month or months
        
        if( preg_match("/^\d+$/",$startMonth) ){
            $this->startMonth = $startMonth;
        }
        if( preg_match("/^\d+$/",$startYear) ){
            $this->startYear = $startYear;
        }
        for($showMonth = 0; $showMonth <= $this->numMonths; $showMonth++){
            if(($this->startMonth+$showMonth)>12){
                $monthToShow = ($this->startMonth+$showMonth)-12;
                $yearToShow =  $this->startYear+1;
            }else{
                $monthToShow = $this->startMonth+$showMonth;
                $yearToShow =  $this->startYear;
            }
            $this->showMonth($monthToShow, $yearToShow);
        }
    }

    public function showCalendarLink($startMonth, $direction = 'forward'){

        //function to show a link to more or previous months
        if( ($this->startMonth-$this->numMonths)<=0){
            $previousYear = $this->startYear-1;
        }else{
            $previousYear = $this->startYear;
        }
        if( ($this->startMonth+$this->numMonths)>12){
            $nextYear = $this->startYear+1;
        }else{
            $nextYear = $this->startYear;
        }
        if( preg_match("/^\d+$/",$startMonth) ){
            if($direction == 'forward'){
                echo '<a href = "?startMonth='.$startMonth.'&startYear='.$nextYear.'">Next Months >></a><br/>';
            }else{
                echo '<a href = "?startMonth='.$startMonth.'&startYear='.$previousYear.'"><< Previous Months</a><br/>';
            }
        }
    }

    

    public function showMonth($month = null, $year = null){
        
        if( is_null($month) ){
            $month = $this->startMonth;
        }
        if( is_null($year) ){
            $year = $this->startYear;
        }
        //set the vars 
        $dayOfMonth = 1; // initialise
        $daysInMonth = $this->daysInMonth[($month)-1]; // get for this month
        $numWeeks = ceil(($this->daysInMonth[($month)-1] + $this->firstDayOfMonth( $month, $year )) / 7);
        $mkmonth = mktime(0, 0, 0, $month, 1, $year);
        $monthText = date("F", $mkmonth);
        
        
        $output = ' <table class = "djt_calendar">
                        <caption>'.$monthText.' '.$year.'</caption>';
        $output .=      '<tr>';
        
                        foreach($this->daysInWeek as $day){
                            $output .= '<th>'.$day.'</th>';
                        }
        $output .=      '</tr>';

                        for($week = 1; $week <=$numWeeks; $week++){
                            $output .= '<tr>';
                            for($dayOfWeek = 1; $dayOfWeek <= count($this->daysInWeek); $dayOfWeek++){
                                // if it's today's date
                                if(date("Y-n-d")==$year.'-'.$month.'-'.$dayOfMonth){
                                    $highlight = 'class = "highlight"';
                                }else{
                                    $highlight = '';
                                }
                                if( $dayOfMonth == 1){
                                    if($dayOfWeek == $this->firstDayOfMonth( $month, $year ) ){
                                        $output .= '<td '.$highlight.'>'.$dayOfMonth.'</td>';
                                        $dayOfMonth++;
                                    }else{
                                        $output .= '<td>&nbsp;</td>';
                                    }
                                }elseif( $dayOfMonth <= $daysInMonth ){
                                    $output .= '<td '.$highlight.'>'.$dayOfMonth.'</td>';
                                    $dayOfMonth++;
                                }else{
                                    $output .= '<td>&nbsp;</td>';
                                }
                            }
                            $output .= '</tr>';
                        }
        
        $output .=  '</table>';
        
        echo $output;
    }

    public function firstDayOfMonth($month = null, $year = null){
        
        if( is_null($month) ){
            return 1;
        }elseif( is_null($year) ){
            $year = $this->startYear;
        }

        $mkFirstDay = mktime(0, 0, 0, $month, 1, $year);
        return date("N",$mkFirstDay);
    }



}
?>

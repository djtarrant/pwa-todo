<?php

class djt_Calendar{

    private $startDay;
    private $startMonth;
    private $startYear;
    private $daysOfWeek;
    private $daysInMonth;
    private $daysInWeek;
    private $calendarInfo = array();

    public function __construct( $startDay = null, $startMonth = null, $startYear = null ){
        
        if( is_null($startDay) ){
            $this->startDay = date("d");
        }else{
            $this->startDay = $startDay;
        }
        if( is_null($startMonth) ){
            $this->startMonth = date("m");
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
    
    
    public function showCalendar($numMonths = 3){

        //controlling function to show a certain month or months
        for($showMonth = 0; $showMonth <= $numMonths; $showMonth++){
            if($this->startMonth+$showMonth>12){
                $monthToShow = $showMonth;
                $yearToShow =  $this->startYear+1;
            }else{
                $monthToShow = $this->startMonth+$showMonth;
                $yearToShow =  $this->startYear;
            }
            $this->showMonth($monthToShow, $yearToShow);
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
                                if( $dayOfMonth == 1){
                                    if($dayOfWeek == $this->firstDayOfMonth( $month, $year ) ){
                                        $output .= '<td>'.$dayOfMonth.'</td>';
                                        $dayOfMonth++;
                                    }else{
                                        $output .= '<td>&nbsp;</td>';
                                    }
                                }elseif( $dayOfMonth <= $daysInMonth ){
                                    $output .= '<td>'.$dayOfMonth.'</td>';
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

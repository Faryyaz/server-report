<?php

namespace App;
use Carbon\Carbon;

class Period {

    private static $instance = null;
    private $dates = [];

    private function __construct()
	{
		// Not necessary, but making this private will block all public instantiations
    }
    
    public static function getInstance()
	{
		if (!self::$instance)
		{
			self::$instance = new self();
        }
        return self::$instance;
	}

    // return of type array
    public function get() : array
    {
        $yesterday = Carbon::yesterday();
        $today = Carbon::now();

        if (!empty($this->dates)) {
            return $this->dates;
        }

        if ($today->isWeekday() && !$this->isPublicHoliday($today->toDateString())) {

            switch ( $today->dayOfWeek ) {
                case Carbon::MONDAY:
                $this->dates = $this->getWeekendAndHolidayDates($today);
                break;

                case Carbon::TUESDAY:
                $this->dates = [
                        $yesterday->format('d/m/Y'),
                        $today->format('d/m/Y')
                    ];

                    if ($this->isPublicHoliday($yesterday)) {
                        $this->dates = $this->getWeekendAndHolidayDates($yesterday);
                    }

                break;

                default:
                $this->dates = [
                        $yesterday->format('d/m/Y'),
                        $today->format('d/m/Y')
                    ];

                    if ($this->isPublicHoliday($yesterday)) {
                        array_unshift($this->dates, $yesterday->subDays(1)->format('d/m/Y')); 
                    }

                break;
            }

        }

        return $this->dates;
    }

    private function getWeekendAndHolidayDates($mondayDate) : array
    {
        $dates = [];
        // $date = Carbon::createFromFormat('Y-m-d H:i:s', $mondayDate);
        $today = Carbon::now();
        $monday = $date->format('d/m/Y');
        $sunday = $date->subDays(1)->format('d/m/Y');
        $saturday = $date->subDays(1)->format('d/m/Y');
        $friday = $date->subDays(1)->format('d/m/Y');
        $thursday = $date->subDays(1)->format('d/m/Y');

        $dates = [
            $friday,
            $saturday,
            $sunday
        ];

        if ($this->isPublicHoliday($friday)) {
            array_unshift($dates, $thursday);
        } 
        if ($this->isPublicHoliday($monday)) {
            array_push($dates, $monday);
        }

        array_push($dates, $today->toDateString());

        return $dates;
    }

    private function isPublicHoliday(string $date) : bool
    {
        // if ( PublicHolidays::where('date', $date->toDateString())->exists() ) {
        //     return true;
        // }
        return false;
    }

    public function countDays() : int
    {
        return (count($this->get()) - 1);
    }
}
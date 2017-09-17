<?php
/**
 * This controller displays the calendars of the leave requests
 * @copyright  Copyright (c) 2014-2017 Benjamin BALET
 * @license      http://opensource.org/licenses/AGPL-3.0 AGPL-3.0
 * @link            https://github.com/bbalet/jorani
 * @since         0.1.0
 */

if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

/**
 * This class displays the calendars of the leave requests.
 * In opposition to the other pages of the application, some calendars can be public (no need to be logged in).
 */
class Alldates extends CI_Controller {

    /**
     * Default constructor
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function __construct() {
        parent::__construct();
        //This controller differs from the others, because some calendars can be public
    }

    public function index($year = NULL)  {
       $year = $year ?  $year: date('Y');
       if(!$this->db->get_where('all_dates',['date_string'=> $year .'-12-31'])->num_rows()){
        $dates = $this->date_range($year .'-01-01', $year .'-12-31');
        $this->db->insert_batch('all_dates',$dates);
        echo 'Dates created';
       }else{
        echo 'Already created for year '.$year ;
       }
    }

    function date_range($first, $last, $step = '+1 day', $output_format = 'Y-m-d' ) {

    $dates = array();
    $current = strtotime($first);
    $last = strtotime($last);

    while( $current <= $last ) {

        $dates[] = ['date_string'=>date($output_format, $current)];
        $current = strtotime($step, $current);
    }

    return $dates;
    }


}

<?php namespace Foostart\Pexcel\Helper;

use Foostart\Pexcel\Helper\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class CourseEnrollParser extends  PexcelParser
{
    public $enrollImport;
    public $item;
    public function __construct($item = null)
    {
        $this->item = $item;
        $this->enrollImport = new EnrollOnlineTdcImport($item);//has param constructor
    }

    public function readData($pexcel) {
        $pexcel_files = json_decode($pexcel->course_enroll_file_path);

        $pexcel_file_path = realpath(base_path('public/' . $pexcel_files[0]));

        Excel::import($this->enrollImport, $pexcel_file_path);
    }
}

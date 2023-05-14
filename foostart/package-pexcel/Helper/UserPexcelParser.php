<?php

namespace Foostart\Pexcel\Helper;

use Foostart\Pexcel\Helper\UsersImport;
use Maatwebsite\Excel\Facades\Excel;


class UserPexcelParser extends  PexcelParser
{
    public $userImport;

    public function __construct()
    {
        $this->userImport = new UserOnlineTdcImport();
    }

    public function readData($pexcel) {
        $pexcel_files = json_decode($pexcel->pexcel_file_path);

        $pexcel_file_path = realpath(base_path('public/' . $pexcel_files[0]));

        Excel::import($this->userImport, $pexcel_file_path);
    }
}

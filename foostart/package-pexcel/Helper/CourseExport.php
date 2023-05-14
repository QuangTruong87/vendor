<?php

namespace Foostart\Pexcel\Helper;

use App\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CourseExport implements FromView {

    public $course;
    public $view;
    public $courseName;
    public $counterUnCompany;
    public function view(): View
    {

        return view($this->view, [
            'items' => $this->course,
            'courseName' => $this->courseName,
            'counterUnCompany' => $this->counterUnCompany
        ]);
    }

}

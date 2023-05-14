<?php
namespace Foostart\Pexcel\Validators;

use Event;
use \LaravelAcl\Library\Validators\AbstractValidator;

use Illuminate\Support\MessageBag as MessageBag;

class PexcelCategoryAdminValidator extends AbstractValidator
{
    protected static $rules = array(
        'pexcel_category_name' => 'required',
    );

    protected static $messages = [];


    public function __construct()
    {
        Event::listen('validating', function($input)
        {
        });
        $this->messages();
    }

    public function validate($input) {

        $flag = parent::validate($input);

        $this->errors = $this->errors?$this->errors:new MessageBag();

        $flag = $this->isValidName($input)?$flag:FALSE;
        return $flag;
    }


    public function messages() {
        self::$messages = [
            'pexcel_category_name.required' => 'Yêu cầu nhập tên danh mục.'
        ];
    }

    public function isValidName($input) {

        $flag = TRUE;

        $min_lenght = config('pexcel.length_category_name_min');
        $max_lenght = config('pexcel.length_category_name_max');

        $pexcel_category_name = @$input['pexcel_category_name'];


        if ((strlen($pexcel_category_name) < $min_lenght)  || ((strlen($pexcel_category_name) > $max_lenght))) {
            $this->errors->add('length_category_name', trans('pexcel::pexcel.length_category_name', ['LENGTH_CATEGORY_NAME_MIN' => $min_lenght, 'LENGTH_CATEGORY_NAME_MAX' => $max_lenght]));
            $flag = FALSE;
        }

        return $flag;
    }
}
<?php namespace Foostart\Pexcel\Validators;

use Foostart\Category\Library\Validators\FooValidator;
use Event;
use \LaravelAcl\Library\Validators\AbstractValidator;
use Foostart\Pexcel\Models\Pexcel;

use Illuminate\Support\MessageBag as MessageBag;

class PexcelValidator extends FooValidator
{

    protected $obj_pexcel;

    public function __construct()
    {
        // add rules
        self::$rules = [
            'pexcel_name' => ["required"],
            'category_id' => ["required"],
        ];

        // set configs
        self::$configs = $this->loadConfigs();

        // model
        $this->obj_pexcel = new Pexcel();

        // language
        $this->lang_front = 'pexcel-front';
        $this->lang_admin = 'pexcel-admin';

        // event listening
        Event::listen('validating', function($input)
        {
            self::$messages = [
                'pexcel_name.required'          => trans($this->lang_admin.'.errors.required', ['attribute' => trans($this->lang_admin.'.fields.name')]),
                'category_id.required'          => trans($this->lang_admin.'.errors.required'),
            ];
        });


    }

    /**
     *
     * @param ARRAY $input is form data
     * @return type
     */
    public function validate($input) {

        $flag = parent::validate($input);
        $this->errors = $this->errors ? $this->errors : new MessageBag();

        //Check length
        $_ln = self::$configs['length'];

        $params = [
            'name' => [
                'key' => 'pexcel_name',
                'label' => trans($this->lang_admin.'.fields.name'),
                'min' => $_ln['pexcel_name']['min'],
                'max' => $_ln['pexcel_name']['max'],
            ],
        ];

        $flag = $this->isValidLength($input['pexcel_name'], $params['name']) ? $flag : FALSE;

        return $flag;
    }


    /**
     * Load configuration
     * @return ARRAY $configs list of configurations
     */
    public function loadConfigs(){

        $configs = config('package-pexcel');
        return $configs;
    }

}

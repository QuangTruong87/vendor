<?php namespace Foostart\English\Validators;

use Foostart\Category\Library\Validators\FooValidator;
use Event;
use \LaravelAcl\Library\Validators\AbstractValidator;
use Foostart\English\Models\WordEnglish;

use Illuminate\Support\MessageBag as MessageBag;

class EnglishValidator extends FooValidator
{

    protected $obj_english;

    public function __construct()
    {
        // add rules
        self::$rules = [
            'english_name' => ["required"],
            'english_overview' => ["required"],
            'english_description' => ["required"],
        ];

        // set configs
        self::$configs = $this->loadConfigs();

        // model
        $this->obj_english = new WordEnglish();

        // language
        $this->lang_front = 'english-front';
        $this->lang_admin = 'english-admin';

        // event listening
        Event::listen('validating', function ($input) {
            self::$messages = [
                'english_name.required' => trans($this->lang_admin . '.errors.required', ['attribute' => trans($this->lang_admin . '.fields.name')]),
                'english_overview.required' => trans($this->lang_admin . '.errors.required', ['attribute' => trans($this->lang_admin . '.fields.overview')]),
                'english_description.required' => trans($this->lang_admin . '.errors.required', ['attribute' => trans($this->lang_admin . '.fields.description')]),
            ];
        });


    }

    /**
     *
     * @param ARRAY $input is form data
     * @return type
     */
    public function validate($input)
    {

        $flag = parent::validate($input);
        $this->errors = $this->errors ? $this->errors : new MessageBag();

        //Check length
        $_ln = self::$configs['length'];

        $params = [
            'name' => [
                'key' => 'english_name',
                'label' => trans($this->lang_admin . '.fields.name'),
                'min' => $_ln['english_name']['min'],
                'max' => $_ln['english_name']['max'],
            ],
            'overview' => [
                'key' => 'english_overview',
                'label' => trans($this->lang_admin . '.fields.overview'),
                'min' => $_ln['english_overview']['min'],
                'max' => $_ln['english_overview']['max'],
            ],
            'description' => [
                'key' => 'english_description',
                'label' => trans($this->lang_admin . '.fields.description'),
                'min' => $_ln['english_description']['min'],
                'max' => $_ln['english_description']['max'],
            ],
        ];

        $flag = $this->isValidLength($input['english_name'], $params['name']) ? $flag : FALSE;
        $flag = $this->isValidLength($input['english_overview'], $params['overview']) ? $flag : FALSE;
        $flag = $this->isValidLength($input['english_description'], $params['description']) ? $flag : FALSE;

        return $flag;
    }


    /**
     * Load configuration
     * @return ARRAY $configs list of configurations
     */
    public function loadConfigs()
    {

        $configs = config('package-english');
        return $configs;
    }

}

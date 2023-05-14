<?php namespace Foostart\Pexcel\Controllers\User;

use Illuminate\Http\Request;
use Foostart\Pexcel\Controllers\Admin\PexcelController;
use URL;
use Route,
    Redirect;
/**
 * Models
 */
use Foostart\Pexcel\Models\Pexcel;
use Foostart\Pnd\Models\Students;
use Foostart\Pexcel\Models\PexcelCategories;
use Foostart\Pexcel\Helper\Parse;
/**
 * Validators
 */
use Foostart\Pexcel\Validators\PexcelAdminValidator;

class PexcelUserController extends PexcelController {

    private $obj_pexcel = NULL;
    private $obj_pexcel_categories = NULL;
    private $obj_validator = NULL;

    public function __construct() {

        $this->obj_pexcel = new Pexcel();
        $this->obj_pexcel_categories = new PexcelCategories();
    }

    /**
     *
     * @return type
     */
    public function index(Request $request) {

        $this->isAuthentication();

        $params = $request->all();


        $params['user_name'] = $this->current_user->user_name;
        $params['user_id'] = $this->current_user->id;

        /**
         * EXPORT
         */
        if (isset($params['export'])) {
            $pexcels = $this->obj_pexcel->get_pexcels($params);
            $obj_parse = new Parse();
            $obj_parse->export_data($pexcels, 'pexcels');

            unset($params['export']);
        }
        ////////////////////////////////////////////////////////////////////////

        $pexcels = $this->obj_pexcel->get_pexcels($params);

        $this->data = array_merge($this->data, array(
            'pexcels' => $pexcels,
            'request' => $request,
            'params' => $params
        ));
        return view('pexcel::admin.pexcel_list', $this->data);
    }

    /**
     *
     * @return type
     */
    public function edit(Request $request) {

        $this->isAuthentication();

        if ($this->current_user) {
            $pexcel = NULL;
            $pexcel_id = (int) $request->get('id');


            if (!empty($pexcel_id) && (is_int($pexcel_id))) {
                $pexcel = $this->obj_pexcel->find($pexcel_id);
            }

            if ($this->is_admin || $this->is_all || $this->is_my || ($pexcel->user_id == $this->current_user->id)) {
                $this->data = array_merge($this->data, array(
                    'pexcel' => $pexcel,
                    'request' => $request,
                    'categories' => $this->obj_pexcel_categories->pluckSelect()->toArray(),
                ));
                return view('pexcel::admin.pexcel_edit', $this->data);
            }
        }
    }

    /**
     *
     * @param Request $request
     * @return type
     */
    public function post(Request $request) {

        $this->isAuthentication();

        $this->obj_validator = new PexcelAdminValidator();

        $input = $request->all();

        $input['user_id'] = $this->current_user->id;

        $pexcel_id = (int) $request->get('id');

        $pexcel = NULL;

        $data = array();

        if (!$this->obj_validator->adminValidate($input)) {

            $data['errors'] = $this->obj_validator->getErrors();

            if (!empty($pexcel_id) && is_int($pexcel_id)) {
                $pexcel = $this->obj_pexcel->find($pexcel_id);
            }
        } else {

            if (!empty($pexcel_id) && is_int($pexcel_id)) {

                $pexcel = $this->obj_pexcel->find($pexcel_id);

                if (!empty($pexcel)) {

                    $input['pexcel_id'] = $pexcel_id;
                    $pexcel = $this->obj_pexcel->update_pexcel($input);

                    //Message
                    $this->addFlashMessage('message', trans('pexcel::pexcel.message_update_successfully'));

                    return Redirect::route("admin_pexcel.parse", ["id" => $pexcel->pexcel_id]);
                } else {

                    //Message
                    $this->addFlashMessage('message', trans('pexcel::pexcel.message_update_unsuccessfully'));
                }
            } else {

                $input = array_merge($input, array(
                ));

                $pexcel = $this->obj_pexcel->add_pexcel($input);

                if (!empty($pexcel)) {

                    //Message
                    $this->addFlashMessage('message', trans('pexcel::pexcel.message_add_successfully'));

                    return Redirect::route("admin_pexcel.parse", ["id" => $pexcel->pexcel_id]);
                    //return Redirect::route("admin_pexcel.edit", ["id" => $pexcel->pexcel_id]);
                } else {

                    //Message
                    $this->addFlashMessage('message', trans('pexcel::pexcel.message_add_unsuccessfully'));
                }
            }
        }

        $this->data = array_merge($this->data, array(
            'pexcel' => $pexcel,
            'request' => $request,
                ), $data);

        return view('pexcel::admin.pexcel_edit', $this->data);
    }

    /**
     *
     * @return type
     */
    public function delete(Request $request) {

        $this->isAuthentication();


        $pexcel = NULL;
        $pexcel_id = $request->get('id');


        if (!empty($pexcel_id)) {

            $pexcel = $this->obj_pexcel->find($pexcel_id);

            if (!empty($pexcel)) {
                //Message
                $this->addFlashMessage('message', trans('pexcel::pexcel.message_delete_successfully'));

                if ($this->is_admin || $this->is_all || ($pexcel->user_id == $this->current_user->id)) {

                    $obj_student = new Students();

                    $obj_student->deleteStudentsByPexcelId($pexcel->pexcel_id);

                    $pexcel->delete();
                }
            }
        } else {

        }

        $this->data = array_merge($this->data, array(
            'pexcel' => $pexcel,
        ));

        return Redirect::route("admin_pexcel");
    }

    public function parse(Request $request) {
        $obj_parse = new Parse();
        $obj_students = new Students();

        $input = $request->all();

        $pexcel_id = $request->get('id');

        $pexcel = $this->obj_pexcel->find($pexcel_id);

        $pexcel_category = $this->obj_pexcel_categories->find($pexcel->pexcel_category_id);

        $pexcel->pexcel_category_name = $pexcel_category->pexcel_category_name;

        $students = $obj_parse->read_data($pexcel);

        $pexcel->pexcel_value = json_encode($students);
        unset($pexcel->pexcel_category_name);
        $pexcel->save();

        $config = config('pexcel.status_str');

        /**
         * Import data
         */
        $this->data = array_merge($this->data, array(
            'students' => $students,
            'request' => $request,
            'pexcel' => $pexcel,
            'config' => $config,
        ));

        return view('pexcel::admin.pexcel_parse', $this->data);
    }

}

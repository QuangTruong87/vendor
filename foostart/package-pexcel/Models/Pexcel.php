<?php

namespace Foostart\Pexcel\Models;

use Foostart\Category\Library\Models\FooModel;
use Illuminate\Database\Eloquent\Model;

class Pexcel extends FooModel {

    /**
     * @table categories
     * @param array $attributes
     */
    public function __construct(array $attributes = array()) {
        //set configurations
        $this->setConfigs();

        parent::__construct($attributes);
    }

    public function setConfigs() {

        //table name
        $this->table = 'pexcels';

        //list of field in table
        $this->fillable = array_merge($this->fillable, [
            'pexcel_name',
            'pexcel_range_data',
            'pexcel_description',
            'pexcel_file_path',
            //Relation
            'category_id'
        ]);

        //list of fields for inserting
        $this->fields = array_merge($this->fields, [
            'pexcel_name' => [
                'name' => 'pexcel_name',
                'type' => 'Text',
            ],
            'pexcel_range_data' => [
                'name' => 'range_data',
                'type' => 'Text',
            ],
            'pexcel_description' => [
                'name' => 'pexcel_description',
                'type' => 'Text',
            ],
            'pexcel_file_path' => [
                'name' => 'files',
                'type' => 'Json',
            ],
            //Relation
            'category_id' => [
                'name' => 'category_id',
                'type' => 'Int',
            ],
        ]);

        //check valid fields for inserting
        $this->valid_insert_fields = array_merge($this->valid_insert_fields, [
            'pexcel_name',
            'pexcel_range_data',
            'pexcel_description',
            'pexcel_file_path',
            //Relation
            'user_id',
            'category_id',
        ]);

        //check valid fields for ordering
        $this->valid_ordering_fields = [
            'pexcel_name',
            'updated_at',
            'id',
            $this->field_status,
        ];
        //check valid fields for filter
        $this->valid_filter_fields = [
            'keyword',
            'status',
        ];

        //primary key
        $this->primaryKey = 'pexcel_id';

    }

    /**
     * Gest list of items
     * @param type $params
     * @return object list of categories
     */
    public function selectItems($params = array()) {

        //join to another tables
        $elo = $this->joinTable();

        //search filters
        $elo = $this->searchFilters($params, $elo);

        //select fields
        $elo = $this->createSelect($elo);

        //order filters
        $elo = $this->orderingFilters($params, $elo);

        //paginate items
        $items = $this->paginateItems($params, $elo);

        return $items;
    }

    /**
     * Get a pexcel by {id}
     * @param ARRAY $params list of parameters
     * @return OBJECT pexcel
     */
    public function selectItem($params = array(), $key = NULL) {


        if (empty($key)) {
            $key = $this->primaryKey;
        }
        //join to another tables
        $elo = $this->joinTable();

        //search filters
        $elo = $this->searchFilters($params, $elo, FALSE);

        //select fields
        $elo = $this->createSelect($elo);

        //id
        $elo = $elo->where($this->primaryKey, $params['id']);

        //first item
        $item = $elo->first();

        return $item;
    }

    /**
     *
     * @param ARRAY $params list of parameters
     * @return ELOQUENT OBJECT
     */
    protected function joinTable(array $params = []) {
        return $this;
    }

    /**
     *
     * @param ARRAY $params list of parameters
     * @return ELOQUENT OBJECT
     */
    protected function searchFilters(array $params, $elo, $by_status = TRUE) {

        //filter
        if ($this->isValidFilters($params) && (!empty($params))) {
            foreach ($params as $column => $value) {
                if ($this->isValidValue($value)) {
                    switch ($column) {
                        case 'pexcel_name':
                            if (!empty($value)) {
                                $elo = $elo->where($this->table . '.pexcel_name', '=', $value);
                            }
                            break;
                        case 'status':
                            if (!empty($value)) {
                                $elo = $elo->where($this->table . '.' . $this->field_status, '=', $value);
                            }
                            break;
                        case 'keyword':
                            if (!empty($value)) {
                                $elo = $elo->where(function($elo) use ($value) {
                                    $elo->where($this->table . '.pexcel_name', 'LIKE', "%{$value}%")
                                            ->orWhere($this->table . '.pexcel_description', 'LIKE', "%{$value}%");
                                });
                            }
                            break;
                        default:
                            break;
                    }
                }
            }
        }

        return $elo;
    }

    /**
     * Select list of columns in table
     * @param ELOQUENT OBJECT
     * @return ELOQUENT OBJECT
     */
    public function createSelect($elo) {

        $elo = $elo->select($this->table . '.*', $this->table . '.pexcel_id as id'
        );

        return $elo;
    }

    /**
     *
     * @param ARRAY $params list of parameters
     * @return ELOQUENT OBJECT
     */
    public function paginateItems(array $params, $elo) {
        $items = $elo->paginate($this->perPage);

        return $items;
    }

    /**
     *
     * @param ARRAY $params list of parameters
     * @param INT $id is primary key
     * @return type
     */
    public function updateItem($params = [], $id = NULL) {

        if (empty($id)) {
            $id = $params['id'];
        }
        $field_status = $this->field_status;
        // Get item by id
        $_params['id'] = $id;
        if (!empty($params['id']) && empty($_params['id'])) {
            $_params['id'] = $params['id'];
        }
        $pexcel = $this->selectItem($_params);

        if (!empty($pexcel)) {
            $dataFields = $this->getDataFields($params, $this->fields);

            foreach ($dataFields as $key => $value) {
                $pexcel->$key = $value;
            }

            //$pexcel->$field_status = $this->status['publish'];

            $pexcel->save();

            return $pexcel;
        } else {
            return NULL;
        }
    }

    /**
     *
     * @param ARRAY $params list of parameters
     * @return OBJECT pexcel
     */
    public function insertItem($params = []) {

        $dataFields = $this->getDataFields($params, $this->fields);

        //$dataFields[$this->field_status] = $this->status['publish'];


        $item = self::create($dataFields);

        $key = $this->primaryKey;
        $item->id = $item->$key;

        return $item;
    }

    /**
     *
     * @param ARRAY $input list of parameters
     * @return boolean TRUE incase delete successfully otherwise return FALSE
     */
    public function deleteItem(array $input, $delete_type) {

        $item = $this->find($input['id']);

        if ($item) {
            switch ($delete_type) {
                case 'delete-trash':
                    return $item->fdelete($item);
                    break;
                case 'delete-forever':
                    return $item->delete();
                    break;
            }
        }

        return FALSE;
    }

    /**
     *
     * Get list of statuses to push to select
     * @return ARRAY list of statuses
     */

     public function getPluckStatus() {
            $pluck_status = config('package-pexcel.status.list');
            return $pluck_status;
     }

    /**
     *
     * @param ARRAY $input list of parameters
     * @return boolean TRUE incase restore successfully otherwise return FALSE
     */
    public function restoreItem(array $input) {

        $item = $this->withTrashed()->find($input['id']);

        if ($item) {
            $item->restore();
        }

        return FALSE;
    }
}

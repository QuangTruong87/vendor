<?php namespace Foostart\English\Models;

use Foostart\Category\Library\Models\FooModel;

use Foostart\Comment\Models\Comment;

class WordEnglish extends FooModel
{

    /**
     * @table categories
     * @param array $attributes
     */
    public $user = NULL;
    const VAL_TRUE = 1;
    const VAL_FALSE = 0;

    public function __construct(array $attributes = array())
    {
        //set configurations
        $this->setConfigs();

        parent::__construct($attributes);

    }

    public function setConfigs()
    {

        //table name
        $this->table = 'word_english';

        //list of field in table
        $this->fillable = array_merge($this->fillable, [
            'word',
            'noun',
            'verb',
            'adjective',
            'adverb',
            'pronoun',
            'preposition',
            'conjunction',
            'interjection',
            'phonetic',
            'phonetics',
            'meanings',
        ]);

        //list of fields for inserting
        $this->fields = array_merge($this->fields, [
            'word' => [
                'name' => 'word',
                'type' => 'Text',
            ],
            'noun' => [
                'name' => 'noun',
                'type' => 'Int',
            ],
            'verb' => [
                'name' => 'verb',
                'type' => 'Int',
            ],
            'adjective' => [
                'name' => 'adjective',
                'type' => 'Int',
            ],
            'adverb' => [
                'name' => 'adverb',
                'type' => 'Int',
            ],
            'pronound' => [
                'name' => 'pronound',
                'type' => 'Int',
            ],
            'preposition' => [
                'name' => 'preposition',
                'type' => 'Int',
            ],
            'conjunction' => [
                'name' => 'conjunction',
                'type' => 'Int',
            ],
            'interjection' => [
                'name' => 'interjection',
                'type' => 'Int',
            ],
            'phonetic' => [
                'name' => 'phonetic',
                'type' => 'Json',
            ],
            'phonetics' => [
                'name' => 'phonetics',
                'type' => 'Json',
            ],
            'meanings' => [
                'name' => 'meanings',
                'type' => 'Json',
            ],
        ]);

        //check valid fields for inserting
        $this->valid_insert_fields = array_merge($this->valid_insert_fields, [
            'word',
            'noun',
            'verb',
            'adjective',
            'adverb',
            'pronoun',
            'preposition',
            'conjunction',
            'interjection',
            'phonetic',
            'phonetics',
            'meanings',
        ]);

        //check valid fields for ordering
        $this->valid_ordering_fields = [
            'word',
            'noun',
            'verb',
            'adjective',
            'adverb',
            'pronoun',
            'preposition',
            'conjunction',
            'interjection',
            'phonetic',
            'phonetics',
            'meanings',
            $this->field_status,
        ];
        //check valid fields for filter
        $this->valid_filter_fields = [
            'word',
            'noun',
            'verb',
            'adjective',
            'adverb',
            'pronoun',
            'preposition',
            'conjunction',
            'interjection',
            'phonetic',
            'phonetics',
            'meanings',
        ];

        //primary key
        $this->primaryKey = 'word_id';

    }

    /**
     * Gest list of items
     * @param type $params
     * @return object list of categories
     */
    public function selectItems($params = array())
    {

        //join to another tables
        $elo = $this->joinTable();

        //search filters
        $elo = $this->searchFilters($params, $elo);

        //select fields
        $elo = $this->createSelect($elo);

        //order filters
        $elo = $this->orderingFilters($params, $elo);

        //paginate items
        if ($this->is_pagination) {
            $items = $this->paginateItems($params, $elo);
        } else {
            $items = $elo->get();
        }

        return $items;
    }

    /**
     * Get a english by {id}
     * @param ARRAY $params list of parameters
     * @return OBJECT english
     */
    public function selectItem($params = array(), $key = NULL)
    {


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
        if (!empty($params['id'])) {
            $elo = $elo->where($this->primaryKey, $params['id']);
        }

        //first item
        $item = $elo->first();

        return $item;
    }


    public function getComments($english_id)
    {

        // Get english
        $params = array(
            'id' => $english_id,
        );
        $english = $this->selectItem($params);

        // Get comment by context
        $params = array(
            'context_name' => 'english',
            'context_id' => $english_id,
            'by_status' => true,
        );
        $obj_comment = new Comment();
        $obj_comment->user = $this->user;
        $comments = $obj_comment->selectItems($params);

        $users_comments = $obj_comment->mapCommentArray($comments);
        $english->cache_comments = json_encode($users_comments);
        $english->cache_time = time();
        $english->save();

        return $users_comments;
    }

    /**
     *
     * @param ARRAY $params list of parameters
     * @return ELOQUENT OBJECT
     */
    protected function joinTable(array $params = [])
    {
        return $this;
    }

    /**
     *
     * @param ARRAY $params list of parameters
     * @return ELOQUENT OBJECT
     */
    protected function searchFilters(array $params, $elo, $by_status = TRUE)
    {

        //filter
        if ($this->isValidFilters($params) && (!empty($params))) {
            foreach ($params as $column => $value) {
                if ($this->isValidValue($value)) {
                    switch ($column) {
                        case 'category_id':
                            if (!empty($value)) {
                                $elo = $elo->where($this->table . '.category_id', '=', $value);
                            }
                            break;
                        case 'category':
                            if (!empty($value)) {
                                $elo = $elo->where($this->table . '.category_id', '=', $value);
                            }
                            break;
                        case 'user_id':
                            if (!empty($value)) {
                                $elo = $elo->where($this->table . '.user_id', '=', $value);
                            }
                            break;
                        case 'limit':
                            if (!empty($value)) {
                                $this->perPage = $value;
                                $elo = $elo->limit($value);
                            }
                            break;
                        case '_id':
                            if (!empty($value)) {
                                $elo = $elo->where($this->table . '.english_id', '!=', $value);
                            }
                            break;
                        case 'status':
                            if (!empty($value)) {
                                $elo = $elo->where($this->table . '.' . $this->field_status, '=', $value);
                            }
                            break;
                        case 'keyword':
                            if (!empty($value)) {
                                $elo = $elo->where(function ($elo) use ($value) {
                                    $elo->where($this->table . '.english_name', 'LIKE', "%{$value}%")
                                        ->orWhere($this->table . '.english_description', 'LIKE', "%{$value}%")
                                        ->orWhere($this->table . '.english_overview', 'LIKE', "%{$value}%");
                                });
                            }
                            break;
                        default:
                            break;
                    }
                }
            }
        } elseif ($by_status) {

            $elo = $elo->where($this->table . '.' . $this->field_status, '=', $this->config_status['publish']);

        }

        return $elo;
    }

    /**
     * Select list of columns in table
     * @param ELOQUENT OBJECT
     * @return ELOQUENT OBJECT
     */
    public function createSelect($elo)
    {

        $elo = $elo->select($this->table . '.*',
            $this->table . '.english_id as id'
        );

        return $elo;
    }

    /**
     *
     * @param ARRAY $params list of parameters
     * @return ELOQUENT OBJECT
     */
    public function paginateItems(array $params, $elo)
    {
        $items = $elo->paginate($this->perPage);

        return $items;
    }

    /**
     *
     * @param ARRAY $params list of parameters
     * @param INT $id is primary key
     * @return type
     */
    public function updateItem($params = [], $id = NULL)
    {

        if (empty($id)) {
            $id = $params['id'];
        }
        $field_status = $this->field_status;

        //get english item by conditions
        $_params = [
            'id' => $id,
        ];
        $english = $this->selectItem($_params);

        if (!empty($english)) {
            $dataFields = $this->getDataFields($params, $this->fields);

            foreach ($dataFields as $key => $value) {
                $english->$key = $value;
            }

            $english->save();

            return $english;
        } else {
            return NULL;
        }
    }


    /**
     *
     * @param ARRAY $params list of parameters
     * @return OBJECT english
     */
    public function insertItem($params = [])
    {

        $dataFields = $this->getDataFields($params, $this->fields);

        $dataFields[$this->field_status] = $this->config_status['publish'];


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
    public function deleteItem(?array $input, $delete_type)
    {

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

    public function getCoursesByCategoriesRoot($categories)
    {

        $this->is_pagination = false;

        if (!empty($categories)) {

            //get courses of category root
            $_params = [
                'limit' => 9,
                'category' => $categories->category_id,
                'is_pagination' => false
            ];
            $categories->courses = $this->selectItems($_params);

            //get courses of category childs
            foreach ($categories->childs as $key => $category) {
                $ids = [$category->category_id => 1];
                if (!empty($category->category_id_child_str)) {
                    $ids += (array)json_decode($category->category_id_child_str);;
                }
                $ids = array_keys($ids);

                //error
                $_temp = $categories->childs[$key];
                $_temp->courses = $this->getCouresByCategoryIds($ids);
            }


        }
        return $categories;
    }

    public function getCouresByCategoryIds($ids)
    {
        $courses = self::whereIn('category_id', $ids)
            ->paginate($this->perPage);
        return $courses;
    }


    public function getItemsByCategories($categories)
    {

        $items = [];
        $ids = [];

        foreach ($categories as $category) {
            $ids += [$category->category_id => 1];

            if (!empty($category->category_id_child_str)) {
                $ids += (array)json_decode($category->category_id_child_str);
            }
        }

        //Get list of items by ids
        $items = $this->getCouresByCategoryIds(array_keys($ids));

        return $items;
    }

}

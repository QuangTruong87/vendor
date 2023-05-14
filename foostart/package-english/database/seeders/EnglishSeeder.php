<?php namespace Database\Seeders;

use Foostart\Acl\Library\Constants\FoostartConstants;
use Foostart\Category\Helpers\FoostartSeeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Foostart\English\Models\English;
use Illuminate\Support\Str;


class EnglishSeeder extends FoostartSeeder
{
    private $obj_pexcel;
    private $pathResource;

    public function __construct() {
        // Table name
        $this->table = 'word_english';
        // Prefix column
        $this->prefix_column = 'word_';
        // Word object
        $this->obj_word = new English();

    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Truncate table
        DB:: table($this->table)->truncate();

        //Insert from full resource
        $this->pathResource = base_path('/vendor/foostart/package-english/database/dictionaries');

//        $this->installMainResource();

        //$this->extendResource1();
    }

    private function installMainResource() {
        $resource = '107-500-English (USA).dic';
        $handle = fopen($this->pathResource . '/' . $resource, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                //Create sample data
                try {
                    DB::table($this->table)->insert([
                        'word' => trim(Str::lower($line)),
                        'status' => 99,
                        'created_user_id' => 1,
                        'updated_user_id' => 1,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);
                }catch (\Throwable $e) {
                    //Duplicate word
                }

            }

            fclose($handle);
        } else {
            // error opening the file.
        }
    }

    /**
     * Extend dictionary
     */
    private function extendResource1() {
        $resource = '3731-wordDictionary.txt';
        $handle = fopen($this->pathResource . '/' . $resource, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {

                $items = explode('|', $line);

                try {
                    DB::table($this->table)->insert([
                        'word' => trim(Str::lower($line)),
                        'status' => 99,
                        'created_user_id' => 1,
                        'updated_user_id' => 1,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);
                }catch (\Throwable $e) {
                    //Duplicate word
                }

            }

            fclose($handle);
        } else {
            // error opening the file.
        }
    }
}

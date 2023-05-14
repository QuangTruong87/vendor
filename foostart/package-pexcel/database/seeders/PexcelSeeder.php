<?php namespace Database\Seeders;

use Foostart\Acl\Library\Constants\FoostartConstants;
use Foostart\Category\Helpers\FoostartSeeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Foostart\Pexcel\Models\Pexcel;


class PexcelSeeder extends FoostartSeeder
{
    private $obj_pexcel;

    public function __construct() {
        // Table name
        $this->table = 'pexcels';
        // Prefix column
        $this->prefix_column = 'pexcel_';
        // Pexcel object
        $this->obj_pexcel = new Pexcel();

    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create sample data
        DB::table('contexts')->insert([
            $this->prefix_context . 'name' => 'Admin pexcels',
            $this->prefix_context . 'key' => 'abee417e2dddc5240b586d455',
            $this->prefix_context . 'ref' => 'admin/pexcels',
            'status' => 99,
            'created_user_id' => 1,
            'updated_user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        $this->createSampleData();
    }

    /**
     * Create sample data for testing
     */
    private function createSampleData() {
        $isCreateSampleData =  env('DB_SAMPLE_TEST', FoostartConstants::IS_CREATE_SAMPLE_DATA);
        if ($isCreateSampleData == FoostartConstants::IS_CREATE_SAMPLE_DATA) {

            /**
             * crawler_sites
             */
            for($i = 0; $i < FoostartConstants::SAMPLE_DATA_SIZE; $i++) {
                $pexcel = [
                    $this->prefix_column . 'name' => "name_".$i,
                    'category_id' => $i,
                    $this->prefix_column . 'range_data' => "C10:F100",
                    $this->prefix_column . 'value' => json_encode(['i' => $i]),
                    $this->prefix_column . 'file_path' => '/files/1/1-pexcels/thong-ke-viec-lam.xls',
                    $this->prefix_column . 'description' => 'Description ' . $i,
                ];
                $this->obj_pexcel->create($pexcel);

            }
        }
    }
}

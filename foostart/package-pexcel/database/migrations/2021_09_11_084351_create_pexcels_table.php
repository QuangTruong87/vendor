<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Foostart\Category\Helpers\FoostartMigration;

class CreatePexcelsTable extends FoostartMigration
{
    public function __construct() {
        $this->table = 'pexcels';
        $this->prefix_column = 'pexcel_';
    }
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists($this->table);
        Schema::create($this->table, function (Blueprint $table) {

            $table->increments($this->prefix_column . 'id')->comment('Primary key');

            // Relation
            $table->integer('category_id')->comment('Category ID');

            // Other attributes
            $table->string($this->prefix_column . 'name', 255)->comment('Name');
            $table->string($this->prefix_column . 'range_data', 25)->nullable()->comment('Range data');
            $table->text($this->prefix_column . 'value')->nullable()->comment('Json value');
            $table->string($this->prefix_column . 'file_path', 255)->comment('File path');
            $table->text($this->prefix_column . 'description')->nullable()->comment('Description');

            //Set common columns
            $this->setCommonColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}

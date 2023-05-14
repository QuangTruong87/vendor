<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Foostart\Category\Helpers\FoostartMigration;

class CreateWordEnglishTable extends FoostartMigration
{
    public function __construct()
    {
        $this->table = 'word_english';
        $this->prefix_column = 'word_';
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

            // Word
            $table->string('word', 255)->unique()->comment('English word');

            // Parts of speech
            $table->boolean('noun')->nullable()->comment('Noun');
            $table->boolean('verb')->nullable()->comment('Verb');
            $table->boolean('adjective')->nullable()->comment('Adjective');
            $table->boolean('adverb')->nullable()->comment('Adverb');
            $table->boolean('pronoun')->nullable()->comment('Pronoun');
            $table->boolean('preposition')->nullable()->comment('Preposition');
            $table->boolean('conjunction')->nullable()->comment('Conjunction');
            $table->boolean('interjection')->nullable()->comment('Interjection');

            // Info
            $table->string( 'phonetic', 55)->nullable()->comment('phonetic');
            $table->text('json_phonetics')->nullable()->comment('text, audio');
            $table->text( 'json_meanings_en')->nullable()->comment('partOfSpeech, definitions(definition,example,synonyms,antonyms)');
            $table->text( 'json_meanings_vn')->nullable()->comment('partOfSpeech, definitions(definition,example,synonyms,antonyms)');
            $table->text( 'json_syllables')->nullable()->comment('count, list()');
            $table->float( 'frequency')->nullable()->comment('Frequency');
            $table->text( 'json_source')->nullable()->comment('Dictionaries source');

            //Status
            $table->boolean('is_conflicted')->nullable()->comment('Conflicted with multiple resources');
            $table->boolean('is_valid')->nullable()->comment('Check word is valid');
            $table->boolean('is_alpha')->nullable()->comment('Is only alpha words');

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

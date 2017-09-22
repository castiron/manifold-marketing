<?php namespace Castiron\Forms\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCastironFormsConfig extends Migration
{
    public function up()
    {
        Schema::create('castiron_forms_config', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('email');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('castiron_forms_config');
    }
}

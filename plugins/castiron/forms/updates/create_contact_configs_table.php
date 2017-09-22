<?php namespace Castiron\Forms\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateContactConfigsTable extends Migration
{
    public function up()
    {
        Schema::create('castiron_forms_contact_configs', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('castiron_forms_contact_configs');
    }
}

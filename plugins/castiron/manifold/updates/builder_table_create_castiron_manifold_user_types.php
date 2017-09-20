<?php namespace Castiron\Manifold\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCastironManifoldUserTypes extends Migration
{
    public function up()
    {
        Schema::create('castiron_manifold_user_types', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name', 255);
            $table->string('icon', 255);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('castiron_manifold_user_types');
    }
}

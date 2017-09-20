<?php namespace Castiron\Manifold\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCastironManifoldFeatures extends Migration
{
    public function up()
    {
        Schema::create('castiron_manifold_features', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name', 255);
            $table->text('description');
            $table->integer('feature_category_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('castiron_manifold_features');
    }
}

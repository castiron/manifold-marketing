<?php namespace Castiron\Manifold\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCastironManifoldFeatureCategories extends Migration
{
    public function up()
    {
        Schema::create('castiron_manifold_feature_categories', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name', 255);
            $table->text('description');
            $table->string('icon', 255);
            $table->integer('user_type_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('castiron_manifold_feature_categories');
    }
}

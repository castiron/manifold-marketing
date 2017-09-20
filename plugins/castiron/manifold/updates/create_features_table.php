<?php namespace Castiron\Manifold\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateFeaturesTable extends Migration
{
    public function up()
    {
        Schema::create('castiron_manifold_features', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('castiron_manifold_features');
    }
}

<?php namespace Castiron\Manifold\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCastironManifoldFeatures3 extends Migration
{
    public function up()
    {
        Schema::table('castiron_manifold_features', function($table)
        {
            $table->renameColumn('feature_category', 'feature_category_id');
        });
    }
    
    public function down()
    {
        Schema::table('castiron_manifold_features', function($table)
        {
            $table->renameColumn('feature_category_id', 'feature_category');
        });
    }
}

<?php namespace Castiron\Manifold\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCastironManifoldFeatureCategories3 extends Migration
{
    public function up()
    {
        Schema::table('castiron_manifold_feature_categories', function($table)
        {
            $table->renameColumn('user_type', 'user_type_id');
        });
    }
    
    public function down()
    {
        Schema::table('castiron_manifold_feature_categories', function($table)
        {
            $table->renameColumn('user_type_id', 'user_type');
        });
    }
}

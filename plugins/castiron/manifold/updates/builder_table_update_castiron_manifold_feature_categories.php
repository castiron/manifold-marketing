<?php namespace Castiron\Manifold\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCastironManifoldFeatureCategories extends Migration
{
    public function up()
    {
        Schema::table('castiron_manifold_feature_categories', function($table)
        {
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('castiron_manifold_feature_categories', function($table)
        {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });
    }
}

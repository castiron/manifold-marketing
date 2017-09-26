<?php namespace Castiron\Manifold\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCastironManifoldUserTypes2 extends Migration
{
    public function up()
    {
        Schema::table('castiron_manifold_user_types', function($table)
        {
            $table->text('description');
        });
    }
    
    public function down()
    {
        Schema::table('castiron_manifold_user_types', function($table)
        {
            $table->dropColumn('description');
        });
    }
}

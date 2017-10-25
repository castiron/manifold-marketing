<?php namespace Castiron\Contentment\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCastironContentmentPages3 extends Migration
{
    public function up()
    {
        Schema::table('castiron_contentment_pages', function($table)
        {
            $table->text('data')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('castiron_contentment_pages', function($table)
        {
            $table->dropColumn('data');
        });
    }
}

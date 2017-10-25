<?php namespace Castiron\Contentment\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCastironContentmentPages2 extends Migration
{
    public function up()
    {
        Schema::table('castiron_contentment_pages', function($table)
        {
            $table->string('simple_page_type', 255)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('castiron_contentment_pages', function($table)
        {
            $table->dropColumn('simple_page_type');
        });
    }
}

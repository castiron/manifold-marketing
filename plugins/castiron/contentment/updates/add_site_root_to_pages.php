<?php namespace Castiron\Contentment\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddSiteRootToPages extends Migration
{
    public function up()
    {
        Schema::table('castiron_contentment_pages', function($table)
        {
            $table->boolean('site_root')->nullable();
        });
    }

    public function down()
    {
        Schema::table('castiron_contentment_pages', function($table)
        {
            $table->dropColumn('site_root');
        });
    }
}

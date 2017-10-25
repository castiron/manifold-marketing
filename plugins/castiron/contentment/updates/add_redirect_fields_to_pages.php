<?php namespace Castiron\Contentment\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddRedirectFieldsToPages extends Migration
{

    public function up()
    {
        Schema::table('castiron_contentment_pages', function($table)
        {
            $table->string('redirect_url')->nullable();
            $table->integer('type');
        });
    }

    public function down()
    {
        Schema::table('castiron_contentment_pages', function($table)
        {
            $table->dropColumn('redirect_url');
            $table->dropColumn('type');
        });
    }
}

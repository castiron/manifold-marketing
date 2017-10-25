<?php namespace Castiron\Contentment\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class PagesReferenceFieldIsUnique extends Migration
{

    public function up()
    {
        Schema::table('castiron_contentment_pages', function($table)
        {
            $table->unique('reference');
        });
    }

    public function down()
    {
        Schema::table('castiron_contentment_pages', function($table)
        {
            $table->dropUnique('reference');
        });
    }
}

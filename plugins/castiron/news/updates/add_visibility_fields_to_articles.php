<?php namespace Castiron\News\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddVisibilityFieldsToArticles extends Migration
{
    public function up()
    {
        Schema::table('castiron_news_articles', function($table)
        {
            $table->boolean('is_hidden')->nullable();
            $table->timestamp('startdate')->nullable();
            $table->timestamp('enddate')->nullable();

        });
    }

    public function down()
    {
        Schema::table('castiron_news_articles', function($table)
        {
            $table->dropColumn('is_hidden');
            $table->dropColumn('startdate');
            $table->dropColumn('enddate');
        });
    }
}

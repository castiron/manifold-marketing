<?php namespace Castiron\News\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCastironNewsArticles2 extends Migration
{
    public function up()
    {
        Schema::table('castiron_news_articles', function($table)
        {
            $table->string('slug', 255);
        });
    }
    
    public function down()
    {
        Schema::table('castiron_news_articles', function($table)
        {
            $table->dropColumn('slug');
        });
    }
}

<?php namespace Castiron\News\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCastironNewsArticles extends Migration
{
    public function up()
    {
        Schema::table('castiron_news_articles', function($table)
        {
            $table->string('title');
            $table->date('date');
            $table->string('author');
            $table->text('teaser');
            $table->text('body');
            $table->string('thumbnail');
            $table->string('interior_image');
        });
    }
    
    public function down()
    {
        Schema::table('castiron_news_articles', function($table)
        {
            $table->dropColumn('title');
            $table->dropColumn('date');
            $table->dropColumn('author');
            $table->dropColumn('teaser');
            $table->dropColumn('body');
            $table->dropColumn('thumbnail');
            $table->dropColumn('interior_image');
        });
    }
}

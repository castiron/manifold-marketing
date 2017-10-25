<?php namespace Castiron\Contentment\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCastironContentmentPages extends Migration
{
    public function up()
    {
        Schema::table('castiron_contentment_pages', function($table)
        {
            $table->string('meta_title', 255)->nullable();
            $table->string('content_type', 255)->nullable();
            $table->text('description')->nullable();
            $table->text('keywords')->nullable();
            $table->string('copyright', 255)->nullable();
            $table->string('meta_image', 255)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('castiron_contentment_pages', function($table)
        {
            $table->dropColumn('meta_title');
            $table->dropColumn('content_type');
            $table->dropColumn('description');
            $table->dropColumn('keywords');
            $table->dropColumn('copyright');
            $table->dropColumn('meta_image');
        });
    }
}

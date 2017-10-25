<?php namespace Castiron\Contentment\Updates;

use Castiron\Contentment\Models\Page;
use Illuminate\Support\Facades\DB;
use Schema;
use October\Rain\Database\Updates\Migration;


class SwitchToPolymorphicRelationshipOnContent extends Migration
{
    public function up()
    {
        Schema::table('castiron_contentment_contents', function($table) {
            $table->integer('contentable_id')->unsigned()->nullable();
            $table->string('contentable_type', 255);
        });

        Db::update('update castiron_contentment_contents set contentable_id = page_id, contentable_type="'.addslashes(Page::class).'"');

        Schema::table('castiron_contentment_contents', function($table) {
            $table->dropForeign('castiron_contentment_contents_page_id_foreign');
            $table->dropColumn('page_id');
        });
    }

    public function down()
    {
        Schema::table('castiron_contentment_contents', function($table) {
            $table->integer('page_id')->unsigned()->nullable();
            $table->foreign('page_id')->references('id')->on('castiron_contentment_pages')->onDelete('cascade');
        });

        Db::update('update castiron_contentment_contents set page_id = contentable_id');

        Schema::table('castiron_contentment_contents', function($table) {
            $table->dropColumn('contentable_id');
            $table->dropColumn('contentable_type');
        });
    }
}

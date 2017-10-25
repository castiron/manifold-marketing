<?php namespace Castiron\Contentment\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateSomeContentsTable extends Migration
{

    public function up()
    {

        Schema::create('castiron_contentment_contents', function ($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('page_id')->unsigned()->nullable();

            $table->text('data')->nullable();
            $table->text('rendered')->nullable();

            $table->integer('element_id')->unsigned()->nullable();
            $table->string('element_type')->nullable();

            $table->integer('sort_order')->default(0);
            $table->boolean('is_hidden')->nullable();
            $table->timestamp('startdate')->nullable();
            $table->timestamp('enddate')->nullable();
            $table->softDeletes();

            $table->timestamps();

            $table->foreign('page_id')
                ->references('id')
                ->on('castiron_contentment_pages')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('castiron_contentment_contents');
    }

}

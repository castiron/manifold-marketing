<?php namespace Castiron\Forms\Updates;
use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
class CreateContactsTable extends Migration
{
  public function up()
  {
    Schema::create('castiron_forms_contacts', function(Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->timestamps();
      $table->string('first_name', 255)->nullable();
      $table->string('last_name', 255)->nullable();
      $table->string('email', 255)->nullable();
      $table->string('subject', 255)->nullable();
      $table->text('body')->nullable();
    });
  }
  public function down()
  {
    Schema::dropIfExists('castiron_forms_contacts');
  }
}

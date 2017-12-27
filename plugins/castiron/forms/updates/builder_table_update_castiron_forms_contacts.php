<?php namespace Castiron\Forms\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCastironFormsContacts extends Migration
{
    public function up()
    {
        Schema::table('castiron_forms_contacts', function($table)
        {
            $table->string('name', 255)->nullable();
            $table->string('organization', 255)->nullable();
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('subject');
        });
    }
    
    public function down()
    {
        Schema::table('castiron_forms_contacts', function($table)
        {
            $table->dropColumn('name');
            $table->dropColumn('organization');
            $table->string('first_name', 255)->nullable();
            $table->string('last_name', 255)->nullable();
            $table->string('subject', 255)->nullable();
        });
    }
}

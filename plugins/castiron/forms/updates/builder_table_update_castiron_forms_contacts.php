<?php namespace Castiron\Forms\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCastironFormsContacts extends Migration
{
    public function up()
    {
        Schema::table('castiron_forms_contacts', function($table)
        {
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('profession');
            $table->dropColumn('participation');
            $table->dropColumn('organization');
        });
    }
    
    public function down()
    {
        Schema::table('castiron_forms_contacts', function($table)
        {
            $table->string('first_name', 255)->nullable();
            $table->string('last_name', 255)->nullable();
            $table->text('profession')->nullable();
            $table->text('participation')->nullable();
            $table->string('organization', 255)->nullable();
        });
    }
}

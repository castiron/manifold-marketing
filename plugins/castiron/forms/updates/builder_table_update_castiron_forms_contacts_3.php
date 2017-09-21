<?php namespace Castiron\Forms\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCastironFormsContacts3 extends Migration
{
    public function up()
    {
        Schema::table('castiron_forms_contacts', function($table)
        {
            $table->string('first_name', 255)->nullable();
            $table->string('last_name', 255)->nullable();
            $table->string('email', 255)->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('castiron_forms_contacts', function($table)
        {
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->string('email', 255)->nullable(false)->change();
        });
    }
}

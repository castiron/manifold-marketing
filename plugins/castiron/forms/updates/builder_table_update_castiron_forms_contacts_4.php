<?php namespace Castiron\Forms\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCastironFormsContacts4 extends Migration
{
    public function up()
    {
        Schema::table('castiron_forms_contacts', function($table)
        {
            $table->string('subject')->nullable();
            $table->text('body')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('castiron_forms_contacts', function($table)
        {
            $table->dropColumn('subject');
            $table->dropColumn('body');
        });
    }
}

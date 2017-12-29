<?php namespace Castiron\Forms\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCastironFormsContacts2 extends Migration
{
    public function up()
    {
        Schema::table('castiron_forms_contacts', function($table)
        {
            $table->string('phone')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('castiron_forms_contacts', function($table)
        {
            $table->dropColumn('phone');
        });
    }
}

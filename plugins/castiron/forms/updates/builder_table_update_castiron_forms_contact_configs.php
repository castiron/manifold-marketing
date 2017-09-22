<?php namespace Castiron\Forms\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCastironFormsContactConfigs extends Migration
{
    public function up()
    {
        Schema::rename('castiron_forms_config', 'castiron_forms_contact_configs');
    }
    
    public function down()
    {
        Schema::rename('castiron_forms_contact_configs', 'castiron_forms_config');
    }
}

<?php namespace Castiron\Forms\ImportExport;

use Model;
use Castiron\Forms\Models\Contact;
use Backend\Models\ExportModel;

/**
 * ContactExport Model
 */
class ContactExport extends ExportModel
{
    public function exportData($columns, $sessionKey = null)
    {
        $contacts = Contact::all();
        $contacts->each(function($contact) use ($columns) {
            $contact->addVisible($columns);
        });

        return $contacts->toArray();
    }
}

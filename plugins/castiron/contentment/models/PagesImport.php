<?php

namespace Castiron\Contentment\Models;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PagesImport extends \Backend\Models\ImportModel
{
    protected $rules = [];
    public function importData($results, $sessionKey = null)
    {
        foreach ($results as $row => $data) {

            try {
                $entry = Page::findOrFail($data['id']);
                $entry->fill($data);
                $entry->save();
                $this->logUpdated();
            }
            catch (ModelNotFoundException $ex) {
                $entry = new Page;
                $entry->fill($data);
                $entry->save();
                $this->logCreated();
            }
            catch (\Exception $ex) {
                $this->logError($row, $ex->getMessage());
            }

        }
    }

}

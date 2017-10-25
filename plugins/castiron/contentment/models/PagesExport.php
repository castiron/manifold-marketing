<?php
namespace Castiron\Contentment\Models;

class PagesExport extends \Backend\Models\ExportModel {

    public function exportData($columns, $sessionKey = null)
    {
        $pages = Page::all();
        $pages->each(function($subscriber) use ($columns) {
            $subscriber->addVisible($columns);
        });
        return $pages->toArray();
    }

}

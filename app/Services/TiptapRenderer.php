<?php

namespace App\Services;

use Illuminate\Support\HtmlString;
use Tiptap\Editor;

class TiptapRenderer
{
    public static function process(string $document): HtmlString
    {
        $html = (new Editor)->setContent(json_decode($document, associative: true, flags: JSON_THROW_ON_ERROR))->getHTML();

        return new HtmlString($html);
    }
}

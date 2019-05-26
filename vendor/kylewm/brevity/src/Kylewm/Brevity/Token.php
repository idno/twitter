<?php
namespace Kylewm\Brevity;

class Token
{
    public $tag;
    public $content;
    public $required;

    function __construct($tag, $content, $required=false)
    {
        $this->tag = $tag;
        $this->content = $content;
        $this->required = $required;
    }
}

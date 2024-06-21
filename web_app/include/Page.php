<?php

class Page
{
    public $id;
    public $folder;
    public $icon;
    public $name;
    public $children;
    public $has_child;
    public $id_parent;

    public function __construct($data)
    {
        $this->id = $data['idPage'];
        $this->folder = $data['folderPage'];
        $this->icon = $data['iconPage'];
        $this->name = $data['namePage'];
        $this->id_parent = $data['parent_id'];
        $this->has_child = $data['has_child'];
    }

    public function is_parent(Page $page): bool
    {
        if ($page->has_child != null) {
            return true;
        }
        return false;
    }
}
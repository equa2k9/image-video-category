<?php
class Image_Video
{
    private $form;
    private $front;
    
    public function __construct() {
        $this->form = new Image_Video_Form();
        $this->front = new Image_Video_Front();
    }
}

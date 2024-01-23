<?php
class Course
{
    private $id;
    private $name;
    private $description;
    private $price;
    private $image;
    private $video;
    private $duration;
    private $category_id;

    public function __construct($name, $description, $price, $image, $video, $duration, $category_id)
    {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->image = $image;
        $this->video = $video;
        $this->duration = $duration;
        $this->category_id = $category_id;
    }
}

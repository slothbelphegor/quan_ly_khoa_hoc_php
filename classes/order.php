<?php
class Order
{
    private $id;
    private $user_id;
    private $course_id;
    private $total_amount;
    private $status;

    public function __construct($user_id, $course_id, $total_amount, $status)
    {
        $this->user_id = $user_id;
        $this->course_id = $course_id;
        $this->total_amount = $total_amount;
        $this->status = $status;
    }
}

<?php

namespace App\Http\Response;

class BasicResponse
{
    protected int $status;

    protected string $title;

    protected string $message;

    protected string $type;

    public function __construct(
        int $status,
        string $title,
        string $message,
        string $type
    )
    {
        $this->status = $status;
        $this->title = $title;
        $this->message = $message;
        $this->type = $type;
    }

    public function asArray() {
        return array(
            'status'    => $this->status,
            'title'     => $this->title,
            'message'   => $this->message,
            'type'      => $this->type,
        );
    }
}

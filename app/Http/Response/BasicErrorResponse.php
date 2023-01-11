<?php

namespace App\Http\Response;

class BasicErrorResponse extends BasicResponse
{
    private string | null $test;

    public function __construct(string $msg, string | null $test = null)
    {
        parent::__construct(0, "Error", $msg, "error");
        $this->test = $test;
    }

    public function asArray()
    {
        $array = parent::asArray();
        $array = array_merge($array, array(
            'test'  => $this->test
        ));

        return $array;
    }
}

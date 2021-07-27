<?php

namespace App\Helpers;

class JsonResponse
{
    /**
     * The HTTP status message from the server response
     *
     * @var string
     */
    public $message;

    /**
     * The HTTP status code from the server response
     *
     * @var string
     */
    public $statusCode;

    /**
     * The response that was provided by the server
     *
     * @var array
     */
    public $data = [];

    /**
     * The response errors that was provided by the server
     *
     * @var array
     */
    public $errors = [];

    /**
     * Constructor method
     *
     * @param integer $statusCode
     * @param string $message
     */
    public function __construct(int $statusCode = 200, string $message = 'Ok')
    {
        $this->statusCode = $statusCode;
        $this->message = $message;
    }

    /**
     * Convert the class to its string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * Convert the object instance to JSON.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        $data = $this->toArray();

        foreach ($data as $key => $value) {
            if (is_array($data[$key]) && count($data[$key]) == 0) {
                unset($data[$key]);
            } else if ($data[$key] == null) {
                unset($data[$key]);
            }
        }

        $json = json_encode($data, $options);

        return $json;
    }

    /**
     * Convert the object instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }
}

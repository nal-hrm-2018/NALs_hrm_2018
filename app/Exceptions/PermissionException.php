<?php
namespace App\Exceptions;
use Illuminate\Http\Request;
use App\Http\Resources\JsonResponse;
use Log;
use Illuminate\Http\Response;

class PermissionException extends \Exception{
	protected $message = [];

    public function __construct($message = null)
    {
        $this->message = $message;

        parent::__construct($message);
    }
}
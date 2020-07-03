<?php
namespace App\Http\Controllers;

use Illuminate\Http\Response;

class ApiController extends Controller
{

	protected function api($code, $message = null, $data = null, $title = null)
	{
		$response = ['code' => $code];
		$response = $title ? array_merge($response,['title' => $title]) : $response;
		$response = $message ? array_merge($response,['message' => $message]) : $response;
		$response = $data ? array_merge($response,['data' => $data]) : $response;

		return response()->json($response, $code);
    }

	public function unauthorized($message = "Unauthorized", $data = null, $title = '¡Ups!')
	{
		return $this->api(Response::HTTP_UNAUTHORIZED,$message,$data,$title);
	}

	public function bad_request($message = null, $data = null, $title = '¡Ups!')
	{
		return $this->api(Response::HTTP_BAD_REQUEST,$message,$data,$title);
	}

	public function not_found($message = 'Not found!', $data = null, $title = '¡Ups!')
	{
		return $this->api(Response::HTTP_NOT_FOUND,$message,$data,$title);
	}

	public function no_content($message = null, $data = null, $title = null)
	{
		return $this->api(Response::HTTP_NO_CONTENT,$message,$data);
	}

	public function not_modified($message = null, $data = null, $title = null)
	{
		return $this->api(Response::HTTP_NOT_MODIFIED,$message,$data);
	}

	public function created($data = null, $message = "Created successfully")
	{
		return $this->api(Response::HTTP_CREATED,$message,$data);
	}

	public function ok($data = null, $message = null)
	{
		return $this->api(Response::HTTP_OK,$message,$data);
    }

	public function deleted($data = null, $message = "Deleted successfully")
	{
		return $this->api(Response::HTTP_OK,$message,$data);
	}

}

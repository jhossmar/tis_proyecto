<?php namespace App\Http\Controllers; 

class WelcomeController extends Controller
{
	public function __constrcut()
	{
		$this->middleware('guest');
	}
	public function contacto()
	{
		return view('contacto');
	}
}

?>
<?php
/*Router responsible for detrmening paths*/

class Router
{
	private $raw_controller;
	private $controller;
	private $action;
	private $id;
	
	public function __construct($zeus_uri)
	{
		//convention will always follow last three with /controller/action(/id) although
		// /controller(/id) will be accepted as well and /controller/ will redirect to controller/index
		$this->find_controller($zeus_uri);
		$this->find_action($zeus_uri);
	}
	
	private function find_controller($zeus_uri)
	{
		$uri_pieces = explode("/",$zeus_uri);
		$num_pieces = count($uri_pieces);
		if($num_pieces == 1)
		{
			// /controller/
			$this->controller = ucfirst(inflector($uri_pieces[0]))."Controller";
		}
		else
		{
			for($i = $num_pieces; $i > 0; $i--)
			{
				$possible_controller = ucfirst(inflector($uri_pieces[$num_pieces - $i]))."Controller";
				if(file_exists("../controllers/".$possible_controller.".php"))
				{
					$this->controller = $possible_controller;
					$this->raw_controller = $uri_pieces[$num_pieces - $i];
				}
			}
		}
	}
	
	private function find_action($zeus_uri)
	{
		$matches = Array();
		preg_match("/".$this->raw_controller."\\/(.+)(?=\\/|$)/",$zeus_uri,$matches);
		if(count($matches) == 2)
		{
			$this->action = $matches[1];
		}
		else
		{
			$this->action = "index";
		}
	}
	
	public function getController()
	{
		return $this->controller;
	}
	
	public function getAction()
	{
		return $this->action;
	}
	
	
}
<?php  

/*
* Класс Роутер 
*/ 
class Router
{
	protected static $control;  // Контроллер = Класс
	protected static $action;   // Действие = Метод
	protected static $get = []; // Get параметры запроса




	/* Запуск обработки */
	public static function dispatch($path,$get)
	{
		self::matchRoute($path);

		$control = self::$control;
		$action = self::$action;

		$obj = new $control;
		$obj->$action(self::explodeGet($get));
	}





	/* Разбивает путь на Контроллер / Действие */
	public static function matchRoute($path)
	{
		$path = explode('/', $path);//разбить пкть по слешу

		$path[0] = self::upperCamelCase($path[0]);// привести верх регистр
		$path[1] = self::lowerCamelCase($path[1]);// привести нижн регистр

		self::$control = self::finedControl($path[0]);
		self::$action  = self::finedAction(self::$control, $path[1]);
	}





	/* Разбиваем Get регулярными выражениями массив */
	public static function explodeGet($get)
	{
		$array1 = array();
    	$array2 = explode('&', $get);
    	foreach($array2 as $str) 
    	{
       		list($key, $value) = explode('=', $str);
        	$array1[$key] = $value;
   		}
   		return $array1;
	}





	/* Приведение к нижнему регистру 
	   @return string удаляет пробелы и тире и в низ рег 1 букв 1 слова все ост верх букр рег
	*/
	public static function lowerCamelCase($name)
	{
		return lcfirst(self::upperCamelCase($name));
	} 





	/* Приведение к верхнему регистру 
	   @return string удаляет пробелы и тире возводит верх рег все перв буквы
	*/
	public static function upperCamelCase($name)
	{
		return $name = str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
	} 





	/* Поиск Контроллера(Класса) 
	*  Если найден то подключение файла + запись класса в свойство
	*  Если класс ненайден то ошибка 404 
	*/ 
	public static function finedControl($control)
	{
		$patn_control = 'app/Controllers/'.$control.'Class.php';
		if (is_file($patn_control)) {
			require $patn_control;
			return $control.'Class';
		}else{
			http_response_code(404);
			die("Ошибка 404");
		}
	}





	/* Поиск Действия(Метода) в Контроллере(Классе) 
	*  Если найден то он записать в свойство класса
	*  Если метода не найден то вызов дефолтного метода(Index)
	*/ 
	public static function finedAction($control, $action)
	{
		if (method_exists($control, $action.'Action')) {
			return $action.'Action';
		}else{
			return 'indexAction';
		}
	}



}

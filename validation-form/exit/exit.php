<?php 

// Удаляем все переменные сессии.
$_SESSION = array();

// Если требуется уничтожить сессию, также необходимо удалить сессионные cookie.
// Замечание: Это уничтожит сессию, а не только данные сессии!
if (ini_get("session.use_cookies")) {

	@setcookie ('user', $login, time() - 3600, "/"); // Удаляем Куки
    
    $params = session_get_cookie_params(); // Возвращает параметры cookie сессии
    setcookie(session_name(), '', time() - 3600, // Удаляем сессию
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Наконец, уничтожаем сессию.
@session_destroy();

header('Location: /');
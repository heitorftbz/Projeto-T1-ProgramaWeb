<?php

// Destrói a sessão
session_unset(); // Remove todas as variáveis de sessão
session_destroy(); // Destroi a sessão

// Redireciona para a página inicial
header("Location: index.php");
exit();
?>

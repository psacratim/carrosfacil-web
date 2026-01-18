<?php
function HeaderComponent(string $pageName)
{
    ob_start();
?>
    <div id="header-sentinel" style="position: absolute; height: 20px; width: 20px; z-index: 10000;"></div>
    <header id="main-header" class="scrolled"> <nav class="navbar navbar-expand-lg h-100">
            <div class="container h-100">
                <a class="navbar-brand" href="/index.php">
                    <img src="./assets/img/logotipo-empresa.png" width="auto" height="25" class="d-inline-block align-top my-auto" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 mx-auto">
                        <li class="nav-item">
                            <a class="nav-link <?= $pageName == 'index' ? 'active' : '' ?>" href="/index.php">Veículos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $pageName == 'about' ? 'active' : '' ?>" href="/about.php">Sobre nós</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $pageName == 'contact' ? 'active' : '' ?>" href="/contact.php">Contato</a>
                        </li>
                    </ul>

                    <div class="auth-content d-flex flex-column flex-lg-row gap-2">
                        <a href="/Login.php" class="btn btn-login">Login</a>
                        <a href="/Register.php" class="btn btn-register">Registrar</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
<?php
    return ob_get_clean();
}
?>
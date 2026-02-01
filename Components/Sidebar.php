<?php
function Sidebar(string $pageName)
{
  ob_start();
?>
  <aside class="col-lg-2 py-3 px-2 sidebar d-none d-lg-flex">
    <div class="sidebar-logo d-flex align-items-center justify-content-center gap-2">
      <span>CarrosFácil - Sistema</span>
    </div>

    <hr class="my-3">

    <nav class="d-flex flex-column gap-1 px-3">
      <a href="http://localhost:3000/admin/dashboard.php" class="nav-custom-link <?= $pageName == "dashboard" ? "active" : "" ?>">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
      </a>

      <a href="http://localhost:3000/admin/vendas/Index.php" class="nav-custom-link <?= $pageName == "sell" ? "active" : "" ?>">
        <i class="bi bi-cart-plus"></i>
        <span>Nova venda</span>
      </a>

      <div class="dropdown-container">
        <button class="dropdown-expand-button nav-custom-link justify-content-between">
          <div class="d-flex align-items-center gap-3">
            <i class="bi bi-briefcase"></i>
            <span>Gestão</span>
          </div>
          <i class="bi bi-chevron-down dropdown-arrow"></i>
        </button>

        <div class="dropdown-content-custom">
          <a href="http://localhost:3000/admin/funcionarios/index.php" class="submenu-link <?= $pageName == "employee" ? "active" : "" ?>">Funcionários</a>
          <a href="http://localhost:3000/admin/clientes/index.php" class="submenu-link <?= $pageName == "customer" ? "active" : "" ?>">Clientes</a>
          <a href="http://localhost:3000/admin/veiculos/index.php" class="submenu-link <?= $pageName == "vehicle" ? "active" : "" ?>">Veículos</a>
          <a href="http://localhost:3000/admin/modelos/index.php" class="submenu-link <?= $pageName == "model" ? "active" : "" ?>">Modelos</a>
          <a href="http://localhost:3000/admin/marcas/index.php" class="submenu-link <?= $pageName == "brand" ? "active" : "" ?>">Marcas</a>
          <a href="http://localhost:3000/admin/cargos/index.php" class="submenu-link <?= $pageName == "role" ? "active" : "" ?>">Cargos</a>
          <a href="http://localhost:3000/admin/vitems/index.php" class="submenu-link <?= $pageName == "items" ? "active" : "" ?>">Características</a>
        </div>
      </div>
    </nav>

    <div class="sidebar-footer">
      <div class="avatar-circle">PH</div>
      <div class="user-info">
        <p class="user-name"><?= $_SESSION['name'] ?></p>
        <a id="logout-button">Sair do sistema</a>
      </div>
    </div>
  </aside>
<?php
  return ob_get_clean();
}
?>
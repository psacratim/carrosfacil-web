<aside class="col-lg-2 py-3 px-2 sidebar d-none d-lg-flex">
  <div class="sidebar-logo d-flex align-items-center justify-content-center gap-2">
    <span>CarrosFácil - Sistema</span>
  </div>

  <hr class="my-3">

  <nav class="d-flex flex-column gap-1 px-3">
    <a href="http://localhost:3000/admin/dashboard.php" class="nav-custom-link active">
      <i class="bi bi-speedometer2"></i>
      <span>Dashboard</span>
    </a>

    <a href="http://localhost:3000/admin/vendas/Index.php" class="nav-custom-link">
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
        <a href="http://localhost:3000/admin/funcionarios/index.php" class="submenu-link">Funcionários</a>
        <a href="http://localhost:3000/admin/clientes/index.php" class="submenu-link">Clientes</a>
        <a href="http://localhost:3000/admin/veiculos/index.php" class="submenu-link">Veículos</a>
        <a href="http://localhost:3000/admin/modelos/index.php" class="submenu-link">Modelos</a>
        <a href="http://localhost:3000/admin/marcas/index.php" class="submenu-link">Marcas</a>
        <a href="http://localhost:3000/admin/cargos/index.php" class="submenu-link">Cargos</a>
        <a href="http://localhost:3000/admin/vitems/index.php" class="submenu-link">Características</a>
      </div>
    </div>

    <div class="dropdown-container">
      <button class="dropdown-expand-button nav-custom-link justify-content-between">
        <div class="d-flex align-items-center gap-3">
          <i class="bi bi-bar-chart-line"></i>
          <span>Relatórios</span>
        </div>
        <i class="bi bi-chevron-down dropdown-arrow"></i>
      </button>

      <div class="dropdown-content-custom">
        <a href="#" class="submenu-link">Vendas</a>
        <a href="#" class="submenu-link">Clientes</a>
      </div>
    </div>

    <a href="#" class="nav-custom-link">
      <i class="bi bi-people"></i>
      <span>Usuários</span>
    </a>
  </nav>

  <div class="sidebar-footer">
    <div class="avatar-circle">PH</div>
    <div class="user-info">
      <p class="user-name">Pedro Henrique</p>
      <a href="#" class="logout-link">Sair do sistema</a>
    </div>
  </div>
</aside>
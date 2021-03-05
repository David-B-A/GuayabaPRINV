<li class="nav-item">
    <a href="{{ route('customers.index') }}"
       class="nav-link {{ Request::is('customers*') ? 'active' : '' }}">
        <p>Clientes</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('users.index') }}"
       class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
        <p>Usuarios</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('products.index') }}"
       class="nav-link {{ Request::is('products*') ? 'active' : '' }}">
        <p>Productos</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('purchases.index') }}"
       class="nav-link {{ Request::is('purchases*') ? 'active' : '' }}">
        <p>Compras</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('sales.index') }}"
       class="nav-link {{ Request::is('sales*') ? 'active' : '' }}">
        <p>Ventas</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('processTemplates.index') }}"
       class="nav-link {{ Request::is('processTemplates*') ? 'active' : '' }}">
        <p>Esquemas de Proceso</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('processes.index') }}"
       class="nav-link {{ Request::is('processes*') ? 'active' : '' }}">
        <p>Procesos</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('stockMovements.index') }}"
       class="nav-link {{ Request::is('stockMovements*') ? 'active' : '' }}">
        <p>Movimientos de inventario</p>
    </a>
</li>



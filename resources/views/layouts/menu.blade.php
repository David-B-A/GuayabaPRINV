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
        <p>Procesos Estándar</p>
    </a>
</li>



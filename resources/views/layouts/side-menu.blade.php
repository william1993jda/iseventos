<!-- BEGIN: Side Menu -->
<nav class="side-nav">
    <ul>
        {{-- <li>
            <a href="javascript:;.html" class="side-menu side-menu--active">
                <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
                <div class="side-menu__title">
                    Dashboard
                    <div class="side-menu__sub-icon transform rotate-180"> <i data-lucide="chevron-down"></i>
                    </div>
                </div>
            </a>
            <ul class="side-menu__sub-open">
                <li>
                    <a href="side-menu-light-dashboard-overview-1.html" class="side-menu side-menu--active">
                        <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                        <div class="side-menu__title"> Overview 1 </div>
                    </a>
                </li>
                <li>
                    <a href="side-menu-light-dashboard-overview-2.html" class="side-menu">
                        <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                        <div class="side-menu__title"> Overview 2 </div>
                    </a>
                </li>
                <li>
                    <a href="side-menu-light-dashboard-overview-3.html" class="side-menu">
                        <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                        <div class="side-menu__title"> Overview 3 </div>
                    </a>
                </li>
                <li>
                    <a href="index.html" class="side-menu">
                        <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                        <div class="side-menu__title"> Overview 4 </div>
                    </a>
                </li>
            </ul>
        </li> --}}
        {{-- <li>
            <a href="{{ route('users.index') }}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="user"></i> </div>
                <div class="side-menu__title"> Usuários </div>
            </a>
        </li> --}}
        <li>
            <a href="{{ route('employees.index') }}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="users"></i> </div>
                <div class="side-menu__title"> Funcionários </div>
            </a>
        </li>
        <li>
            <a href="{{ route('freelancers.index') }}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="users"></i> </div>
                <div class="side-menu__title"> Freelancers </div>
            </a>
        </li>
        <li>
            <a href="{{ route('labors.index') }}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="contact"></i> </div>
                <div class="side-menu__title"> Mão de obra </div>
            </a>
        </li>
        <li>
            <a href="{{ route('customers.index') }}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="building"></i> </div>
                <div class="side-menu__title"> Clientes </div>
            </a>
        </li>
        <li>
            <a href="{{ route('agencies.index') }}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="briefcase"></i> </div>
                <div class="side-menu__title"> Agência </div>
            </a>
        </li>
        <li>
            <a href="{{ route('providers.index') }}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="truck"></i> </div>
                <div class="side-menu__title"> Fornecedores </div>
            </a>
        </li>
        <li>
            <a href="{{ route('places.index') }}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="map-pin"></i> </div>
                <div class="side-menu__title"> Locais </div>
            </a>
        </li>
        <li>
            <a href="{{ route('groups.index') }}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="map-pin"></i> </div>
                <div class="side-menu__title"> Kits </div>
            </a>
        </li>
        <li>
            <a href="{{ route('statuses.index') }}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="layout-list"></i> </div>
                <div class="side-menu__title"> Status - Comercial </div>
            </a>
        </li>
        <li>
            <a href="{{ route('os-statuses.index') }}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="layout-list"></i> </div>
                <div class="side-menu__title"> Status - Estoque </div>
            </a>
        </li>
        <li>
            <a href="{{ route('categories.index') }}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="tag"></i> </div>
                <div class="side-menu__title"> Categorias - Comercial </div>
            </a>
        </li>
        <li>
            <a href="{{ route('os-categories.index') }}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="tag"></i> </div>
                <div class="side-menu__title"> Categorias - Estoque </div>
            </a>
        </li>
        <li>
            <a href="{{ route('products.index') }}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="box"></i> </div>
                <div class="side-menu__title"> Equipamentos - Comercial </div>
            </a>
        </li>
        <li>
            <a href="{{ route('os-products.index') }}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="package"></i> </div>
                <div class="side-menu__title"> Equipamentos - Estoque </div>
            </a>
        </li>
        {{-- <li>
            <a href="#" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="package-plus"></i> </div>
                <div class="side-menu__title"> Kits </div>
            </a>
        </li> --}}
        <li>
            <a href="{{ route('budgets.index') }}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="clipboard-check"></i> </div>
                <div class="side-menu__title"> Orçamento </div>
            </a>
        </li>
        <li>
            <a href="{{ route('orderServices.index') }}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="clipboard-check"></i> </div>
                <div class="side-menu__title"> Ordem de Serviço </div>
            </a>
        </li>
        <li>
            <a href="#" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="clipboard-list"></i> </div>
                <div class="side-menu__title"> Ordem de serviço </div>
            </a>
        </li>
        {{-- <li>
            <a href="#" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="clipboard"></i> </div>
                <div class="side-menu__title"> Briefing </div>
            </a>
        </li> --}}
        {{-- <li class="side-nav__devider my-6"></li>
        <li>
            <a href="side-menu-light-inbox.html" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="inbox"></i> </div>
                <div class="side-menu__title"> Inbox 2</div>
            </a>
        </li> --}}
    </ul>
</nav>
<!-- END: Side Menu -->

<!-- BEGIN: Side Menu -->
<nav class="side-nav">
    <ul>
        <li>
            <a href="{{ route('dashboard.index') }}" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="layout-dashboard"></i> </div>
                <div class="side-menu__title"> Dashboard </div>
            </a>
        </li>
        @can('employees.index')
            <li>
                <a href="{{ route('employees.index') }}" class="side-menu">
                    <div class="side-menu__icon"> <i data-lucide="users"></i> </div>
                    <div class="side-menu__title"> Funcionários </div>
                </a>
            </li>
        @endcan
        @can('freelancers.index')
            <li>
                <a href="{{ route('freelancers.index') }}" class="side-menu">
                    <div class="side-menu__icon"> <i data-lucide="users"></i> </div>
                    <div class="side-menu__title"> Freelancers </div>
                </a>
            </li>
        @endcan
        @can('labors.index')
            <li>
                <a href="{{ route('labors.index') }}" class="side-menu">
                    <div class="side-menu__icon"> <i data-lucide="contact"></i> </div>
                    <div class="side-menu__title"> Mão de obra </div>
                </a>
            </li>
        @endcan
        @can('customers.index')
            <li>
                <a href="{{ route('customers.index') }}" class="side-menu">
                    <div class="side-menu__icon"> <i data-lucide="building"></i> </div>
                    <div class="side-menu__title"> Clientes </div>
                </a>
            </li>
        @endcan
        @can('agencies.index')
            <li>
                <a href="{{ route('agencies.index') }}" class="side-menu">
                    <div class="side-menu__icon"> <i data-lucide="briefcase"></i> </div>
                    <div class="side-menu__title"> Agência </div>
                </a>
            </li>
        @endcan
        @can('providers.index')
            <li>
                <a href="{{ route('providers.index') }}" class="side-menu">
                    <div class="side-menu__icon"> <i data-lucide="truck"></i> </div>
                    <div class="side-menu__title"> Fornecedores </div>
                </a>
            </li>
        @endcan
        @can('budgets.index')
            <li>
                <a href="{{ route('budgets.index') }}" class="side-menu">
                    <div class="side-menu__icon"> <i data-lucide="clipboard-check"></i> </div>
                    <div class="side-menu__title"> Orçamento </div>
                </a>
            </li>
        @endcan
        @can('orderServices.index')
            <li>
                <a href="{{ route('orderServices.index') }}" class="side-menu">
                    <div class="side-menu__icon"> <i data-lucide="clipboard-list"></i> </div>
                    <div class="side-menu__title"> Ordem de Serviço </div>
                </a>
            </li>
        @endcan
        @can('subleases.index')
            <li>
                <a href="{{ route('subleases.index') }}" class="side-menu">
                    <div class="side-menu__icon"> <i data-lucide="package-search"></i> </div>
                    <div class="side-menu__title"> Equipamentos Sublocados </div>
                </a>
            </li>
        @endcan
        @can('briefings.index')
            <li>
                <a href="{{ route('briefings.index') }}" class="side-menu">
                    <div class="side-menu__icon"> <i data-lucide="file-spreadsheet"></i> </div>
                    <div class="side-menu__title"> Briefings </div>
                </a>
            </li>
        @endcan
        <li>
            <a href="javascript:;.html" class="side-menu side-menu">
                <div class="side-menu__icon"> <i data-lucide="file-bar-chart"></i> </div>
                <div class="side-menu__title">
                    Relatórios
                    <div class="side-menu__sub-icon transform"> <i data-lucide="chevron-down"></i></div>
                </div>
            </a>
            <ul class="side-menu__sub">
                {{-- @can('places.index') --}}
                <li>
                    <a href="{{ route('reports.events') }}" class="side-menu">
                        <div class="side-menu__icon"> <i data-lucide="clipboard-check"></i> </div>
                        <div class="side-menu__title"> Eventos </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('reports.products') }}" class="side-menu">
                        <div class="side-menu__icon"> <i data-lucide="box"></i> </div>
                        <div class="side-menu__title"> Equipamentos </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('reports.providers') }}" class="side-menu">
                        <div class="side-menu__icon"> <i data-lucide="truck"></i> </div>
                        <div class="side-menu__title"> Fornecedores </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('reports.freelancers') }}" class="side-menu">
                        <div class="side-menu__icon"> <i data-lucide="users"></i> </div>
                        <div class="side-menu__title"> Freelancers </div>
                    </a>
                </li>
                {{-- @endcan --}}
            </ul>
        </li>
        <li>
            <a href="javascript:;.html" class="side-menu side-menu">
                <div class="side-menu__icon"> <i data-lucide="layout-list"></i> </div>
                <div class="side-menu__title">
                    Cadastros
                    <div class="side-menu__sub-icon transform"> <i data-lucide="chevron-down"></i></div>
                </div>
            </a>
            <ul class="side-menu__sub">
                @can('places.index')
                    <li>
                        <a href="{{ route('places.index') }}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="map-pin"></i> </div>
                            <div class="side-menu__title"> Locais </div>
                        </a>
                    </li>
                @endcan
                @can('groups.index')
                    <li>
                        <a href="{{ route('groups.index') }}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="package-plus"></i> </div>
                            <div class="side-menu__title"> Kits </div>
                        </a>
                    </li>
                @endcan
                @can('statuses.index')
                    <li>
                        <a href="{{ route('statuses.index') }}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="layout-list"></i> </div>
                            <div class="side-menu__title"> Status - Comercial </div>
                        </a>
                    </li>
                @endcan
                @can('os-statuses.index')
                    <li>
                        <a href="{{ route('os-statuses.index') }}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="layout-list"></i> </div>
                            <div class="side-menu__title"> Status - Estoque </div>
                        </a>
                    </li>
                @endcan
                @can('categories.index')
                    <li>
                        <a href="{{ route('categories.index') }}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="tag"></i> </div>
                            <div class="side-menu__title"> Categorias - Comercial </div>
                        </a>
                    </li>
                @endcan
                @can('os-categories.index')
                    <li>
                        <a href="{{ route('os-categories.index') }}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="tag"></i> </div>
                            <div class="side-menu__title"> Categorias - Estoque </div>
                        </a>
                    </li>
                @endcan
                @can('products.index')
                    <li>
                        <a href="{{ route('products.index') }}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="box"></i> </div>
                            <div class="side-menu__title"> Equipamentos - Comercial </div>
                        </a>
                    </li>
                @endcan
                @can('os-products.index')
                    <li>
                        <a href="{{ route('os-products.index') }}" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="package"></i> </div>
                            <div class="side-menu__title"> Equipamentos - Estoque </div>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
        @can('recoveries.index')
            <li>
                <a href="{{ route('recoveries.index') }}" class="side-menu">
                    <div class="side-menu__icon"> <i data-lucide="database-backup"></i> </div>
                    <div class="side-menu__title"> Recuperar Dados </div>
                </a>
            </li>
        @endcan
    </ul>
</nav>
<!-- END: Side Menu -->

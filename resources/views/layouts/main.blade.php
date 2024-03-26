<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <title>@yield('title')</title>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-warning">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">Início</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        @auth
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/create">Cadastrar ativo</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/assets/show">Gerenciar Ativos</a>
                        </li>
                        <li class="nav-item">
                        <form action="/logout" method="POST">
                        @csrf
                        <a class="nav-link active text-black" onclick="event.preventDefault();this.closest('form').submit();">Sair</a>
                    </form>
                </li>
                    </ul>
                    <form action="/assets/search" method="get"  class="d-flex form-search" role="search" id="search-form" class="search-form" style="display: none !important;">
                    @csrf
                        <input class="form-control me-2" type="search" name="search" placeholder="Pesquise um ativo" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Pesquisar</button>
                    </form>
                    @endauth
                    @guest
                    <li class="nav-item">
                        <a class="nav-link active text-black" href="/login">Entrar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active text-black" href="/register">Registrar novo usuário</a>
                    </li>
                @endguest
                </div>
            </div>
        </nav>
    </header>
    <main>
        <div class="container-fluid">
            <div class="row">
            @if(session('msg'))
                <p class="msg">{{ session('msg') }}</p>
            @endif
            @yield('content')
            </div>
        </div>
    </main>
    <script src="/js/main.js"></script>
</body>
</html>

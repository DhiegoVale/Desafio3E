function show_filterForm(){
    var form = document.getElementById('filter-form');
    if (form.style.display === 'block') {
        form.style.display = 'none';
    } else {
        form.style.display = 'block';
    }
}
function show_searchForm(){
    var form = document.getElementById('search-form')
    form.style.display = 'block'
    // Adicione aqui o código que você deseja executar ao abrir a página
}
// Função para verificar se a página que está aberta é a pagina de dashboard
if(window.location.href === 'http://127.0.0.1:8000/assets/show' || document.title === 'Gerenciar assets'){
    //Se sim, exibe o formulário de pesquisa
    show_searchForm();
}

// Função para restringir o usuário a somente digitar números no input de CPF e CNPJ
function onlyNumbers(event) {
    event.target.value = event.target.value.replace(/[^0-9]/g, '');
}
// Função para não permitir números negativos
function no_negativeNumbers(event) {
    if (event.target.value < 0) {
        event.target.value = '';
    }
}
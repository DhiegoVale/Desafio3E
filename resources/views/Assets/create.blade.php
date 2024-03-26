@extends('layouts.main')

@section('title', 'Cadastrar Ativo')

@section('content')
<div id="app">
    <div class="col-md-6 offset-md-3" id="ativo-create-ativo">
        <h2>Formulário de cadastro do ativo</h2>
        <form action="/assets/save" method="post">
            @csrf
            <div class="container border border-info">
                <h2>Dados da pessoa responsável pelo ativo:</h2>
                <div class="form-group">
                    <label for="name">Nome:</label>
                    <input type="text" class="form-control" required id="name" name="person_name" placeholder="Digite o nome da pessoa responsável pelo ativo...">
                </div>
                <div class="form-group">
                    <label for="type">Tipo:</label>
                    <select v-model="selectedPType" name="person_type">
                        <option value="Física">Física</option>
                        <option value="Jurídica">Jurídica</option>
                    </select>
                </div>
                <div class="form-group" v-if="selectedPType === 'Física'">
                    <label for="name">CPF:</label>
                    <input type="text" class="form-control" required id="cpf" name="cpf" placeholder="Digite o cpf (Só os números)" maxlength="11" minlength="11" pattern="\d*" oninput="onlyNumbers(event)">
                </div>
                <div class="form-group" v-if="selectedPType === 'Jurídica'">
                    <label for="name">CNPJ:</label>
                    <input type="text" class="form-control" required id="cnpj" name="cnpj" placeholder="Digite o cnpj (Só os números)..." maxlength="14" minlength="14" pattern="\d*" oninput="onlyNumbers(event)">
                </div>
                <h2>Dados do ativo:</h2>
                <div class="form-group">
                    <label for="name">Nome:</label>
                    <input type="text" class="form-control" required id="asset_name" name="asset_name" placeholder="Digite o nome do ativo...">
                </div>
                <div class="form-group">
                    <label for="description">Descrição:</label>
                    <input type="text" class="form-control" required id="asset_description" name="asset_description" placeholder="Digite a descrição do ativo...">
                </div>
                <div class="form-group">
                    <label for="category">Categoria:</label>
                    <input type="text" class="form-control" required id="asset_category" name="asset_category" placeholder="Digite a categoria do ativo...">
                </div>
                <div class="form-group">
                    <label for="date-acquisition">Data de Aquisição:</label>
                    <input type="date" class="form-control" required id="asset_acquisition_date" name="asset_acquisition_date" placeholder="Digite a data de aquisição do ativo...">
                </div>
                <div class="form-group">
                    <label for="value">Valor:</label>
                    <input type="number" class="form-control" required id="asset_value" name="asset_value" placeholder="Digite o valor do ativo..." oninput="no_negativeNumbers(event)">
                </div>
                <div class="form-group">
                    <label for="type">Tipo:</label>
                    <select name="asset_type">
                        <option value="Material">Físico</option>
                        <option value="Imaterial">Não Físico</option>
                    </select>
                </div>
                <div class="form-group">
                    <h2>Localização do Ativo:</h2>
                    <label for="localization">Rua:</label>
                    <input type="text" class="form-control" required id="street" name="street" placeholder="Digite a rua em que o ativo se encontra...">
                </div>
                <div class="form-group">
                    <label for="localization">Número:</label>
                    <input type="number" class="form-control" required id="num" name="num" placeholder="Digite o número em que o ativo se encontra...">
                </div>
                <div class="form-group">
                    <label for="localization">Bairro:</label>
                    <input type="text" class="form-control" required id="neighborhood" name="neighborhood" placeholder="Digite o bairro em que o ativo se encontra...">
                </div>
                <div class="form-group">
                    <label for="localization">Cidade:</label>
                    <input type="text" class="form-control" required id="city" name="city" placeholder="Digite a cidade em que o ativo se encontra...">
                </div>
                <div class="form-group">
                    <label for="localization">Estado:</label>
                    <input type="text" class="form-control" required id="state" name="state" placeholder="Digite o estado em que o ativo se encontra...">
                </div>
                <div class="form-group">
                    <label for="localization">País:</label>
                    <input type="text" class="form-control" required id="country" name="country" placeholder="Digite o país em que o ativo se encontra...">
                </div>
            </div>
            <!-- Inputs invisiveis para passar !-->
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<script>
    new Vue({
        el: '#app',
        data: {
            selectedPType: 'Física',
        }
    });
</script>
@endsection
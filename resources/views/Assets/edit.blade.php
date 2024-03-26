@extends('layouts.main')

@section('title', 'Editar Ativo')

@section('content')
<div id="app">
    <div class="col-md-6 offset-md-3" id="ativo-create-ativo">
        <h2>Formulário de Edição do ativo</h2>
        <form action="/assets/{{ $AssetsData->asset_id }}/update" method="post">
            @csrf
            @method('PUT')
            <h2>Dados da pessoa responsável pelo ativo:</h2>
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" class="form-control" value="{{ $AssetsData->person_name }}" required id="name" name="person_name" placeholder="Digite o nome da pessoa responsável pelo ativo...">
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
                <input type="text" class="form-control" value="{{ $AssetsData->identification }}" required id="cpf" name="cpf" placeholder="Digite o cpf (Só os números)" maxlength="11" minlength="11" pattern="\d*" oninput="onlyNumbers(event)">
            </div>
            <div class="form-group" v-if="selectedPType === 'Jurídica'">
                <label for="name">CNPJ:</label>
                <input type="text" class="form-control" value="{{ $AssetsData->identification }}" required id="cnpj" name="cnpj" placeholder="Digite o cnpj (Só os números)..." maxlength="14" minlength="14" pattern="\d*" oninput="onlyNumbers(event)">
            </div>
            <h2>Dados do ativo</h2>
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" class="form-control" value="{{ $AssetsData->asset_name }}" required id="asset_name" name="asset_name" placeholder="Digite o nome do ativo...">
            </div>
            <div class="form-group">
                <label for="description">Descrição:</label>
                <input type="text" class="form-control" value="{{ $AssetsData->asset_category }}" required id="asset_description" name="asset_description" placeholder="Digite a descrição do ativo...">
            </div>
            <div class="form-group">
                <label for="category">Categoria:</label>
                <input type="text" class="form-control" value="{{ $AssetsData->asset_category }}" required id="asset_category" name="asset_category" placeholder="Digite a categoria do ativo...">
            </div>
            <div class="form-group">
                <label for="date-acquisition">Data de Aquisição:</label>
                <input type="date" class="form-control" value="{{ $AssetsData->asset_acquisition_date }}" required id="asset_acquisition_date" name="asset_acquisition_date" placeholder="Digite a data de aquisição do ativo...">
            </div>
            <div class="form-group">
                <label for="value">Valor:</label>
                <input type="number" class="form-control" value="{{ $AssetsData->asset_value }}" required id="asset_value" name="asset_value" placeholder="Digite o valor do ativo..." oninput="no_negativeNumbers(event)">
            </div>
            <div class="form-group">
                <label for="type">Tipo:</label>
                <select v-model="selectedAType" name="asset_type">
                    <option value="Físico">Físico</option>
                    <option value="Não_Físico">Não Físico</option>
                </select>
            </div>
            <div class="form-group">
                <h2>Localização do Ativo:</h2>
                <label for="localization">Rua:</label>
                <input type="text" class="form-control" value="{{ $AssetsData->street }}" required id="street" name="street" placeholder="Digite a rua em que o ativo se encontra...">
            </div>
            <div class="form-group">
                <label for="localization">Número:</label>
                <input type="number" class="form-control" value="{{ $AssetsData->number }}" required id="num" name="num" placeholder="Digite o número em que o ativo se encontra...">
            </div>
            <div class="form-group">
                <label for="localization">Bairro:</label>
                <input type="text" class="form-control" value="{{ $AssetsData->neighborhood }}" required id="neighborhood" name="neighborhood" placeholder="Digite o bairro em que o ativo se encontra...">
            </div>
            <div class="form-group">
                <label for="localization">Cidade:</label>
                <input type="text" class="form-control" value="{{ $AssetsData->city }}" required id="city" name="city" placeholder="Digite a cidade em que o ativo se encontra...">
            </div>
            <div class="form-group">
                <label for="localization">Estado:</label>
                <input type="text" class="form-control" value="{{ $AssetsData->state }}" required id="state" name="state" placeholder="Digite o estado em que o ativo se encontra...">
            </div>
            <div class="form-group">
                <label for="localization">País:</label>
                <input type="text" class="form-control" value="{{ $AssetsData->country }}" required id="country" name="country" placeholder="Digite o país em que o ativo se encontra...">
            </div>
            <div class="form-group">
                <input type="text" hidden class="form-control" value="{{ $AssetsData->localization_id }}" required name="localization_id">
                <input type="text" hidden class="form-control" value="{{ $AssetsData->person_id }}" required name="person_id" >
            </div>
            <button type="submit" class="btn btn-success">Atualizar</button>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<script>
    new Vue({
        el: '#app',
        data: {
            selectedPType: '{{ $AssetsData->person_type }}',
            selectedAType: '{{ $AssetsData->asset_type }}'
        }

    });
</script>
@endsection
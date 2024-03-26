@extends('layouts.main')

@section('title', 'Gerenciar assets')

@section('content')

<h2 onclick='show_filterForm()'>Filtrar 
  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filter" viewBox="0 0 16 16">
    <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5"/>
  </svg>
</h2>
<div id="app">
  <form action="/assets/filtrate" method="get" id="filter-form" v-show="filterItem !== '#'">
    @csrf
    <div class="form-group">
      <p>Filtrar por:</p>
      <select v-model="filterItem" name="filterItem">
        <option value="#">Escolha o item de filtragem</option>
        <option value="name">Nome</option>
        <option value="type">Tipo</option>
      </select>
    </div>
    <div class="form-group" v-if="filterItem === 'name'">
      <button type="submit" name="filter" value="A-Z" class="filter-buttons">A-Z</button><br>
      <button type="submit" name="filter" value="Z-A" class="filter-buttons">Z-A</button><br>
    </div>
    <div class="form-group" v-if="filterItem === 'type'">
      <button type="submit" name="filter" value="physic" class="filter-buttons">Físicos</button><br>
      <button type="submit" name="filter" value="non_physic" class="filter-buttons">Não físicos</button><br>
    </div>
  </form>
</div>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Nome do Proprietário</th>
      <th scope="col">Tipo de Pessoa do Proprietário</th>
      <th scope="col">Identificação do Proprietário</th>
      <th scope="col">Nome</th>
      <th scope="col">Descrição</th>
      <th scope="col">Categoria</th>
      <th scope="col">Data de Aquisição</th>
      <th scope="col">Tipo</th>
      <th scope="col">Localização</th>
      <th scope="col">Valor</th>
      <th scope="col">Ações</th>
    </tr>
  </thead>
  <tbody>
    @foreach($AssetsData as $AssetData)
    <tr>
      <td>{{ $AssetData->person_name }}</td> <!-- Aqui exibe o nome do proprietário -->
      <td>{{ $AssetData->person_type }}</td> <!-- Aqui exibe o tipo de pessoa do proprietário -->
      <td>{{ $AssetData->identification }}</td> <!-- Aqui exibe a identificação do proprietário -->
      <td>{{ $AssetData->asset_name }}</td>
      <td>{{ $AssetData->asset_description }}</td>
      <td>{{ $AssetData->asset_category }}</td>
      <td>{{ $AssetData->asset_acquisition_date }}</td>
      <td>{{ $AssetData->asset_type }}</td>
      <td>{{ $AssetData->street }}, {{ $AssetData->number }}, {{ $AssetData->neighborhood }}, {{ $AssetData->city }}, {{ $AssetData->state }}, {{ $AssetData->country }}</td>
      <td>{{ $AssetData->asset_value }}</td>
      <td class="d-flex">
        <a href="{{ route('assets.edit', ['id' => $AssetData->asset_id]) }}" class="btn btn-primary">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0
            0 0 0 1 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
          </svg>
        </a>
    <form action="{{ route('assets.destroy', ['id' => $AssetData->asset_id]) }}" method="post">
      @csrf
      @method('delete')
      <button type="submit" class="btn btn-danger">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
          <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
          <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 
          0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
          </svg>
        </button>
      </form>
    </td>
  </tr>
@endforeach
</tbody>
</table>
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<script>
new Vue({
  el: '#app',
  data: {
    filterItem: '#',
    filter: ''
    }
});
</script>
@endsection

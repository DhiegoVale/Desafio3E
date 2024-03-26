<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

// Incluir as Models que serão utilizadas
use App\Models\Asset;
use App\Models\Localization;
use App\Models\Natural_Person;
use App\Models\Legal_Person;

class MainController extends Controller
{
    // Função para levar para a página inicial
    public function index()
    {
        return view('welcome');
    }
    // Função para levar para o formulário de cadastro de ativos
    public function create()
    {
        return view('Assets.create');
    }
    //Função para inserir os dados do ativo, localização e pessoa
    public function store(Request $request)
    {
        // Criar um novo Ativo
        $Asset = new Asset;
        // Criar uma nova Localização
        $Localization = new Localization;
        // Criar uma nova Pessoa
        $Person = new Person;

        // Inserir os dados da localização no banco
        $Localization->street = $request->street;
        $Localization->number = $request->num;
        $Localization->neighborhood = $request->neighborhood;
        $Localization->city = $request->city;
        $Localization->state = $request->state;
        $Localization->country = $request->country;
        $Localization->save();
        // Resgata o Id da última localização inserida
        $Localization_id = $Localization->id;

        // Inserir os dados do responsável pelo ativo
        $Person->person_name = $request->person_name;
        $Person->person_type = $request->person_type;
        $Person->save();
        // Resgata o Id do ultimo usuário inserido
        $Person_id = $Person->id;

        // Verificar qual o tipo de pessoa(Física ou Jurídica) e inserir o cpf(Pessoa física) ou o cnpj(Pessoa jurídica)
        if ($request->person_type === 'Física') {
            $NaturalPerson = new Natural_Person;
            $NaturalPerson->person_id = $Person_id;
            $NaturalPerson->cpf = $request->cpf;
            $NaturalPerson->save();
        } elseif ($request->person_type === 'Jurídica') {
            $LegalPerson = new Legal_Person;
            $LegalPerson->person_id = $Person_id;
            $LegalPerson->cnpj = $request->cnpj;
            $LegalPerson->save();
        }
        //Inserir os dados na tabela dos ativos (Assets)
        $Asset->localization_id = $Localization_id;
        $Asset->person_id = $Person_id;
        $Asset->asset_name = $request->asset_name;
        $Asset->asset_description = $request->asset_description;
        $Asset->asset_category = $request->asset_category;
        $Asset->asset_acquisition_date = $request->asset_acquisition_date;
        $Asset->asset_value = $request->asset_value;
        $Asset->asset_type = $request->asset_type;
        $Asset->save();
        //Redirecionar para a página inicial e exibir uma mensagem de sucesso
        return redirect('/')->with('msg', 'Ativo inserido com sucesso!');
    }
    // Função para exibir os dados dos ativos no dashboard
    public function show()
    {
        // Resgatar todos os registros da tabela dos ativos (Assets), localizações (Localizations) e pessoas (Persons)
        $AssetsData = Asset::select('localizations.*', 'persons.*', 'assets.*')
            ->join('localizations', 'assets.localization_id', '=', 'localizations.localization_id')
            ->join('persons', 'assets.person_id', '=', 'persons.person_id')
            ->leftJoin('natural_persons', 'assets.person_id', '=', 'natural_persons.person_id')
            ->leftJoin('legal_persons', 'assets.person_id', '=', 'legal_persons.person_id')
            ->selectRaw('IFNULL(natural_persons.cpf, legal_persons.cnpj) AS identification')
            ->get();

        // Passar os resultados para a view para exibição
        return view('Assets.view', ['AssetsData' => $AssetsData]);
    }
    public function edit($id)
    {
        // Faz uma consulta para resgatar os dados do ativo selecionado por meio do ID
        $AssetsData = Asset::select('localizations.*', 'persons.*', 'assets.*')
            ->join('localizations', 'assets.localization_id', '=', 'localizations.localization_id')
            ->join('persons', 'assets.person_id', '=', 'persons.person_id')
            ->leftJoin('natural_persons', 'assets.person_id', '=', 'natural_persons.person_id')
            ->leftJoin('legal_persons', 'assets.person_id', '=', 'legal_persons.person_id')
            ->selectRaw('IFNULL(natural_persons.cpf, legal_persons.cnpj) AS identification')
            ->where('asset_id', $id)
            ->first();
        // Verifica se a consulta possui resultado
        if (!empty ($AssetsData)) {
            // Se sim, envia os dados para uma view de edição, que contém um form para editar os dados
            return view('Assets.edit', ['AssetsData' => $AssetsData]);
        } else {
            // Se não, redireciona o usuário para o dashboard
            return redirect()->route('Assets.view');
        }
    }
    public function update(Request $request, $id)
    {
        // Resgata o Id da Localização
        $localizationId = $request->localization_id;

        // Resgata o id da pessoa responsável pelo ativo
        $PersonId = $request->person_id;

        // Resgata o cpf ou cnpj
        if (isset ($request->cpf)) {
            $cpf = $request->cpf;
            $PersonName = $request->person_name;

            $VerifyCpf = Natural_Person::select('persons.person_name', 'natural_persons.*')
                ->join('persons', 'natural_persons.person_id', '=', 'persons.person_id')
                ->where('natural_persons.cpf', $cpf)
                ->first();

            if ($VerifyCpf) {
                if ($VerifyCpf->person_name === $PersonName) {
                    $PersonId = $VerifyCpf->person_id; // Atualiza $PersonId com o ID encontrado
                } else {
                    return redirect()->route('assets.show')->with('msg', 'Esse cpf pertence a outra pessoa!');
                }
            } else {
                // Nenhum registro com o CPF fornecido foi encontrado
                $Person = new Person;
                $Person->person_name = $request->person_name;
                $Person->person_type = $request->person_type;
                $Person->save();

                // Resgata o ID do último usuário inserido
                $PersonId = $Person->id; // Atualiza $PersonId com o ID inserido

                // Verifica o tipo de pessoa (Física ou Jurídica) e insere o CPF (Pessoa física) ou o CNPJ (Pessoa jurídica)
                $NaturalPerson = new Natural_Person;
                $NaturalPerson->person_id = $PersonId;
                $NaturalPerson->cpf = $request->cpf;
                $NaturalPerson->save();
            }
        }       // Verifica se o CNPJ foi fornecido no request
        elseif (isset ($request->cnpj)) {
            $cnpj = $request->cnpj;
            $PersonName = $request->person_name;
            // Verifica se já existe uma pessoa jurídica com o CNPJ fornecido
            $VerifyCnpj = Legal_Person::where('cnpj', $cnpj)->first();
            if ($VerifyCnpj) {
                if ($VerifyCnpj->person_name === $PersonName) {
                    $PersonId = $VerifyCnpj->person_id; // Atualiza $PersonId com o ID encontrado
                } else {
                    return redirect()->route('assets.show')->with('msg', 'Esse cnpj pertence a outra pessoa!');
                }
            } else {
                // Nenhum registro com o CNPJ fornecido foi encontrado
                $Person = new Person;
                $Person->person_name = $request->person_name;
                $Person->person_type = $request->person_type;
                $Person->save();

                // Resgata o ID da última pessoa inserida
                $PersonId = $Person->id; // Atualiza $PersonId com o ID inserido

                // Cria uma nova pessoa jurídica
                $LegalPerson = new Legal_Person;
                $LegalPerson->person_id = $PersonId;
                $LegalPerson->cnpj = $request->cnpj;
                $LegalPerson->save();
            }


            // Resgata os dados que irão ser atualizados na localização
            $LocalizationData = [
                'street' => $request->street,
                'number' => $request->num,
                'neighborhood' => $request->neighborhood,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
            ];

            // Resgata os dados que irão ser atualizados nos ativos
            $AssetData = [
                'localization_id' => $localizationId,
                'person_id' => $PersonId, // Certifique-se de que $PersonId está definido corretamente
                'asset_name' => $request->asset_name,
                'asset_description' => $request->asset_description,
                'asset_category' => $request->asset_category,
                'asset_acquisition_date' => $request->asset_acquisition_date,
                'asset_type' => $request->asset_type,
                'asset_value' => $request->asset_value,
            ];

            // Atualiza a tabela das localizações com os novos dados
            Localization::where('localization_id', $localizationId)->update($LocalizationData);

            // Atualiza a tabela dos ativos com os novos dados
            Asset::where('asset_id', $id)->update($AssetData);

            return redirect()->route('assets.show')->with('msg', 'Asset atualizado com sucesso!');
        }
    }
    // Função para deltar o ativo
    public function destroy($id)
    {
        // Deleta o ativo como o Id correspondente
        // O id foi passado pela rota
        Asset::where('asset_id', $id)->delete();
        return redirect()->route('assets.show')->with('msg', 'Asset deletado com sucesso!');
    }
    public function filtrate(Request $request)
    {
        // Resgata o item de filtragem
        $filterItem = $request->filterItem;
        // resgata o filtro
        $filter = $request->filter;
        // Verifica se os parâmetros de filtro foram fornecidos corretamente
        $Assets = Asset::query();
        if ($filterItem && $filter) {
            // Aplica a ordenação com base no filtro escolhido
            // FILtragens por nome
            if ($filterItem === 'name') {
                // Ordenar por ordem alfábetica
                if ($filter === 'A-Z') {
                    $Assets->orderBy('asset_name');
                }
                // Ordenar por ordem alfábetica invertida
                elseif ($filter === 'Z-A') {
                    $Assets->orderByDesc('asset_name');
                }
                // Filtragens pela data de aquisição
            }elseif ($filterItem === 'type') {
                // Mostrar ativos físicoss
                if ($filter === 'physic') {
                    $Assets->where('asset_type', 'Material');
                } elseif ($filter === 'non_physic') {
                    $Assets->where('asset_type', 'Imaterial');
                }
            }
        }
        // Recupera os Assets filtrados e ordenados
        $AssetsData = $Assets->select('localizations.*', 'persons.*', 'assets.*')
        ->join('localizations', 'assets.localization_id', '=', 'localizations.localization_id')
        ->join('persons', 'assets.person_id', '=', 'persons.person_id')
        ->leftJoin('natural_persons', 'persons.person_id', '=', 'natural_persons.person_id')
        ->leftJoin('legal_persons', 'persons.person_id', '=', 'legal_persons.person_id')
        ->selectRaw('IFNULL(natural_persons.cpf, legal_persons.cnpj) AS identification')
        ->get();
        // Passa os Assets para a view para exibição
        return view('Assets.filter_view', compact('AssetsData'));
    }
    public function search(Request $request)
    {
        // Resgata o nome do ativo para fazer a busca
        $search = $request->search;

        // Resgata todos os campos da o ativo que possui aquele nome
        $AssetsData = Asset::where('asset_name', 'like', "%$search%")
        ->select('localizations.*', 'persons.*', 'assets.*')
        ->join('localizations', 'assets.localization_id', '=', 'localizations.localization_id')
        ->join('persons', 'assets.person_id', '=', 'persons.person_id')
        ->leftJoin('natural_persons', 'assets.person_id', '=', 'natural_persons.person_id')
        ->leftJoin('legal_persons', 'assets.person_id', '=', 'legal_persons.person_id')
        ->selectRaw('IFNULL(natural_persons.cpf, legal_persons.cnpj) AS identification')
        ->get();
        // Passar os Assets para a view para exibição
        return view('Assets.filter_view', compact('AssetsData'));
    }
}
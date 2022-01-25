@extends('layout')
@section('cabecalho')
Séries
@endsection

@section('conteudo')
@if(!empty($mensagem))
<div class="alert alert-success">{{ $mensagem }}</div>
@endif
        <a href="{{ route('series.create') }}" class="btn btn-dark mb-2">Adicionar</a>
        <ul class="list-group">
        @foreach($series as $serie)
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <div>
        @if ($serie->capa)
        <img src="{{ env('APP_URL') . '/storage/' . $serie->capa }}"  class="img-thumbnail" alt="" height="100px" width="100px">
        @else
        <img src="{{ Storage::url('series/sem-imagem.jpeg') }}" class="img-thumbnail" alt="" height="100px" width="100px">
        @endif
        <span id="nome-serie-{{ $serie->id }}">{{ $serie->nome }}</span>
        </div>

        <div class="input-group w-50" hidden id="input-nome-serie-{{ $serie->id }}">
            <input type="text" class="form-control" value="{{ $serie->nome }}">
            <div class="input-group-append">
                <button class="btn btn-primary" onclick="editarSerie({{ $serie->id }})">
                    Confirmar
                </button>
                @csrf
            </div>
        </div>

    <div class="d-flex justify-content-end">

        <button class="btn btn-info mr-1" onclick="toggleInput({{ $serie->id }})">
            Editar
        </button>

        <a href="/series/{{ $serie->id }}/temporadas" class="btn btn-info mr-1">
           Temporadas
        </a>

        <form method="post" class="m-0" action="/series/remover/{{ $serie->id }}" onsubmit="return confirm('Tem certeza que deseja remover {{ addslashes($serie->nome) }}?')">
            @csrf
            @method('DELETE')

            <button class="btn btn-danger">
                Excluir
            </button>

        </form>



    </div>

</li>
@endforeach
        </ul>


@endsection
<script>
    function toggleInput(serieId) {
    const nomeSerieEl = document.getElementById(`nome-serie-${serieId}`);
    const inputSerieEl = document.getElementById(`input-nome-serie-${serieId}`);
    if (nomeSerieEl.hasAttribute('hidden')) {
        nomeSerieEl.removeAttribute('hidden');
        inputSerieEl.hidden = true;
    } else {
        inputSerieEl.removeAttribute('hidden');
        nomeSerieEl.hidden = true;
    }
}


function editarSerie(serieId) {
    let formData = new FormData();
    const nome = document
        .querySelector(`#input-nome-serie-${serieId} > input`)
        .value;
    const token = document
        .querySelector(`input[name="_token"]`)
        .value;
    formData.append('nome', nome);
    formData.append('_token', token);
    const url = `/series/${serieId}/editaNome`;
    fetch(url, {
        method: 'POST',
        body: formData
    }).then(() => {
        toggleInput(serieId);
        document.getElementById(`nome-serie-${serieId}`).textContent = nome;
    });
}
</script>

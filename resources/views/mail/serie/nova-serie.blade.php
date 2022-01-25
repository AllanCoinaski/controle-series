
<!-- Utilizando view normal
<html>
<body>
<h1>Nova Série</h1>
Nome da Série: {{$nome}} <br>
Qtd de temporadas: {{$qtdTemporadas}} <br>
Nome de episódios  {{$qtdEpisodios}} <br>

</body>
</html>
-->

<!--Utilizando markdown https://www.markdownguide.org/ -->

@component('mail::message')
#Nova Série
### Nome da Série: {{$nome}}
### Qtd Temporadas: {{$qtdTemporadas}}
### Qtd Episódios: {{$qtdEpisodios}}
@endcomponent

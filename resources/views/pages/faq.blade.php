@extends('layouts.marketing')
@section('title', 'FAQ · Pagina-IA')

@section('content')
<h2 class="text-3xl font-extrabold">Preguntas frecuentes</h2>
<p class="text-white/70 mt-2">Respuestas directas.</p>

<div class="mt-8 grid gap-4">
@foreach([
  ['q'=>'¿Es tienda con pagos?', 'a'=>'No, es un mostrador. Pagos se agregan después.'],
  ['q'=>'¿Admin y cliente?', 'a'=>'Sí. Cada uno tiene su dashboard.'],
  ['q'=>'¿Se guardan tickets?', 'a'=>'Sí, en MySQL, y el admin los ve.'],
  ['q'=>'¿Es seguro?', 'a'=>'Roles protegidos, validación y throttle anti-spam.'],
] as $f)
  <div class="glass rounded-2xl p-5 card-hover">
      <p class="font-semibold">{{ $f['q'] }}</p>
      <p class="text-white/70 mt-2">{{ $f['a'] }}</p>
  </div>
@endforeach
</div>
@endsection

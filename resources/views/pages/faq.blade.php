@extends('layouts.marketing')
@section('title', 'FAQ · GVelarde')

@section('content')
<h2 class="text-3xl font-extrabold">Preguntas frecuentes</h2>
<p class="text-white/70 mt-2">Respuestas directas.</p>

<div class="mt-8 grid gap-4">
@foreach([
  [
    'q' => '¿Qué tipo de inteligencias artificiales ofrece la plataforma?',
    'a' => 'La plataforma ofrece acceso a diversas herramientas de inteligencia artificial orientadas a productividad, automatización y creación de contenido, según disponibilidad.'
  ],
  [
    'q' => '¿Las inteligencias artificiales son originales?',
    'a' => 'Se brindan accesos funcionales y verificados. Las características pueden variar de acuerdo con la herramienta y el plan contratado.'
  ],
  [
    'q' => '¿Las cuentas son permanentes?',
    'a' => 'El acceso se otorga por el período establecido en el plan adquirido. La vigencia depende del tipo de servicio contratado.'
  ],
  [
    'q' => '¿El uso es ilimitado?',
    'a' => 'Las condiciones de uso dependen de cada herramienta y del tipo de acceso disponible. Pueden existir límites operativos.'
  ],
  [
    'q' => '¿Necesito conocimientos técnicos para usarlas?',
    'a' => 'No. La plataforma está diseñada para ser utilizada de forma sencilla por cualquier tipo de usuario.'
  ],
  [
    'q' => '¿Cada usuario tiene su propio panel?',
    'a' => 'Sí. Cada cliente dispone de un panel donde puede consultar el estado de su acceso y la información relevante del servicio.'
  ],
  [
    'q' => '¿La plataforma cuenta con soporte?',
    'a' => 'Se brinda soporte básico para incidencias generales y orientación sobre el uso de la plataforma.'
  ],
] as $f)
  <div class="glass rounded-2xl p-5 card-hover">
      <p class="font-semibold">{{ $f['q'] }}</p>
      <p class="text-white/70 mt-2">{{ $f['a'] }}</p>
  </div>
@endforeach
</div>
@endsection

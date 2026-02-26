@props([
'post' => null,
'delete' => null,
'put' => null,
'flat' => false
])

@php
$method = ($post or $put or $delete) ? 'POST' : 'GET';
@endphp

<form {{ $attributes->class(['flex flex-col gap-4' => ! $flat]) }} method="{{ $method }}">
  @if ($method != 'GET')
  @csrf
  @endif

  @if ($put)
  @method('PUT')
  @endif


  @if ($delete)
  @method('DELETE')
  @endif

  {{ $slot }}
</form>
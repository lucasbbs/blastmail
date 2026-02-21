<x-layouts.app>
  <x-slot name="header">
    <x-h2>{{ __('Email List') }} > {{ $emailList->title }} > {{ __('Subscribers') }}</x-h2>
  </x-slot>

  <x-card class="space-y-4">
    <div class="flex justify-between">
      <x-button.link secondary :href="route('email-list.index')">
        {{ __('Back to lists') }}
      </x-button.link>

      <x-form :action="route('subscribers.index', $emailList)" class="w-2/5">
        <x-input.text name="search" :placeholder="__('Search')" :value="$search" class="w-full" />
      </x-form>
    </div>

    <x-table :headers="['#', __('Name'), __('Email')]">
      <x-slot name="body">
        @foreach ($subscribers as $subscriber)
        <tr>
          <x-table.td>{{ $subscriber->id }}</x-table.td>
          <x-table.td>{{ $subscriber->name }}</x-table.td>
          <x-table.td>{{ $subscriber->email }}</x-table.td>
        </tr>
        @endforeach
      </x-slot>

    </x-table>

    {{ $subscribers->links() }}
  </x-card>
</x-layouts.app>

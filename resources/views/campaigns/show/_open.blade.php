<div class="space-y-4">
  <x-form action="{{ route('campaigns.show', ['campaign' => $campaign, 'what' => $what]) }}" get class="items-end">
    <x-input.text class="w-2/5" name="search" placeholder="{{ __('Search an email...') }}" value="{{ $search }}" />
  </x-form>

  <x-table :headers="[__('Name'), __('# Opens'), __('Email')]">
    <x-slot name="body">
      <tr>
        <x-table.td>Jeremias</x-table.td>
        <x-table.td>1</x-table.td>
        <x-table.td>jeremias@email.com</x-table.td>
      </tr>
    </x-slot>

  </x-table>

  {{-- {{ $campaigns->links() }} --}}
</div>
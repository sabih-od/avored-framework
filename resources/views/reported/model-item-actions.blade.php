<div class="flex">
    <x-avored::link url="{{ route('admin.reported.item.show', [$type, $item]) }}" title="View">
        <i class="fa fa-eye" aria-hidden="true"></i>
    </x-avored::link>
    <x-avored::form.form action="{{ route('admin.reported.item.destroy',  [$type, $item]) }}"
                         method="DELETE">
        <button class=" ml-3"
                title="Delete"
                type="submit"><i class="fa fa-trash"></i>
        </button>
    </x-avored::form.form>
</div>

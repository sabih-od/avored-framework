<x-avored::table.cell>
    {{ ($item->reported_count ?? 0) + ($item->reported_ignored_count ?? 0) }}
</x-avored::table.cell>

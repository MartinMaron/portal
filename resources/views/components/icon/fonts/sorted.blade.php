@props([
    'value' => 'none',
])
@if ($value === 'asc')
    <i class="fa-solid fa-sort-up"></i>
@elseif ($value === 'desc')
    <i class="fa-solid fa-sort-down"></i>
@else
    <i class="fa-solid fa-sort"></i>
@endif
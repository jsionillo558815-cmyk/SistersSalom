@php
    $map = [
        'pending'   => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
        'confirmed' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
        'completed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
        'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
        'paid'      => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
        'unpaid'    => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
    ];
    $class = $map[$status] ?? 'bg-gray-100 text-gray-800';
@endphp
<span class="px-2 py-1 rounded text-xs font-medium {{ $class }}">{{ ucfirst($status) }}</span>

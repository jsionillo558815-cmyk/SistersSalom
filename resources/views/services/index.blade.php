<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl salon-text-gradient leading-tight tracking-tight">
                Services Management
            </h2>
            <a href="{{ route('services.create') }}" class="salon-btn-primary px-5 py-2.5 text-sm">
                Add Service
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="salon-alert-success px-6 py-4 mb-4 animate-fade-in-up">
                    {{ session('success') }}
                </div>
            @endif

            <div class="salon-card">
                <div class="salon-table-container">
                    <table class="salon-table">
                        <thead class="salon-table-header">
                            <tr>
                                <th>#</th>
                                <th>Service Name</th>
                                <th>Price</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="salon-table-body">
                            @forelse($services as $service)
                                <tr class="salon-table-row">
                                    <td class="salon-text-muted">
                                        {{ $services->firstItem() + $loop->index }}
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="salon-avatar h-10 w-10 text-lg">
                                                {{ substr($service->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="salon-text-bold text-base">{{ $service->name }}</div>
                                                <div class="salon-text-muted text-xs mt-0.5">{{ Str::limit($service->description, 60) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="salon-text-bold">
                                        &#8369;{{ number_format($service->price, 2) }}
                                    </td>
                                    <td>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium text-sm">
                                            {{ $service->duration_label }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($service->is_active)
                                            <span class="salon-badge-success px-3 py-1">
                                                <span class="salon-badge-success-dot"></span>
                                                Active
                                            </span>
                                        @else
                                            <span class="salon-badge-inactive px-3 py-1">
                                                <span class="salon-badge-inactive-dot"></span>
                                                Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('services.edit', $service) }}" class="p-2 text-indigo-600 hover:text-indigo-900 hover:bg-indigo-50 dark:text-indigo-400 dark:hover:text-indigo-300 dark:hover:bg-indigo-900/30 rounded-lg transition-colors font-medium" title="Edit">
                                                Edit
                                            </a>
                                            <form action="{{ route('services.destroy', $service) }}" method="POST" class="inline" onsubmit="return confirm('Delete this service?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2 text-rose-600 hover:text-rose-900 hover:bg-rose-50 dark:text-rose-400 dark:hover:text-rose-300 dark:hover:bg-rose-900/30 rounded-lg transition-colors font-medium" title="Delete">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="salon-empty-state">
                                            <p class="salon-empty-title">No services found.</p>
                                            <a href="{{ route('services.create') }}" class="mt-2 text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 font-medium hover:underline inline-flex items-center gap-1">
                                                Add your first service
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($services->hasPages())
                    <div class="salon-pagination">
                        {{ $services->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>

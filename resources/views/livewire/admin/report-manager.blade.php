<div>
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Moderation Queue</h2>
        <p class="text-sm text-gray-500">Review flagged examples from the community.</p>
    </div>

    @if (session()->has('message'))
    <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-lg">
        {{ session('message') }}
    </div>
    @endif

    <div class="space-y-4">
        @forelse($reports as $report)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-soft border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex flex-col md:flex-row gap-6">

                <!-- Report Info -->
                <div
                    class="md:w-1/4 space-y-2 border-b md:border-b-0 md:border-r border-gray-100 dark:border-gray-700 pb-4 md:pb-0">
                    <div>
                        <span class="text-xs font-bold text-red-500 uppercase tracking-wide">Report Reason</span>
                        <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $report->reason }}</p>
                    </div>
                    <div class="text-sm text-gray-500">
                        Date: {{ $report->created_at->format('d M Y, H:i') }}
                    </div>
                    {{-- Assuming 'user' relation on Report points to the reporter --}}
                    {{-- <div class="text-xs text-gray-400">
                        Reporter ID: {{ $report->user_id }}
                </div> --}}
            </div>

            <!-- Content Preview -->
            <div class="md:w-2/4">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">Reported Content</span>
                @if($report->example)
                <div
                    class="mt-2 p-4 bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700">
                    <p class="text-gray-800 dark:text-gray-200 italic">"{{ $report->example->content }}"</p>
                    <div class="mt-3 flex items-center gap-2 text-xs text-gray-500">
                        <span>Verb: <strong
                                class="text-primary">{{ $report->example->verb->infinitive ?? 'Unknown' }}</strong></span>
                        <span class="mx-1">•</span>
                        <span>Author: {{ $report->example->user->username ?? 'Unknown' }}</span>
                    </div>
                </div>
                @else
                <div class="mt-2 p-4 bg-red-50 text-red-600 rounded-lg text-sm">
                    Make has been deleted or is unavailable.
                </div>
                @endif
            </div>

            <!-- Actions -->
            <div class="md:w-1/4 flex flex-col gap-2 justify-center">
                <button wire:click="dismissReport({{ $report->id }})"
                    class="w-full px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-sm font-medium">
                    Dismiss Report
                </button>

                @if($report->example)
                <button wire:click="deleteContent({{ $report->id }})"
                    class="w-full px-4 py-2 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 rounded-lg hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors text-sm font-medium">
                    Delete Content
                </button>
                @endif
            </div>

        </div>
    </div>
    @empty
    <div
        class="text-center py-6 lg:py-12 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700">
        <svg class="w-12 h-12 text-green-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">All Good!</h3>
        <p class="text-gray-500">No pending reports at the moment.</p>
    </div>
    @endforelse
</div>

<div class="mt-6">
    {{ $reports->links() }}
</div>
</div>
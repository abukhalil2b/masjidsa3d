@props(['taskStatus', 'student'])

<x-modal name="evaluate-task-{{ $taskStatus->task->id }}" focusable x-data="{
    achievedPoint: {{ $taskStatus->achieved_point ?? 'null' }},
    initialPoint: {{ $taskStatus->achieved_point ?? 'null' }},
    loading: false,
    error: null,
    success: false,

    resetForm() {
        this.achievedPoint = this.initialPoint;
        this.error = null;
        this.success = false;
    },

    async submitEvaluation() {
        this.loading = true;
        this.error = null;
        this.success = false;

        try {
            const response = await fetch('{{ route('student_tasks.evaluate.store') }}', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    student_id: {{ $student->id }},
                    task_id: {{ $taskStatus->task->id }},
                    achieved_point: this.achievedPoint,
                })
            });

            if (!response.ok) {
                const err = await response.json();
                throw new Error(err.message || '{{ __('Failed to save evaluation.') }}');
            }

            const data = await response.json();
            this.success = true;
            this.initialPoint = data.achieved_point;

            // Update the UI without refreshing the page
            const row = document.querySelector(`tr[data-task-id='${data.task_id}']`);
            if (row) {
                row.querySelector('.points-display').textContent = data.achieved_point ?? '0';
                row.querySelector('.points-display').classList.toggle('text-green-600', data.achieved_point > 0);
                row.querySelector('.points-display').classList.toggle('text-gray-500', !(data.achieved_point > 0));

                const statusCell = row.querySelector('.status-badge');
                statusCell.innerHTML = data.is_done
                    ? `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">{{ __('Completed') }}</span>`
                    : `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">{{ __('Incomplete') }}</span>`;

                row.querySelector('.date-display').textContent = data.done_at ? new Date(data.done_at).toISOString().split('T')[0] : '-';

                document.querySelector('.total-points').textContent = data.total_achieved_points;
            }

            setTimeout(() => {
                this.$dispatch('close');
            }, 1000);

        } catch (e) {
            this.error = e.message || '{{ __('An error occurred while saving the evaluation. Please try again.') }}';
            console.error('Evaluation Error:', e);
        } finally {
            this.loading = false;
        }
    }
}" x-on:close="resetForm()">
    <div class="p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">
            {{ __('Evaluate Task:') }} <span class="text-indigo-600">{{ $taskStatus->task->title }}</span>
        </h2>

        <div class="mb-6">
            <p class="text-gray-700 mb-3">
                {{ __('Choose achieved points (Max:') }} {{ $taskStatus->task->point }} {{ __('points):') }}
            </p>

            <div class="flex flex-wrap gap-3 mb-4">
                @for ($i = 0; $i <= $taskStatus->task->point; $i++)
                    <button type="button" x-on:click="achievedPoint = {{ $i }}"
                        :class="{'bg-indigo-600 text-white shadow-md': achievedPoint == {{ $i }},
                                'bg-gray-100 text-gray-800 hover:bg-gray-200': achievedPoint != {{ $i }}}"
                        class="w-12 h-12 rounded-lg font-semibold text-lg transition-all duration-200 flex items-center justify-center">
                        {{ $i }}
                    </button>
                @endfor

                <button type="button" x-on:click="achievedPoint = null"
                    :class="{'bg-red-600 text-white shadow-md': achievedPoint === null,
                             'bg-gray-100 text-gray-800 hover:bg-gray-200': achievedPoint !== null}"
                    class="w-12 h-12 rounded-lg font-semibold text-sm transition-all duration-200 flex items-center justify-center">
                    {{ __('Clear') }}
                </button>
            </div>

            <div class="text-center py-3 px-4 bg-gray-50 rounded-lg">
                <span class="text-gray-600">{{ __('Selected Points:') }}</span>
                <span x-text="achievedPoint === null ? '{{ __('Not selected') }}' : achievedPoint"
                    class="text-xl font-bold ml-2"
                    :class="achievedPoint > 0 ? 'text-green-600' : 'text-gray-500'"></span>
            </div>
        </div>

        <template x-if="error">
            <div class="mb-4 p-3 bg-red-50 text-red-700 rounded-lg text-sm" x-text="error"></div>
        </template>

        <template x-if="success">
            <div class="mb-4 p-3 bg-green-50 text-green-700 rounded-lg text-sm">
                ✅ {{ __('Evaluation saved successfully!') }}
            </div>
        </template>

        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
            <x-secondary-button x-on:click="$dispatch('close')" type="button" :disabled="loading">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-primary-button x-on:click="submitEvaluation()" :disabled="loading || achievedPoint === initialPoint">
                <template x-if="loading">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                    </svg>
                </template>
                <span x-text="loading ? '{{ __('Saving...') }}' : '{{ __('Save Evaluation') }}'"></span>
            </x-primary-button>
        </div>
    </div>
</x-modal>
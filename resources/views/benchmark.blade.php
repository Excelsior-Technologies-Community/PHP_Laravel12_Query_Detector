@extends('layouts.app')

@section('title', 'Query Performance Benchmark')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@section('content')

<div class="container mx-auto px-4 py-8">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            Query Performance Benchmark
        </h1>

        <p class="mt-2 text-gray-600">
            Compare N+1 queries, eager loading, and optimized Eloquent queries.
        </p>
    </div>

    {{-- Performance Summary --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-sm text-gray-500">
                N+1 Queries
            </p>

            <h2 class="text-3xl font-bold text-red-600 mt-2">
                {{ $results['n1']['queries'] }}
            </h2>

            <p class="text-sm text-gray-500 mt-2">
                {{ $results['n1']['time'] }} ms
            </p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-sm text-gray-500">
                Eager Loading
            </p>

            <h2 class="text-3xl font-bold text-yellow-600 mt-2">
                {{ $results['eager']['queries'] }}
            </h2>

            <p class="text-sm text-gray-500 mt-2">
                {{ $results['eager']['time'] }} ms
            </p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-sm text-gray-500">
                Optimized Query
            </p>

            <h2 class="text-3xl font-bold text-green-600 mt-2">
                {{ $results['optimized']['queries'] }}
            </h2>

            <p class="text-sm text-gray-500 mt-2">
                {{ $results['optimized']['time'] }} ms
            </p>
        </div>

    </div>

    {{-- Improvement --}}
    <div class="bg-white rounded-xl shadow p-6 mb-8">

        <h2 class="text-xl font-semibold text-gray-800 mb-3">
            Performance Improvement
        </h2>

        <div class="flex items-center gap-4">

            <div class="text-4xl font-bold text-green-600">
                {{ $improvement }}%
            </div>

            <p class="text-gray-600">
                improvement from the N+1 approach to the optimized query.
            </p>

        </div>

    </div>

    {{-- Benchmark Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

        {{-- Query Count Chart --}}
        <div class="bg-white rounded-xl shadow p-6">

            <h2 class="text-xl font-semibold text-gray-800 mb-2">
                Query Count Comparison
            </h2>

            <p class="text-sm text-gray-500 mb-6">
                Lower query count indicates better database efficiency.
            </p>

            <div class="relative h-80">
                <canvas id="queryCountChart"></canvas>
            </div>

        </div>

        {{-- Execution Time Chart --}}
        <div class="bg-white rounded-xl shadow p-6">

            <h2 class="text-xl font-semibold text-gray-800 mb-2">
                Execution Time Comparison
            </h2>

            <p class="text-sm text-gray-500 mb-6">
                Lower execution time indicates better performance.
            </p>

            <div class="relative h-80">
                <canvas id="executionTimeChart"></canvas>
            </div>

        </div>

    </div>

    {{-- Best Approach --}}
    <div class="bg-white rounded-xl shadow p-6 mb-8">

        <div class="flex items-center gap-4">

            <div class="text-4xl">
                🏆
            </div>

            <div>
                <h2 class="text-xl font-semibold text-gray-800">
                    Best Performing Approach
                </h2>

                <p class="text-gray-600 mt-1">
                    Optimized Query
                    —
                    {{ $results['optimized']['queries'] }} queries
                    ·
                    {{ $results['optimized']['time'] }} ms
                </p>

                <p class="text-green-600 font-semibold mt-2">
                    {{ $improvement }}% lower execution time than the N+1 approach
                </p>
            </div>

        </div>

    </div>

    {{-- Comparison Table --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <div class="px-6 py-5 border-b">
            <h2 class="text-xl font-semibold text-gray-800">
                Query Comparison
            </h2>
        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-gray-100">

                    <tr>
                        <th class="px-6 py-4 text-left">
                            Approach
                        </th>

                        <th class="px-6 py-4 text-left">
                            Query Count
                        </th>

                        <th class="px-6 py-4 text-left">
                            Execution Time
                        </th>

                        <th class="px-6 py-4 text-left">
                            Result
                        </th>
                    </tr>

                </thead>

                <tbody>

                    @foreach ($results as $result)

                    <tr class="border-t">

                        <td class="px-6 py-4 font-medium">
                            {{ $result['label'] }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $result['queries'] }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $result['time'] }} ms
                        </td>

                        <td class="px-6 py-4">

                            @if ($result['label'] === 'N+1 Query')

                            <span class="text-red-600 font-semibold">
                                Poor
                            </span>

                            @elseif ($result['label'] === 'Eager Loading')

                            <span class="text-yellow-600 font-semibold">
                                Improved
                            </span>

                            @else

                            <span class="text-green-600 font-semibold">
                                Optimized
                            </span>

                            @endif

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

<script>
    const labels = [
        'N+1 Query',
        'Eager Loading',
        'Optimized Query'
    ];

    const queryCounts = [
        {{ $results['n1']['queries'] }},
        {{ $results['eager']['queries'] }},
        {{ $results['optimized']['queries'] }}
    ];

    const executionTimes = [
        {{ $results['n1']['time'] }},
        {{ $results['eager']['time'] }},
        {{ $results['optimized']['time'] }}
    ];

    // Query Count Chart
    new Chart(document.getElementById('queryCountChart'), {
        type: 'bar',

        data: {
            labels: labels,

            datasets: [{
                label: 'Number of Queries',
                data: queryCounts,

                borderWidth: 1
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            plugins: {
                legend: {
                    display: false
                }
            },

            scales: {
                y: {
                    beginAtZero: true,

                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });

    // Execution Time Chart
    new Chart(document.getElementById('executionTimeChart'), {
        type: 'bar',

        data: {
            labels: labels,

            datasets: [{
                label: 'Execution Time (ms)',
                data: executionTimes,

                borderWidth: 1
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            plugins: {
                legend: {
                    display: false
                }
            },

            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection


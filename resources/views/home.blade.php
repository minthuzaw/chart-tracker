<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/argon-design-system-free@1.2.0/assets/css/argon-design-system.min.css">

</head>
<body>

<div class="container mt-5">
    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="alert-text">{{ session('success') }}</span>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card card-body text-center shadow-sm">
                <form action="{{ route('data.store') }}" method="POST">
                    @csrf
                    <input type="text" class="btn btn-dark m-2 text-white" placeholder="topic" name="topic">
                    <input type="number" class="btn btn-dark m-2 text-white" placeholder="amount" name="amount">
                    <input type="date" class="btn btn-dark m-2 text-white" name="date">
                    <select name="type" id="" class="btn btn-dark m-2">
                        <option value="income">Income</option>
                        <option value="outcome">Outcome</option>
                    </select>
                    <button type="submit" class="btn btn-success">submit</button>
                </form>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            <div class="card card-body shadow-sm">
                <ul class="list-group">
                    @foreach($data as $d)
                        <li class="list-group-item d-flex justify-content-between">
                            <div class="">
                                {{ $d->topic }} <br>
                                <small class="text text-muted">
                                    {{ $d->date }}
                                </small>
                            </div>
                            @if($d->type === 'income')
                                <div class="text text-success">
                                    + {{ $d->amount }}Ks
                                </div>
                            @else
                                <div class="text text-danger">
                                    - {{ $d->amount }}Ks
                                </div>
                            @endif

                        </li>
                    @endforeach
                    <div class="d-flex justify-content-center mt-2">{{ $data->links() }}</div>
                </ul>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-body shadow-sm p-5">
                <div class="d-flex justify-content-between">
                    <h5>Chart</h5>
                    <div>
                        <small class="text-success">Incomes : + {{ $totalIncomes }}Ks</small>
                        <small class="text-danger ml-3">Outcomes : - {{ $totalOutcomes }}Ks</small>
                    </div>
                </div>
                <hr class="p-0 m-0">
                <div>
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($dayArray),
            datasets: [
                {
                    label: '# Incomes',
                    data: @json($incomeAmount),
                    borderWidth: 1,
                    backgroundColor: '#2DCE89'
                },
                {
                    label: '# Outcomes',
                    data: @json($outcomeAmount),
                    borderWidth: 1,
                    backgroundColor: '#F5365C'
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

</html>

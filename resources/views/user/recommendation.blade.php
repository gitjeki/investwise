<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Investment Recommendation - Investment DSS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #e0ffe0, #ffffe0);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar {
            background-color: #f8f9fa;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .content {
            flex-grow: 1;
            padding: 20px;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .table-responsive {
            margin-top: 20px;
        }
        .result-section {
            display: {{ isset($finalScores) ? 'block' : 'none' }}; /* Show only if results exist */
        }
        .form-group label {
            font-weight: bold;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('user.dashboard') }}">User Panel</a>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <span class="navbar-text me-3">
                            Welcome, {{ Auth::user()->name }} (User)
                        </span>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="content container">
        <h1 class="mb-4 text-center">Investment Recommendation System (SMART Method)</h1>

        <div class="card p-4">
            <h3 class="mb-3">Jawab Pertanyaan untuk Menentukan Preferensi Anda</h3>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('user.recommendation.calculate') }}" method="POST">
                @csrf
                @foreach($criterias as $criteria)
                    <div class="mb-4 form-group">
                        <label for="C{{ $criteria->id }}_answer" class="form-label">
                            {{ $criteria->code }}: {{ $criteria->question }}
                        </label>
                        <select class="form-select" id="C{{ $criteria->id }}_answer" name="C{{ $criteria->id }}_answer" required>
                            <option value="">Pilih Jawaban Anda</option>
                            @foreach($criteria->subCriterias as $subCriteria)
                                <option value="{{ $subCriteria->id }}"
                                    {{ old('C' . $criteria->id . '_answer') == $subCriteria->id ? 'selected' : '' }}>
                                    {{ $subCriteria->option_text }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endforeach
                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">Get Recommendation</button>
                </div>
            </form>
        </div>

        @if(isset($finalScores))
            <div class="result-section mt-5">
                <div class="card p-4 mb-4">
                    <h3 class="mb-3">Your Preferences & Calculated Weights</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    @foreach($criterias as $criteria)
                                        <th>{{ $criteria->name }} ({{ $criteria->code }})</th>
                                    @endforeach
                                    <th>Total Bobot Preferensi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach($criterias as $criteria)
                                        <td>
                                            @php
                                                $selectedOption = $criteria->subCriterias->firstWhere('id', $userSelectedOptions['C' . $criteria->id . '_answer']);
                                                echo $selectedOption ? $selectedOption->option_text . ' (' . $selectedOption->weight . ')' : '-';
                                            @endphp
                                        </td>
                                    @endforeach
                                    <td>{{ array_sum($userWeights) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3 class="mt-4 mb-3">Normalized Weights (N)</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    @foreach($criterias as $criteria)
                                        <th>{{ $criteria->name }} ({{ $criteria->code }})</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach($criterias as $criteria)
                                        <td>{{ number_format($normalizedWeights[$criteria->code], 8) }}</td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card p-4 mb-4">
                    <h3 class="mb-3">Step 1: Utility Values (ui(ai))</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Alternative</th>
                                    @foreach($criterias as $criteria)
                                        <th>{{ $criteria->name }} ({{ $criteria->code }})</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($utilityValues as $altName => $utilities)
                                    <tr>
                                        <td>{{ $altName }}</td>
                                        @foreach($criterias as $criteria)
                                            <td>{{ number_format($utilities[$criteria->code], 3) }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card p-4 mb-4">
                    <h3 class="mb-3">Step 2: Weighted Results (Hasil = ui(ai) x N)</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Alternative</th>
                                    @foreach($criterias as $criteria)
                                        <th>{{ $criteria->name }} ({{ $criteria->code }})</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($calculationSteps as $altName => $data)
                                    <tr>
                                        <td>{{ $altName }}</td>
                                        @foreach($criterias as $criteria)
                                            <td>{{ number_format($data['weighted_results'][$criteria->code], 3) }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card p-4">
                    <h3 class="mb-3">Final Recommendation Ranking (SMART = ΣHasil)</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Alternative</th>
                                    <th>Jenis</th>
                                    <th>Final Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rankedRecommendations as $altName => $data)
                                    <tr>
                                        <td><span class="badge {{ $data['rank'] == 1 ? 'bg-success' : 'bg-secondary' }}">{{ $data['rank'] }}</span></td>
                                        <td>{{ $altName }}</td>
                                        <td>{{ $data['type'] }}</td>
                                        <td>{{ number_format($data['score'], 3) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Liste des Examens à Corriger</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Titre de l'examen</th>
                                    <th>Nombre de questions</th>
                                    <th>Questions corrigées</th>
                                    <th>Total des points</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($examens as $examen)
                                <tr>
                                    <td>{{ $examen->titre }}</td>
                                    <td>{{ $examen->questions->count() }}</td>
                                    <td>
                                        {{ $examen->questions->whereNotNull('awarded_points')->count() }}
                                        /
                                        {{ $examen->questions->count() }}
                                    </td>
                                    <td>
                                        {{ $examen->questions->sum('awarded_points') ?? 0 }}
                                        /
                                        {{ $examen->questions->sum('points') }}
                                    </td>
                                    <td>
                                        <a href="{{ route('examens.correction', $examen->id) }}" 
                                           class="btn btn-primary btn-sm">
                                            <i class="fas fa-check"></i> Corriger
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/French.json"
            }
        });
    });
</script>
@endpush 
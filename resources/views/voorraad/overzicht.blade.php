@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-md-6">
                <h1 class="h2">Overzicht Productvoorraden</h1>
            </div>
            <div class="col-md-6 text-right">
                <form action="{{ route('voorraad.overzicht') }}" method="GET" class="form-inline float-right">
                    <select name="categorie" class="form-control mr-2">
                        <option value="">Selecteer Categorie</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Toon Voorraad</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Productnaam</th>
                                <th>Categorie</th>
                                <th>Aantal</th>
                                <th>Houdbaarheidsdatum</th>
                                <th>Magazijn</th>
                                <th>Voorraad Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($voorraad && count($voorraad) > 0)
                                @foreach ($voorraad as $item)
                                    <tr>
                                        <td>{{ $item->ProductNaam ?? '~' }}</td>
                                        <td>{{ $item->Categorie ?? '~' }}</td>
                                        <td>{{ $item->Aantal ?? '~' }}</td>
                                        <td>{{ $item->Houdbaarheidsdatum ?? '~' }}</td>
                                        <td>{{ $item->Magazijn ?? '~' }}</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-info">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Geen gegevens beschikbaar</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ url('/home') }}" class="btn btn-primary">Home</a>
        </div>
    </div>
@endsection

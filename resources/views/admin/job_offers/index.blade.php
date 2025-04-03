@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="page-title mb-4">Job Offers</h1>
    <a href="{{ route('job_offers.create') }}" class="btn btn-primary mb-3 action-btn">Add new job offer</a>

    <table class="table table-responsive table-styled">
        <thead>
            <tr>
                <th class="table-cell">Job</th>
                <th class="table-cell">Employer</th>
                <th class="table-cell">Offer Price</th>
                <th class="table-cell">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jobOffers as $jobOffer)
                <tr>
                    <td class="table-cell">{{ $jobOffer->job->title }}</td>
                    <td class="table-cell">{{ $jobOffer->user->name }}</td>
                    <td class="table-cell">{{ $jobOffer->offer_price }}</td>
                    <td class="table-cell">
                        <a href="{{ route('job_offers.edit', $jobOffer->id) }}" class="btn btn-warning action-btn">Edit</a>
                        <form action="{{ route('job_offers.destroy', $jobOffer->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger action-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

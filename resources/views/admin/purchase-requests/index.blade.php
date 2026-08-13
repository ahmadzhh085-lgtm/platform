@extends('layouts.admin')

@section('title', 'Purchase Requests')

@section('content')
    @include('partials.flash-messages')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Purchase Requests</h4>
    </div>

    <div class="card shadow-sm rounded">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Project</th>
                        <th>Requester</th>
                        <th>Buyer</th>
                        <th>Phone</th>
                        <th>Offer</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purchaseRequests as $request)
                        <tr>
                            <td>{{ $request->id }}</td>
                            <td>{{ $request->project?->name ?? '-' }}</td>
                            <td>{{ $request->user?->name ?? 'No user' }}</td>
                            <td>{{ $request->buyer_name }}</td>
                            <td>{{ $request->buyer_phone }}</td>
                            <td>${{ number_format((float) $request->offer_amount, 2) }}</td>
                            <td>
                                @if($request->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($request->status === 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.purchase-requests.show', $request) }}" class="btn btn-sm btn-info">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">No purchase requests found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-white py-2">
            {{ $purchaseRequests->links() }}
        </div>
    </div>
@endsection

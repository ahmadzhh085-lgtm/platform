@extends('layouts.admin')

@section('title', 'Purchase Request Details')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Purchase Request Details</h4>
        <a href="{{ route('admin.purchase-requests.index') }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="card shadow-sm rounded">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <p><strong>Project:</strong> {{ $purchaseRequest->project?->name ?? '-' }}</p>
                    <p><strong>Submitted By User:</strong> {{ $purchaseRequest->user?->name ?? 'No user linked' }}</p>
                    <p><strong>User Email:</strong> {{ $purchaseRequest->user?->email ?? '-' }}</p>
                    <p><strong>Buyer Name:</strong> {{ $purchaseRequest->buyer_name }}</p>
                    <p><strong>Phone:</strong> {{ $purchaseRequest->buyer_phone }}</p>
                    <p><strong>Email:</strong> {{ $purchaseRequest->buyer_email }}</p>
                    <p><strong>National ID:</strong> {{ $purchaseRequest->buyer_national_id }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Offer Amount:</strong> ${{ number_format((float) $purchaseRequest->offer_amount, 2) }}</p>
                    <p><strong>Status:</strong>
                        @if($purchaseRequest->status === 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($purchaseRequest->status === 'approved')
                            <span class="badge bg-success">Approved</span>
                        @else
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </p>
                    <p><strong>Requested By:</strong> {{ $purchaseRequest->user?->name ?? 'Guest' }}</p>
                    <p><strong>Reviewed By:</strong> {{ $purchaseRequest->reviewer?->name ?? 'Not reviewed yet' }}</p>
                    <p><strong>Reviewed At:</strong> {{ $purchaseRequest->reviewed_at ? $purchaseRequest->reviewed_at->format('Y-m-d H:i') : 'Not yet' }}</p>
                </div>
            </div>

            <div class="mt-4">
                <h6>Notes</h6>
                <p class="mb-0">{{ $purchaseRequest->notes ?: 'No notes provided.' }}</p>
            </div>
        </div>
    </div>

    @if($purchaseRequest->status === 'pending')
        <div class="card shadow-sm rounded mt-4">
            <div class="card-body">
                <h5 class="mb-3">Admin Decision</h5>
                <form action="{{ route('admin.purchase-requests.update', $purchaseRequest) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="status" class="form-label">Decision</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="admin_notes" class="form-label">Admin Notes</label>
                        <textarea name="admin_notes" id="admin_notes" rows="4" class="form-control" placeholder="Enter notes for the buyer..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Decision</button>
                </form>
            </div>
        </div>
    @endif
@endsection

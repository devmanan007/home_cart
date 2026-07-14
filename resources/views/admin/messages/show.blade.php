@extends('layouts.admin')

@section('title', 'Message')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Message from {{ $message->name }}</h4>
            <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Back
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-2">Name</dt>
                    <dd class="col-sm-10">{{ $message->name }}</dd>

                    <dt class="col-sm-2">Email</dt>
                    <dd class="col-sm-10">
                        <a href="mailto:{{ $message->email }}">{{ $message->email }}</a>
                    </dd>

                    <dt class="col-sm-2">Subject</dt>
                    <dd class="col-sm-10">{{ $message->subject }}</dd>

                    <dt class="col-sm-2">Received</dt>
                    <dd class="col-sm-10">{{ $message->created_at->format('F d, Y \a\t h:i A') }}</dd>

                    <dt class="col-sm-2">Message</dt>
                    <dd class="col-sm-10">
                        <p class="mb-0" style="white-space: pre-wrap;">{{ $message->message }}</p>
                    </dd>
                </dl>
            </div>
        </div>

        <div class="mt-3">
            <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Delete this message?')">
                    <i class="bi bi-trash me-1"></i>Delete Message
                </button>
            </form>
        </div>
    </div>
@endsection

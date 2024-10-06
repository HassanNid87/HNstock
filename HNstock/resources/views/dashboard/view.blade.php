@extends('base')
@php
    use App\Enums\TimeBreakdown;
@endphp

@section('title', 'Dashboard')


@push('custom-style')
    <style>
        .dropdown-menu.summaryDropDown {
            margin-left: -4rem !important;
        }
    </style>
@endpush


@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body position-relative">
                <h3 class="card-title mb-4">
                    Summary (new)

                    <div class="dropdown float-end">
                        <span class="text-muted" id="summaryDropDown" data-bs-toggle="dropdown" aria-haspopup="true"
                            role="button" aria-expanded="false"> Daily <i class="mdi mdi-chevron-down ms-1"></i></span>
                        <div class="dropdown-menu summaryDropDown" aria-labelledby="summaryDropDown">
                            @foreach (TimeBreakdown::cases() as $time)
                            <span role="button" data-type="{{ $time->value }}"
                                class="dropdown-item">{{ $time->getText() }}</span>
                            @endforeach
                        </div>
                    </div>
                </h3>

                <div id="summarySection">
                </div>

                {{-- @include('dashboard.inc.summary.summary') --}}
            </div>
        </div>

    </div>
@endsection

@push('custom-script')
    <script>
        const summarySection = $("#summarySection");

        // type can be : t,w,m,y
        const loadSummary = (type) => {
            summarySection.html(loadingHtml);

            $.ajax({
                url: "{{ route('dashboard.load-summary') }}",
                data: {
                    period : type
                },
                success: (content) => {
                    summarySection.html(content) ;
                },
            });
        }


        $(document).ready(() => {
            loadSummary('t'); // today by default
        });


        $(".summaryDropDown .dropdown-item").click(function() {
            const period = $(this).data('type');
            loadSummary(period);
        });
    </script>
@endpush
